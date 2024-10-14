<?php

namespace App\Console\Commands;

use App\Models\UserModel;
use Illuminate\Console\Command;

class DisplayUsersWithPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:display {--page=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display all users with their respective passwords using pagination';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Get the current page from the option
        $currentPage = $this->option('page');

        // Define how many users per page
        $perPage = 10;

        // Fetch users with their passwords, paginated
        $users = UserModel::with('passwords')->paginate($perPage, ['*'], 'page', $currentPage);

        if ($users->isEmpty()) {
            $this->info('No users found.');
            return;
        }

        // Prepare data for the table
        $data = [];
        foreach ($users as $user) {
            foreach ($user->passwords as $password) {
                $data[] = [
                    'User Name'    => $user->name,
                    'Phone'        => $user->phone,
                    'Address'      => $user->address,
                    'Platform'     => $password->platform,
                    'Password'     => $password->password,
                ];
            }
        }

        // Display the data in a table format
        // $this->table(
        //     ['User Name', 'Phone', 'Address', 'Platform', 'Password'],
        //     $data
        // );
        foreach ($data as $item) {
            $this->info("User Name: " . $item['User Name']);
            $this->info("Phone: " . $item['Phone']);
            $this->info("Address: " . $item['Address']);
            $this->info("Platform: " . $item['Platform']);
            $this->info("Password: " . $item['Password']);
            $this->info("---------------");
        }        

        // Display pagination links and details
        $this->info('Page ' . $users->currentPage() . ' of ' . $users->lastPage());
        if ($users->hasMorePages()) {
            $this->info('To view the next page, run the command with --page=' . ($users->currentPage() + 1));
        }
    }
}
