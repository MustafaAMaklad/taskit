<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
        User::factory()->state([
            'username' => 'manager',
            'role' => Role::ASSIGNOR
        ])
            ->create();

        User::factory()->state([
            'username' => 'assignee1',
            'role' => Role::ASSIGNEE
        ])
            ->create();

        User::factory()->state([
            'username' => 'assignee2',
            'role' => Role::ASSIGNEE
        ])
            ->create();
    }
}
