<?php

use Illuminate\Database\Seeder;
use App\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $permissions = Permission::defaultPermissions();
        // foreach ($permissions as $perms) {
        //     Permission::firstOrCreate(['name' => $perms]);
        // }
        // $this->command->info('Default Permissions added.');
        $this->call(PassTableSeeder::class);

    }
}
