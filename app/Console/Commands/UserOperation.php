<?php

namespace App\Console\Commands;

use App\Models\NewUser;
use Illuminate\Console\Command;

class UserOperation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:operations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform CRUD operations on new_user table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Select an operation to perform:');
        $this->info('1. Display Users');
        $this->info('2. Update User');
        $this->info('3. Delete User');
        $this->info('4. Add User');
        $this->info('5. Select User');

        $choice = $this->ask('Enter your choice (1-4)');

        switch ($choice) {
            case 1:
                $this->displayUsers();
                break;
            case 2:
                $this->updateUser();
                break;
            case 3:
                $this->deleteUser();
                break;
            case 4:
                $this->addUser();
                break;
            case 5:
                $this->selectUser();
                break;
            default:
                $this->error('Invalid choice!');
                break;
        }
    }

    // Display all users
    protected function displayUsers()
    {
        $users = NewUser::all();
        if ($users->isEmpty()) {
            $this->info('No users found.');
        } else {
            $this->table(['ID', 'Name', 'Registration Number'], $users->toArray());
        }
    }
    protected function selectUser()
    {
        $registrationNumber = $this->ask('Enter user registeration number to view');
        $user = NewUser::where('registration_number', $registrationNumber)->first();
        if ($user) {
            $this->info($user);
            // $this->table(['ID', 'Name', 'Registration Number'], $user->toArray());
        } else {
            $this->info('No user found.');
        }
    }

    // Add a new user
    protected function addUser()
    {
        $name = $this->ask('Enter user name');
        $registrationNumber = $this->ask('Enter registration number');

        NewUser::create([
            'name' => $name,
            'registration_number' => $registrationNumber,
        ]);

        $this->info('User added successfully!');
    }

    // Update an existing user
    protected function updateUser()
    {
        $registrationNumber = $this->ask('Enter user registeration number to update');
        $user = NewUser::where('registration_number', $registrationNumber)->first();

        if ($user) {
            $name = $this->ask('Enter new name (leave blank to keep current name)', $user->name);
            $registrationNumber = $this->ask('Enter new registration number (leave blank to keep current)', $user->registration_number);

            $user->update([
                'name' => $name ?: $user->name,
                'registration_number' => $registrationNumber ?: $user->registration_number,
            ]);

            $this->info('User updated successfully!');
        } else {
            $this->error('User not found!');
        }
    }

    // Delete a user
    protected function deleteUser()
    {
        $registrationNumber = $this->ask('Enter user registeration number to delete');
        $user = NewUser::where('registration_number', $registrationNumber)->first();

        if ($user) {
            $user->delete();
            $this->info('User deleted successfully!');
        } else {
            $this->error('User not found!');
        }
    }
}
