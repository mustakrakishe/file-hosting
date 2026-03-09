<?php

namespace Database\Seeders;

use App\Models\File;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $currentTime = new DateTime();
        $pastTime = (clone $currentTime)->modify('-25 hours');

        File::factory()
            ->count(10)
            ->sequence(
                ['created_at' => $currentTime],
                ['created_at' => $pastTime],
            )->create();
    }
}
