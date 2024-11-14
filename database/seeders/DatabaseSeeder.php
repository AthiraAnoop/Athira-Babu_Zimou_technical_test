<?php

namespace Database\Seeders;
use App\Models\Package;
use App\Models\Store;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $stores=Store::all();


        $packages = [];


        foreach ($stores as $store) {
            $storePackages = Package::factory(100)->make()->map(function ($package) use ($store) {
                return [
                    'tracking_code' => $package->tracking_code,
                    'name' => $package->name,
                    'status' => $package->status,
                    'delivery_type' => $package->delivery_type,
                    'store_id' => $store->store_id,
                    'client_id' => $package->client_id, // You can adjust how clients are assigned
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });


            $packages = array_merge($packages, $storePackages->toArray());


            if (count($packages) >= 500) {
                Package::insert($packages);
                $packages = [];
            }
        }

        if (count($packages) > 0) {
            Package::insert($packages);
        }
    }
}
