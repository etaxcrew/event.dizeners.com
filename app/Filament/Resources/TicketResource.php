<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Group; // Tambahan untuk mengelompokkan komponen
use Filament\Forms\Components\Placeholder; // Tambahan untuk placeholder
use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament; // Tambahkan untuk akses ke Filament

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Event Management';
    public static function getNavigationSort(): ?int
    {
        return 3;
    }
    
    public static function form(Form $form): Form
    {
        $user = Filament::auth()->user();

        return $form
            ->schema([
                //card
                Forms\Components\Card::make()
                ->schema([
                    Forms\Components\Select::make('event_id')
                        ->label('Event Title')
                        ->relationship('event', 'title', function ($query) {
                            $user = Filament::auth()->user();
                            if ($user->role === 'organizer') {
                                return $query->where('organizer_id', $user->organizer->id ?? null);
                            }
                            return $query;
                        })
                        ->required(),

                    Forms\Components\TextInput::make('name')
                        ->label('Ticket Name')
                        ->placeholder('Nama Ticket')
                        ->required(),
                        
                    Forms\Components\DatePicker::make('ticket_date')
                        ->label('Ticket Date'),

                    Forms\Components\Textarea::make('about')
                        ->label('Description')
                        ->placeholder('Keterangan')
                        ->required(),

                    Forms\Components\TextInput::make('stock')
                        ->label('Stock')
                        ->placeholder('Jumlah Ticket')
                        ->numeric()
                        ->required(),

                    Forms\Components\TextInput::make('price')
                        ->label('Price')
                        ->placeholder('Harga (Rp)')
                        ->numeric(),

                    Forms\Components\TextInput::make('max_per_user')
                        ->label('Ticket per User')
                        ->placeholder('Maksimal Pembelian Ticket per User')
                        ->numeric()
                        ->default(1)
                        ->required(),

                    Forms\Components\TimePicker::make('open_time_at')
                        ->label('Jam Mulai (Open)'),

                    Forms\Components\TimePicker::make('closed_time_at')
                        ->label('Jam Tutup'),

                    Forms\Components\DateTimePicker::make('end_date_sale')
                        ->label('Penjualan Berakhir')
                        ->required(),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),

                    Forms\Components\Hidden::make('organizer_id')
                        ->default(function () {
                            $user = Filament::auth()->user();
                            if ($user->role === 'organizer') {
                                return $user->organizer->id ?? null;
                            } elseif ($user->role === 'admin') {
                                // Admin bisa memilih Event apa pun, organizer_id bisa diisi otomatis dari Event
                                return null;
                            }
                            return null;
                        }),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event.title')
                    ->label('Event Title')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->event->title)
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Ticket Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('ticket_date')
                    ->dateTime('d M Y')
                    ->label('Ticket Date'),
                    
                Tables\Columns\TextColumn::make('price')
                    ->formatStateUsing(function ($state) {
                        return $state == 0 ? 'Gratis' : 'Rp ' . number_format($state, 0, ',', '.');
                    }),

                Tables\Columns\TextColumn::make('stock'),
                Tables\Columns\TextColumn::make('is_active')
                    ->label('Active')
                    ->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
            ])
            ->actions([
                Tables\Actions\Action::make('viewDetails')
                    ->icon('heroicon-o-eye')
                    ->label('') // hanya ikon
                    ->tooltip('Detail')
                    ->modalHeading('Detail Ticket')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('')
                    ->form(fn ($record) => [
                        Group::make([
                            Placeholder::make('event.title')
                                ->label('Event Title')
                                ->content($record->event->title ?? '-')
                                ->columnSpan(2),

                            Placeholder::make('name')
                                ->label('Ticket Name')
                                ->content($record->name),

                            Placeholder::make('about')
                                ->label('Description')
                                ->content($record->about)
                                ->columnSpan(3),

                            Placeholder::make('ticket_date')
                                ->label('Ticket Date')
                                ->content($record->ticket_date),

                            Placeholder::make('open_time_at')
                                ->label('Jam Mulai (Open)')
                                ->content($record->open_time_at),

                            Placeholder::make('closed_time_at')
                                ->label('Jam Tutup (Closed)')
                                ->content($record->closed_time_at),

                            Placeholder::make('price')
                                ->label('Price (Rp)')
                                ->content(number_format($record->price, 0, ',', '.')),

                            Placeholder::make('stock')
                                ->label('Stock')
                                ->content($record->stock),

                            Placeholder::make('remaining')
                                ->label('Sisa Tiket')
                                ->content($record->remaining),

                            Placeholder::make('max_per_user')
                                ->label('Ticket per User')
                                ->content($record->max_per_user),

                            Placeholder::make('end_date_sale')
                                ->label('Penjualan Berakhir')
                                ->content($record->end_date_sale
                                    ? \Carbon\Carbon::parse($record->end_date_sale)->format('d M Y H:i') 
                                    : '-'),

                            Placeholder::make('is_active')
                                ->label('Active')
                                ->content($record->is_active ? 'Yes' : 'No'),
                                
                        ])->columns(3), // ✅ kolom didefinisikan di dalam Group

                    ]),

                Tables\Actions\EditAction::make()
                    ->label('') // kosongkan label
                    ->icon('heroicon-o-pencil-square')
                    ->tooltip('Edit'),

            ])
            ->defaultSort('id', 'asc')
            // ->query(
            //     Ticket::query()
            //         ->when(Filament::auth()->user()->role === 'organizer', function ($query) {
            //             $query->where('organizer_id', Filament::auth()->user()->organizer->id ?? null);
            //         })
            // )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Filter agar organizer hanya melihat tiket miliknya.
     */
    public static function getEloquentQuery(): Builder
    {
        $user = Filament::auth()->user();

        $query = parent::getEloquentQuery();

        if ($user->role === 'organizer') {
            return $query->where('organizer_id', $user->organizer->id ?? 0);
        }

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
