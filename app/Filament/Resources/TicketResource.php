<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Facades\Filament; // Tambahkan untuk akses ke Filament
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Group; // Tambahan untuk mengelompokkan komponen
use Filament\Forms\Components\Placeholder; // Tambahan untuk placeholder
use Illuminate\Database\Eloquent\Builder;

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
                        ->label('Event')
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
                    
                    Forms\Components\DateTimePicker::make('start_sale')->required()
                        ->label('Penjualan Dimulai'),

                    Forms\Components\DateTimePicker::make('end_sale')->required()
                        ->label('Penjualan Berakhir'),

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
                    
                Tables\Columns\TextColumn::make('price')
                    ->formatStateUsing(function ($state) {
                        return $state == 0 ? 'Gratis' : 'Rp ' . number_format($state, 0, ',', '.');
                    }),
                // Tables\Columns\TextColumn::make('price')
                //     ->money('IDR', locale: 'id')
                //     ->label('Price')
                //     ->sortable(),

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
                                ->content($record->event->title ?? '-'),

                            Placeholder::make('name')
                                ->label('Ticket Name')
                                ->content($record->name),

                            Placeholder::make('about')
                                ->label('Description')
                                ->content($record->about)
                                ->columnSpan(2),

                            Placeholder::make('price')
                                ->label('Price (Rp)')
                                ->content(number_format($record->price, 0, ',', '.')),

                            Placeholder::make('stock')
                                ->label('Stock')
                                ->content($record->stock),

                            Placeholder::make('start_sale')
                                ->label('Penjualan Dimulai')
                                ->content($record->start_sale 
                                    ? \Carbon\Carbon::parse($record->start_sale)->format('d M Y H:i') 
                                    : '-'),

                            Placeholder::make('end_sale')
                                ->label('Penjualan Berakhir')
                                ->content($record->end_sale
                                    ? \Carbon\Carbon::parse($record->end_sale)->format('d M Y H:i') 
                                    : '-'),

                            Placeholder::make('max_per_user')
                                ->label('Ticket per User')
                                ->content($record->max_per_user),

                            Placeholder::make('is_active')
                                ->label('Active')
                                ->content($record->is_active ? 'Yes' : 'No'),
                                
                        ])->columns(2), // ✅ kolom didefinisikan di dalam Group

                    ]),

                Tables\Actions\EditAction::make()
                    ->label('') // kosongkan label
                    ->icon('heroicon-o-pencil-square')
                    ->tooltip('Edit'),

            ])
            ->defaultSort('id', 'desc')
            ->query(
                Ticket::query()
                    ->when(Filament::auth()->user()->role === 'organizer', function ($query) {
                        $query->where('organizer_id', Filament::auth()->user()->organizer->id ?? null);
                    })
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    
    // ✅ membatasi tampilan berdasarkan siapa yang login
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
