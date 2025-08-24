<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Facades\Filament; // Tambahkan untuk akses ke Filament

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;
    
    // Redirect ke halaman index
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Filament::auth()->user();
        if ($user->role === 'organizer') {
            $data['organizer_id'] = $user->organizer->id ?? null;
        }

        return $data;
    }
}
