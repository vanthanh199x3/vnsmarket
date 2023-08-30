<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller
{
    public function getProvinces()
    {
        $response = Http::get('https://api.ghsv.vn/v1/address/provinces');
        $data = $response->json();

        return response()->json($data['provinces']);
    }

    public function getDistricts($provinceCode)
    {
        $response = Http::post('https://api.ghsv.vn/v1/address/districts', [
            'province_code' => $provinceCode
        ]);
        $data = $response->json();

        return response()->json($data['districts']);
    }

    public function getWards($wardCode)
    {
        $response = Http::post('https://api.ghsv.vn/v1/address/wards', [
            'district_code' => $wardCode
        ]);
        $data = $response->json();

        return response()->json($data['wards']);
    }

    public function checkFeeShip(Request $request)
    {
        $data = [
            'shop_id' => $request['shop_id'],
            'to_district' => $request['to_district'],
            'to_province' => $request['to_province'],
            'to_ward' => $request['to_ward'],
            'weight' => $request['weight']
        ];
        $jsonData = json_encode($data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ghsv.vn/v1/order/calcFee',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'Token: ' . env('TOKEN_GHSV'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $responseData = json_decode($response, true);
        if(!$responseData['success'])
        {
            return "API tạo shop thất bại. Lỗi: " . $responseData['msg'] ;
        }
        else {
            return $responseData['fee'];
        }
    }
}
