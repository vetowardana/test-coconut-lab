<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressStoreRequest;

use App\Models\User;
use App\Models\Address;
use App\Traits\addressesTrait;
use DB;

class AddressController extends Controller
{
    use addressesTrait;

    function __construct()
    {
        $this->middleware('permission:address-list|address-create|address-edit|address-delete|address-inisiate-default', ['only' => ['index']]);
        $this->middleware('permission:address-create', ['only' => ['create','store']]);
        $this->middleware('permission:address-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:address-delete', ['only' => ['destroy']]);
        $this->middleware('permission:address-delete', ['only' => ['destroy']]);
        $this->middleware('permission:address-inisiate-default', ['only' => ['inisiateDefaultAddress']]);
        $this->middleware('permission:address-send-mail-before-delete', ['only' => ['sendMailBeforeDelete']]);
    }

    public function index(Request $request)
    {
        $address = Address::when($request->keyword, function($query) use($request) {
            return $query->where('addresses', $request->keyword);
        })->get();

        return view('addresses.index', compact('address'));
    }

    public function store(AddressStoreRequest $request)
    {
        $request->merge([
            'addresses' => $request->addresses ? array_filter($request->addresses) : null
        ]);

        $validated = $request->validated();

        $data = $this->mappingAddressData($request);

        DB::beginTransaction();
        try {
            $this->storeAddress($data);

            DB::commit();

            return response()->json([
                'code' => '00',
                'message' => 'Address has been stored successfully.'
            ]);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $address = $this->findAddressWithId($id);
        $address->delete();

        return response()->json([
            'code' => '00',
            'message' => 'Address has been deleted successfully.'
        ]);
    }

    public function sendMailBeforeDelete($id)
    {
        $address = $this->findAddressWithId($id);
        $address = $this->sendMail($address);

        return response()->json([
            'code' => '00',
            'data' => $address,
            'message' => 'Delete request has been sent.'
        ]);
    }

    public function inisiateDefaultAddress($id)
    {
        DB::beginTransaction();
        try {
            $data = $this->changeDefaultAddress($id);

            DB::commit();

            return response()->json([
                'code' => '00',
                'data' => $data,
                'message' => 'Default address has been changed successfully.'
            ]);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
