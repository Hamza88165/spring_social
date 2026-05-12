<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::create([
            'name'     => 'Maroc Artisan Co.',
            'industry' => 'Artisanat',
            'notes'    => 'Client depuis janvier 2025',
        ]);

        Client::create([
            'name'     => 'Riad Atlas',
            'industry' => 'Tourisme & Hôtellerie',
            'notes'    => 'Gestion Instagram et Facebook',
        ]);

        Client::create([
            'name'     => 'FèsTech',
            'industry' => 'Technologie',
            'notes'    => 'Startup locale Fès',
        ]);
    }
}