<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnalyticsSnapshot;
use Carbon\Carbon;

class AnalyticsSnapshotSeeder extends Seeder
{
    public function run(): void
    {
        $socialAccountIds = [1, 2, 3, 4];

        foreach ($socialAccountIds as $accountId) {
            $followers = rand(3000, 8000);

            for ($i = 29; $i >= 0; $i--) {
                $followers += rand(10, 150);

                AnalyticsSnapshot::create([
                    'social_account_id' => $accountId,
                    'date'              => Carbon::today()->subDays($i)->toDateString(),
                    'followers_count'   => $followers,
                    'reach'             => rand(500, 5000),
                    'impressions'       => rand(800, 8000),
                    'engagement_rate'   => round(rand(15, 70) / 10, 2),
                    'posts_count'       => rand(0, 3),
                ]);
            }
        }
    }
}