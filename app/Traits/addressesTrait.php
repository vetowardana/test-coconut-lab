<?php

namespace App\Traits;

use App\Models\Address;
use DB;
use Mail;
use App\Mail\DeleteAddressNotification;
use Carbon\Carbon;

trait addressesTrait
{
    public function sendMail($address)
    {
        $data = [
            'url' => route('addresses.index', 'keyword=' . $address->addresses),
            'date' => Carbon::now()->format('F d, Y')
        ];

        Mail::to('coconutlab.adm@gmail.com')->send(new DeleteAddressNotification($data));

        return $data;
    }

    public function findAddressWithId($id)
    {
        $address = Address::findOrFail($id);

        return $address;
    }

    public function mappingAddressData($request)
    {
        $address = Address::get();
        $addresses = $request->addresses;
        foreach ($request->default as $key_default => $value_default) {
            $default[] = (int)$value_default;
        }

        if (in_array(1, $default) == true) {
            foreach ($address as $key_address => $value_address) {
                $value_address->update([
                    'default' => 0
                ]);
            }
        }

        $data = array_map(function($addresses, $default) {
            return compact('addresses', 'default');
        }, $addresses, $default);

        return $data;
    }

    public function storeAddress($data)
    {
        foreach ($data as $key_data => $value_data) {
            Address::updateOrCreate(
                [
                    'addresses' => $value_data['addresses']
                ],
                [
                    'default' => $value_data['default']
                ]
            );
        }
    }

    public function changeDefaultAddress($id)
    {
        $address = Address::findOrFail($id);

        foreach (Address::get() as $key_addresses => $value_addresses) {
            $value_addresses->update([
                'default' => 0
            ]);
        }

        if ($address->default == 0) {
            $address->update([
                'default' => 1
            ]);
        } else {
            $address->update([
                'default' => 0
            ]);
        }

        return $address;
    }
}