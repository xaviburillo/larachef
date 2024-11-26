<?php

namespace Database\Seeders;

use App\Models\Valoracion;
use App\Models\Receta;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@larachef.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $admin->roles()->attach(4, [
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@larachef.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $editor->roles()->attach(3, [
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $redactor = User::create([
            'name' => 'Redactor',
            'email' => 'redactor@larachef.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $redactor->roles()->attach(2, [
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $lector = User::create([
            'name' => 'Lector',
            'email' => 'lector@larachef.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $lector->roles()->attach(1, [
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Creación de usuarios con rol editor
        User::factory(10)
            ->create()
            ->each(function ($user) {
                $user->roles()->attach(3, [
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            });

        // Creación de usuarios con rol redactor
        User::factory(10)
            ->create()
            ->each(function ($user) {
                $user->roles()->attach(2, [
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            });

        // Creación de usuarios con rol lector
        User::factory(10)
        ->create()
        ->each(function ($user) {
            $user->roles()->attach(1, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
        });
    }
}
