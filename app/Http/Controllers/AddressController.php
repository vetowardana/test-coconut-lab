<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Address;

class AddressController extends Controller
{
    public function index()
    {
        $address = Address::get();

        return response()->json([
            'code' => '00',
            'data' => $address,
            'message' => 'Addresses has been fetched successfully'
        ]);
    }

    public function create(Request $request)
    {
        // code...
    }
}
