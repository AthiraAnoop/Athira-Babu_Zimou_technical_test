<?php

namespace Database\Factories;

use App\Models\Package;
use App\Models\Store;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{

    protected $model = Package::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tracking_code' => $this->faker->unique()->numerify('TRK-####'),
            'name' => $this->faker->word,
            'status' => $this->faker->randomElement(['Pending', 'Shipped', 'Delivered']),
            'delivery_type' => $this->faker->randomElement(['Standard', 'Express']),
            'store_id' => Store::factory(),
            'client_id' => Client::factory(),
        ];
    }
}
