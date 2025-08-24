<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Fieldset; // Tambahkan
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action; // Tambahkan untuk aksi
use Filament\Forms\Components\Group; // Tambahan untuk mengelompokkan komponen
use Filament\Forms\Components\Select; // Tambahkan untuk dropdown
use Filament\Forms\Components\Placeholder; // Tambahan untuk placeholder
use Illuminate\Support\Carbon; // Tambahkan untuk format tanggal
use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament; // Tambahkan untuk akses ke Filament

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Event Management';
    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function form(Form $form): Form
    {
        $user = Filament::auth()->user();

        return $form
            ->schema([
                //card
                Fieldset::make('Informasi Acara')
                ->schema([
                    // Jika admin, tampilkan dropdown organizer
                    $user->role === 'admin'
                        ? Forms\Components\Select::make('organizer_id')
                            ->label('Organizer')
                            ->placeholder('Pilih Penyelenggara Event')
                            ->relationship('organizer', 'organization_name')
                            ->searchable()
                            ->preload()
                            ->required()

                        : Forms\Components\Hidden::make('organizer_id')
                        ->default(fn () => Filament::auth()->user()->organizer->id ?? null),

                    // $user->role === 'admin'
                    //     ? Forms\Components\Select::make('organizer_id')
                    //         ->label('Organizer')
                    //         ->placeholder('Pilih Penyelenggara Event')
                    //         ->relationship('organizer', 'organization_name')
                    //         ->searchable()
                    //         ->preload()
                    //         ->required()
                    //     : Forms\Components\Hidden::make('organizer_id'),

                    Forms\Components\Select::make('category_id')
                        ->relationship('category', 'name')
                        ->label('Event Category')
                        ->preload()
                        ->required(),

                    Forms\Components\TextInput::make('title')
                        ->label('Event Title')
                        ->placeholder('Judul Event')
                        ->required(),
                        
                    Forms\Components\TextInput::make('location')
                        ->label('Location')
                        ->placeholder('Lokasi'),

                    Forms\Components\Toggle::make('is_online')
                        ->label('Apakah Event Online?')
                        ->default(false),
                        
                    Forms\Components\DatePicker::make('start_date')
                        ->required(),

                    Forms\Components\DatePicker::make('end_date'),

                    Forms\Components\TimePicker::make('open_time')
                        ->required(),

                    Forms\Components\TimePicker::make('closed_time'),

                    Forms\Components\FileUpload::make('banner_path')
                        ->image()
                        ->disk('public')
                        ->directory('events') // akan simpan ke storage/app/public/posters
                        ->placeholder('Upload Poster Event')
                        ->required(),
                    
                    Forms\Components\TextArea::make('highlight')
                        ->label('Highlight')
                        ->placeholder('Sorotan Event')
                        ->rows(3)
                        ->required(),

                    Forms\Components\Repeater::make('photo')
                        ->relationship('photos')
                        ->label('Images')
                        ->schema([
                            Forms\Components\FileUpload::make('event_photo')
                                ->directory('event-photos') // akan simpan ke storage/app/public/event-photos
                                ->image(),
                        ])
                        ->collapsible()
                        ->minItems(0),
                ]),

                Fieldset::make('Deskripsi')
                ->schema([
                    Forms\Components\RichEditor::make('description')
                        ->label('')
                        ->placeholder('Berikan deskripsi lengkap tentang event ini') 
                        ->columnSpanFull(),
                        
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('organizer.organization_name')->label('Name of Organizer')->visible(function () {
                    return Filament::auth()->user()->role === 'admin';
                }),

                Tables\Columns\TextColumn::make('title')
                    ->label('Event Title')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->title)
                    ->searchable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime('d M Y')
                    ->label('Start Date'),

                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime('d M Y')
                    ->label('End Date'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'cancelled' => 'Cancelled',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'cancelled' => 'danger',
                    })
                    ->action(
                        Action::make('ubahStatus')
                            ->label('Ubah Status')
                            ->icon('heroicon-o-arrow-path')
                            ->form([
                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->required(),
                            ])
                            ->fillForm(fn ($record) => [
                                'status' => $record->status,
                            ])
                            ->action(function ($data, $record) {
                                $record->update(['status' => $data['status']]);
                            })
                            ->modalHeading('Update Status')
                            ->modalSubmitActionLabel('Save changes')
                            ->modalWidth('md')
                    )
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('viewDetails')
                    ->icon('heroicon-o-eye')
                    ->label('') // hanya ikon
                    ->tooltip('Detail')
                    ->modalHeading('Detail Event')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('')
                    ->form(fn ($record) => [
                        Group::make([
                            Placeholder::make('banner_path')
                                ->label('')
                                ->content(fn($record) => $record->banner_path
                                    ? new \Illuminate\Support\HtmlString(
                                        '<img src="' . asset('storage/' . $record->banner_path) . '"
                                        style="max-width: 100%; border-radius: 8px;" />'
                                    )
                                    : 'No poster uploaded.')
                                ->columnSpan(2),

                            Placeholder::make('organizer.organization_name')
                                ->label('Name of Organizer')
                                ->content($record->organizer->organization_name ?? '-'),

                            Placeholder::make('category.name')
                                ->label('Event Category')
                                ->content($record->category->name ?? '-'),

                            Placeholder::make('Event Title')
                                ->label('Event Title')
                                ->content($record->title)
                                ->columnSpan(2),

                            Placeholder::make('location')
                                ->label('Location')
                                ->content($record->location ?? '-'),

                            Placeholder::make('is_online')
                                ->label('Online Event')
                                ->content($record->is_online ? 'Yes' : 'No'),

                            Placeholder::make('highlight')
                                ->label('Highlight')
                                ->content($record->highlight ?? '-')
                                ->columnSpan(2),

                            Placeholder::make('start_date')
                                ->label('Start Date')
                                ->content(fn($record) =>
                                    $record->start_date
                                        ? Carbon::parse($record->start_date)->format('d M Y')
                                        : '-'
                                ),

                            Placeholder::make('end_date')
                                ->label('End Date')
                                ->content(fn($record) =>
                                    $record->end_date
                                        ? Carbon::parse($record->end_date)->format('d M Y')
                                        : '-'
                                ),

                            Placeholder::make('open_time')
                                ->content($record->open_time),

                            Placeholder::make('closed_time')
                                ->content($record->closed_time),

                            // Placeholder::make('status')
                            //     ->label('Status Event')
                            //     ->content(fn($record) => ucwords($record->status ?: 'draft')),

                            Placeholder::make('description')
                                ->label('Deskripsi')
                                ->content(fn($record) => new \Illuminate\Support\HtmlString($record->description))
                                ->columnSpan(2),

                        ])->columns(2), // ✅ kolom didefinisikan di dalam Group
                    ]),

                Tables\Actions\EditAction::make()
                    ->label('') // kosongkan label
                    ->icon('heroicon-o-pencil-square')
                    ->tooltip('Edit'),

                //Tables\Actions\EditAction::make(),
            ])
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
