<?php

function request($method = "GET", $path = "", $query = [], $data = null)
{
    $uri = "https://api.rajaongkir.com/starter/$path" . '?' . http_build_query($query);
    $rajaOngkirApikey = config('raja_ongkir_apikey');

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $uri,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTPHEADER => [
            "key: $rajaOngkirApikey"
        ]
    ]);

    if (!empty($data) || $method == "POST") {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            "key: $rajaOngkirApikey"
        ));
    }

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    if ($err) throw new Error("cURL Error #: $err");

    return json_decode($response);
}


function getProvince($province = null)
{
    $query = [];
    if ($province) $query = array_merge($query, ['id' => $province]);

    $response = request("GET", 'province', $query);
    return $response->rajaongkir->results;
}

function getCity($city = null, $province = null)
{
    $query = [];
    if ($city) $query = array_merge($query, ['id' => $city]);
    if ($province) $query = array_merge($query, ['province' => $province]);

    $response = request("GET", 'city', $query);
    return $response->rajaongkir->results;
}

function getOngkir($origin, $dest, $weight, $courier = "jne")
{
    $response = request("POST", 'cost', [], [
        'origin' => $origin,
        'destination' => $dest,
        'weight' => $weight,
        'courier' => $courier
    ]);
    return [
        'kota_asal' => json_decode(json_encode($response->rajaongkir->origin_details), true),
        'kota_tujuan' => json_decode(json_encode($response->rajaongkir->destination_details), true),
        'result' => json_decode(json_encode($response->rajaongkir->results), true),
    ];
}