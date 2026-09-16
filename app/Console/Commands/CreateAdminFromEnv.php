<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminFromEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create-from-env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the first admin account from environment variables';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = env('INITIAL_ADMIN_NAME');
        $email = env('INITIAL_ADMIN_EMAIL');
        $password = env('INITIAL_ADMIN_PASSWORD');

        if (blank($name) || blank($email) || blank($password)) {
            $this->error('Missing INITIAL_ADMIN_NAME, INITIAL_ADMIN_EMAIL, or INITIAL_ADMIN_PASSWORD.');

            return self::FAILURE;
        }

        if (User::where('email', $email)->exists()) {
            $this->error('A user with INITIAL_ADMIN_EMAIL already exists. No changes were made.');

            return self::FAILURE;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->info('Admin account created successfully.');

        return self::SUCCESS;
    }
}
