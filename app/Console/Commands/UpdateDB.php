<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UpdateDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updatedb:cron';

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
        info("Cron Job running at " . now());

        try {
            $response = Http::get('https://jsonplaceholder.typicode.com/users');

            $users = $response->json();

            if (!empty($users)) {
                foreach ($users as $key => $user) {
                    if (!User::where('email', $user['email'])->exists()) {
                        User::create([
                            'name' => $user['name'],
                            'email' => $user['email'],
                            'password' => bcrypt('123456789')
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            return ['status' => 500, 'message' => 'An error occurred: ' . $e->getMessage()];
        }
    }
}
