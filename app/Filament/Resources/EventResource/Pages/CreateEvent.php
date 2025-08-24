<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Facades\Filament; // Tambahkan untuk akses ke Filament

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    // Redirect ke halaman index
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (Filament::auth()->user()->role !== 'admin') {
            $data['organizer_id'] = Filament::auth()->user()->organizer->id ?? null;
        }

        return $data;
    }
}
