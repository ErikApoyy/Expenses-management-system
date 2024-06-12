<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager_one = User::create([
            'name'          => 'Manager One',
            'email'         => 'manager1@example.com',
            'password'      => bcrypt('P@S5W0rD'),
            'department_id' => 1,
            'position'      => 'MANAGER',
        ]);

        $manager_two = User::create([
            'name'          => 'Manager Two',
            'email'         => 'manager2@example.com',
            'password'      => bcrypt('P@S5W0rD'),
            'department_id' => 1,
            'position'      => 'MANAGER',
        ]);

        User::create([
            'name'          => 'Staff One',
            'email'         => 'staff1@example.com',
            'password'      => bcrypt('P@S5W0rD'),
            'department_id' => 1,
            'position'      => 'STAFF',
            'manager_id'    => $manager_one->id,
        ]);

        User::create([
            'name'          => 'Staff Two',
            'email'         => 'staff2@example.com',
            'password'      => bcrypt('P@S5W0rD'),
            'department_id' => 1,
            'position'      => 'STAFF',
            'manager_id'    => $manager_two->id,
        ]);

        User::create([
            'name'          => 'Head of Department',
            'email'         => 'hod@example.com',
            'password'      => bcrypt('P@S5W0rD'),
            'department_id' => 1,
            'position'      => 'HEAD OF DEPARTMENT',
        ]);

        User::create([
            'name'     => 'System Manager',
            'email'    => 'admin@example.com',
            'password' => bcrypt('P@S5W0rD'),
            'position' => 'SYSTEM MANAGER',
        ]);
    }
}
