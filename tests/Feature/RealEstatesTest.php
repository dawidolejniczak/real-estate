<?php

namespace Tests\Feature;

use App\Models\RealEstate;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase;

final class RealEstatesTest extends TestCase
{

    use DatabaseMigrations;

    public function testIndex(): void
    {
        /** @var RealEstate $realEstate */
        $realEstate = $this->_seedRealEstates()->first();

        $this
            ->get('/real-estates')
            ->assertJsonFragment([
                'id' => $realEstate->id
            ])
            ->assertJsonCount(100)
            ->assertStatus(200);

    }

    public function testShow(): void
    {
        /** @var RealEstate $realEstate */
        $realEstate = $this->_seedRealEstates()->first();

        $this
            ->get('/real-estates/' . $realEstate->id)
            ->assertJsonFragment([
                'address_line_1' => $realEstate->address_line_1
            ])
            ->assertStatus(200);
    }

    public function testStore(): void
    {
        $postRequest = $this
            ->post('/real-estates', [
                'address_line_1' => 'Test address',
                'address_line_2' => 'Test address 2',
                'city' => 'Test city',
                'postcode' => 'LS10 6RD',
            ]);


        $realEstate = RealEstate::latest()->first();

        $postRequest
            ->assertJsonFragment([
                'address_line_1' => $realEstate->address_line_1
            ])
            ->assertStatus(200);
    }

    /**
     * @return Collection
     */
    private function _seedRealEstates(): Collection
    {
        $realEstates = factory(RealEstate::class, 100)->create();

        return $realEstates;
    }
}
