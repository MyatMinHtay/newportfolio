<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrNew([
            'email' => 'myatminhtay7@gmail.com',
        ]);

        $admin->name = 'Myat Min Htay';
        if (! $admin->exists) {
            $admin->password = Hash::make('password123');
        }
        $admin->is_admin = true;
        $admin->email_verified_at = now();
        $admin->save();
    }
}
