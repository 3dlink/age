<?php

use Illuminate\Database\Seeder;
use App\Models\Priority;

class SeedPriorities extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('priorities')->delete();

        Priority::create([
            'name'   => 'Urgente'
        ]);

        Priority::create([
            'name'   => 'Alta'
        ]);

        Priority::create([
            'name'   => 'Media'
        ]);

        Priority::create([
            'name'   => 'Baja'
        ]);
    }
}
