<?php

use Illuminate\Database\Seeder;

class RealEstatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\RealEstate::class, 5)->create();
    }
}
