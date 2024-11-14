<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Store;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exports\PackagesExport;
use Maatwebsite\Excel\Facades\Excel;

class PackageController extends Controller
{


    public function getPackageLists()
    {

        $user = auth()->user();
        $packages = Package::with('store', 'client')->paginate(10);
        $stores = Store::where('store_status', 1)->get();
        $users = Client::where('client_status', 1)->get();
        return view('package.package_lists', compact('packages', 'stores', 'users'));
    }
    public function searchStores(Request $request)
    {
        $query = $request->get('q');
        $stores = Store::where('store_status', 1)
                       ->where('name', 'like', "%{$query}%")
                       ->limit(10)
                       ->get();

        return response()->json($stores);
    }

    public function export()
    {
    return Excel::download(new PackagesExport, 'packages.xlsx');
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'package_name' => 'required|unique:packages,name|string|max:255',
            'store_id' => 'required|exists:stores,store_id',
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|string|max:255',
            'delivery_type' => 'required|string|max:255',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        $package = Package::create([
            'name' => $request->input('package_name'),
            'store_id' => $request->input('store_id'),
            'client_id' => $request->input('client_id'),
            'status' => $request->input('status'),
            'delivery_type' => $request->input('delivery_type'),
            'tracking_code' => $this->generateTrackingCode(),
        ]);


        return response()->json([
            'success' => true,
            'data' => $package,
            'message' => 'Package added successfully!'
        ]);
    }

    public function generateTrackingCode()
    {
        do {
            $randomNumber = rand(1000, 9999);
            $trackingCode = 'TRK-' . $randomNumber;
        } while (Package::where('tracking_code', $trackingCode)->exists());

        return $trackingCode;
    }
}
