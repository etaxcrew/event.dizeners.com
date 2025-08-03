<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Fieldset; // Tambahkan
use Filament\Resources\Resource;
use Filament\Facades\Filament; // Tambahkan untuk akses ke Filament
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\BelongsToSelect; // Tambahkan
use Filament\Tables\Actions\Action; // Tambahkan untuk aksi
use Filament\Forms\Components\Group; // Tambahan untuk mengelompokkan komponen
use Filament\Forms\Components\Select; // Tambahkan untuk dropdown
use Filament\Forms\Components\Placeholder; // Tambahan untuk placeholder
use Illuminate\Support\Carbon; // Tambahkan untuk format tanggal
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        //$user = Filament::auth()->user();

        return $form
            ->schema([
                //card
                Fieldset::make('Informasi Acara')
                ->schema([
                    BelongsToSelect::make('organizer_id')
                        ->relationship('organizer', 'organization_name')
                        ->required(),

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
                        
                    Forms\Components\DateTimePicker::make('event_date')->required()
                        ->label('Event Date'),

                    Forms\Components\FileUpload::make('banner_path')
                        ->image()
                        ->disk('public')
                        ->directory('events') // akan simpan ke storage/app/public/posters
                        ->placeholder('Upload Poster Event')
                        ->required(),

                    Forms\Components\TextInput::make('video_path')
                        ->label('Video Path')
                        ->placeholder('Link Video Event')
                        ->maxLength(255),

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
                    
                    Forms\Components\TextArea::make('highlight')
                        ->label('Highlight')
                        ->placeholder('Sorotan Event')
                        ->rows(3)
                        ->required(),
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
                Tables\Columns\TextColumn::make('event_date')->dateTime()
                    ->label('Event Date'),
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
                            ->modalHeading('Perbarui Status Event')
                            ->modalSubmitActionLabel('Simpan')
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

                            Placeholder::make('event_date')
                                ->label('Event Date')
                                ->content(fn($record) =>
                                    $record->event_date
                                        ? Carbon::parse($record->event_date)->format('d M Y H:i:s')
                                        : '-'
                                ),

                            Placeholder::make('status')
                                ->label('Status')
                                ->content(fn($record) => ucwords($record->status ?: 'draft')),

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

    public static function getRelations(): array
    {
        return [
            //
        ];
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
