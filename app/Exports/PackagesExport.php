<?php

namespace App\Exports;

use App\Models\Package;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PackagesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Package::with(['store', 'client'])->get(['tracking_code', 'name', 'status', 'delivery_type', 'store_id', 'client_id']);
    }

    public function map($package): array
    {
        static $slNo = 1;
        return [
            $slNo++,
            $package->name,
            $package->store->name,
            $package->name,
            $package->client->name,
            $package->status,
            $package->client->phone,
            $package->client->wilaya,
            $package->client->commune,
            $package->delivery_type,
            $package->tracking_code,
        ];
    }
    public function headings(): array
    {
        return [
            'SL No.',
            'Package Name',
            'Store Name',
            'Package Name (duplicate)',
            'Client Name',
            'Status',
            'Client Phone',
            'Client Wilaya',
            'Client Commune',
            'Delivery Type',
            'Tracking Code',
        ];
    }
}
