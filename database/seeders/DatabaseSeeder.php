<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // Admin padrão
        Admin::create([
            'employeeId' => null, // ou a ID de algum Employee
            'email'      => 'admin@infosi.gov.ao',
            'password'   => Hash::make('admin123'),
            'role'       => 'admin',
        ]);

    }
}
