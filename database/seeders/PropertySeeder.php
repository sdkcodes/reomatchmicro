<?php

namespace Database\Seeders;

use App\Models\Property;
use Database\Factories\PropertyFactory;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Property::factory()->count(2)->create();
    }
}
