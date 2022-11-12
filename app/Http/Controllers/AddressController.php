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
        $this->middleware('permission:address-delete', ['only' => ['destroy']]);
        $this->middleware('permission:address-inisiate-default', ['only' => ['inisiateDefaultAddress']]);
        $this->middleware('permission:address-send-mail-before-delete', ['only' => ['sendMailBeforeDelete']]);
        $this->middleware('permission:address-delete-approval-page', ['only' => ['deleteApprovalPage']]);
        $this->middleware('permission:address-delete-approval-page', ['only' => ['deleteApproval']]);
    }

    public function index(Request $request)
    {
        $address = Address::get();

        return view('addresses.index', compact('address'));
    }

    public function store(AddressStoreRequest $request)
    {
        $request->merge([
            'addresses' => $request->addresses ? array_filter($request->addresses) : null
        ]);

        $validated = $request->validated();

        $collectedDefault = collect($request->default)->map(function($item, $key) {return ['default' => $item]; })->where('default', 1)->count();

        if ($collectedDefault > 1) {
            return response()->json([
                'code' => '02',
                'message' => 'Default address cannot be more than 1.'
            ]);
        }

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

    public function sendMailBeforeDelete(Request $request, $id)
    {
        $address = $this->findAddressWithId($id);
        $email = $this->sendMail($address);
        $data = $this->changeDeleteApproval($request->deleteApproval, $address);

        return response()->json([
            'code' => '00',
            'data' => $data,
            'message' => 'Delete request has been sent.'
        ]);
    }

    public function deleteApprovalPage($id)
    {
        $address = $this->findAddressWithId($id);

        return view('addresses.approval-page', compact('address'));
    }

    public function deleteApproval(Request $request, $id)
    {
        $address = $this->findAddressWithId($id);
        $data = $this->changeDeleteApproval($request->deleteApproval, $address);

        return response()->json([
            'code' => '00',
            'data' => $data,
            'message' => 'Delete request has been approved.'
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
