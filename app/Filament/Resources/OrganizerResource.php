<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganizerResource\Pages;
use App\Filament\Resources\OrganizerResource\RelationManagers;
use App\Models\Organizer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class OrganizerResource extends Resource
{
    protected static ?string $model = Organizer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';
    public static function getNavigationSort(): ?int
    {
        return 8;
    }
    
    // Batasi akses
    public static function canViewAny(): bool
    {
        return Auth::user()->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //card
                Forms\Components\Card::make()
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->options(function () {
                            return \App\Models\User::where('role', 'organizer')
                                ->pluck('name', 'id');
                        })
                        // ->relationship('user', 'email')
                        ->label('User Of Organizer')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Forms\Components\TextInput::make('organization_name')
                        ->label('Organizer Name')
                        ->placeholder('Nama Penyelenggara')
                        ->required(),

                    Forms\Components\TextInput::make('phone')
                        ->label('Phone')
                        ->placeholder('Nomor Telepon'),

                    Forms\Components\Textarea::make('address')
                        ->label('Address')
                        ->placeholder('Alamat Organisasi/Perusahaan')
                        ->rows(3),

                    Forms\Components\Textarea::make('bio')
                        ->label('Bio')
                        ->placeholder('Deskripsi Singkat')
                        ->rows(3),

                    Forms\Components\FileUpload::make('logo')
                        ->image()
                        ->directory('organizer-logos'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('organization_name')
                    ->label('Organizer Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')->label('User Email'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\ImageColumn::make('logo')
                    ->height(25),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListOrganizers::route('/'),
            'create' => Pages\CreateOrganizer::route('/create'),
            'edit' => Pages\EditOrganizer::route('/{record}/edit'),
        ];
    }
}
