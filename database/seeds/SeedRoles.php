<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class SeedRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('roles')->delete();

        Role::create([
            'name'   => 'super administrador'
        ]);

        Role::create([
            'name'   => 'supervisor'
        ]);

        Role::create([
            'name'   => 'analista'
        ]);

        Role::create([
            'name'   => 'usuario'
        ]);
    }
}