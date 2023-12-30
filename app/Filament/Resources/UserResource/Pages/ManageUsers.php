<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Hash;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->action(fn(array $data) => User::create([
                'name' => $data['name'],
                'email' =>  $data['email'],
                'password' => Hash::make( $data['password'])
            ]))->slideOver()->closeModalByClickingAway(false),
        ];
    }
}
