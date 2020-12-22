<?php

use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // admin user detail
        $email      = 'admin@test.com';
        $password   = Str::random(16);

        // create user with admin access
        User::create([
            'email'             => $email,
            'email_verified_at' => now(),
            'password'          => Hash::make($password),
            'type'              => 'admin',
            'status'            => 'active',
            'is_active'         => true
        ]);

        // buat output
        $output = "Create Login Account:\n\nEmail: $email\nPassword: $password";

        // print output login
        $this->command->info($output);

        // save to file .password
        file_put_contents('.password', $output);
    }
}
