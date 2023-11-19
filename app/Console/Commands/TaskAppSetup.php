<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TaskAppSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:task-app-setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Start Setup Please Wait');
        Artisan::call('config:cache');
        Artisan::call('config:clear');
        Artisan::call('migrate:fresh');
        Artisan::call('db:seed');
        Artisan::call('passport:install');
        $this->info('Database migrated successfully ');

        $this->info('Seed admins');
        $this->output->progressStart(100);
        $admin = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);
        $admin->assignRole('admin');
        \App\Models\User::factory(99)->create()->each(function ($user){
            $user->assignRole('admin');
            $this->output->progressAdvance();

        });
        $this->output->progressFinish();
        $this->info('100 Admins created with password : 12345678');

        $this->info('Seed Users');
        $this->output->progressStart(10000);
        \App\Models\User::factory(10000)->create()->each(function ($user){
            $user->assignRole('user');
            $this->output->progressAdvance();
        });
        $this->output->progressFinish();

        $this->info('10000 users created with password : 12345678');

        $this->info('Database is seeds . roles and Fake data created successfully');

    }
}
