<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\SearchProfile;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MatchProfileTest extends TestCase
{
    public function testCanStrictMatchAtLeastOneProperty(){

        $uuid = Str::uuid();
        $property = Property::factory()->create([
            'propertyType' => $uuid,
            'fields' => [
                'price' => 20000,
                'area' => 50
            ]
        ]);

        $profile = SearchProfile::factory()->create([
            'propertyType' => $uuid,
            'searchFields' => [
                'price' => [10000, 500000]
            ]
        ]);

        
        $response = $this->getJson("api/match/{$property->id}")->dump();

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
    }

    public function testCanLooseMatchAtLeastOneProperty(){

        $uuid = Str::uuid();
        $property = Property::factory()->create([
            'propertyType' => $uuid,
            'fields' => [
                'price' => 20000,
                'area' => 70
            ]
        ]);

        $profile2 = SearchProfile::factory()->create([
            'propertyType' => $uuid,
            'searchFields' => [
                'area' => [90, 150]
            ]
        ]);

        $response = $this->getJson("api/match/{$property->id}")->dump();

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
    }

    public function testCanMatchMultipleProfiles(){
        $uuid = Str::uuid();

        $property = Property::factory()->create([
            'propertyType' => $uuid,
            'fields' => [
                'price' => 20000,
                'area' => 70,
                'heating' => 'gas'
            ]
        ]);

        $profile1 = SearchProfile::factory()->create([
            'propertyType' => $uuid,
            'searchFields' => [
                'price' => [15000, 25000],
                'area' => [90, 150]
            ]
        ]);

        $profile2 = SearchProfile::factory()->create([
            'propertyType' => $uuid,
            'searchFields' => [
                'price' => [14000, 30000],
                'area' => [60, 120],
                'parking' => true
            ]
        ]);

        $profile3 = SearchProfile::factory()->create([
            'propertyType' => $uuid,
            'searchFields' => [
                'area' => [50, 100]
            ]
        ]);

        $response = $this->getJson("api/match/{$property->id}")->dump();

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
    }
}
