<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SocialAccount;

class SocialAccountSeeder extends Seeder
{
    public function run(): void
    {
        // Client 1 - Facebook + Instagram
        SocialAccount::create([
            'client_id'        => 1,
            'platform'         => 'facebook',
            'page_id'          => 'fake_fb_page_001',
            'page_name'        => 'Maroc Artisan Co. - Facebook',
            'access_token'     => 'fake_token_001',
            'token_expires_at' => now()->addMonths(2),
        ]);

        SocialAccount::create([
            'client_id'        => 1,
            'platform'         => 'instagram',
            'page_id'          => 'fake_ig_page_001',
            'page_name'        => 'Maroc Artisan Co. - Instagram',
            'access_token'     => 'fake_token_002',
            'token_expires_at' => now()->addMonths(2),
        ]);

        // Client 2 - Facebook only
        SocialAccount::create([
            'client_id'        => 2,
            'platform'         => 'facebook',
            'page_id'          => 'fake_fb_page_002',
            'page_name'        => 'Riad Atlas - Facebook',
            'access_token'     => 'fake_token_003',
            'token_expires_at' => now()->addMonths(2),
        ]);

        // Client 3 - Instagram only
        SocialAccount::create([
            'client_id'        => 3,
            'platform'         => 'instagram',
            'page_id'          => 'fake_ig_page_003',
            'page_name'        => 'FèsTech - Instagram',
            'access_token'     => 'fake_token_004',
            'token_expires_at' => now()->addMonths(2),
        ]);
    }
}