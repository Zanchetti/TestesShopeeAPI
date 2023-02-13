<?php
//Os dados abaixo são apenas ficcionais
$partner_id = "851249";
$access_token = "367a0a8eb9d1837cbf7c43b587a0faa4";
$shop_id = "1001094";
$partner_key = "6XTk2GBxw9MPo4x99BAlWMaIzHkVefJr";
$code = "494d7a4a4f5a66524556776f66425453";
$host = "https://partner.shopeemobile.com";

function signature($partner_id, $path_api, $access_token, $shop_id, $partner_key)
{
    $base_string = $partner_id . $path_api . time() . $access_token . $shop_id;
    $sign = hash_hmac('sha256', $base_string, $partner_key);
    return $sign;
}
function uploadImage($partner_id, $access_token, $shop_id, $partner_key)
{
    $curl = curl_init();
    $path_api = "/api/v2/media_space/upload_image";
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://partner.shopeemobile.com/api/v2/media_space/upload_image?partner_id=' . urlencode($partner_id) . '&sign=' . urlencode(signature($partner_id, $path_api, $access_token, $shop_id, $partner_key)) . '&timestamp=' . time(),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('image' => new CURLFile(__DIR__ . '/caminho/para/arquivo.jpg')),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: multipart/form-data'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function categoryRecommend($partner_id, $access_token, $shop_id, $partner_key, $item_name)
{

    $curl = curl_init();
    $path_api = "/api/v2/media_space/upload_image";
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://partner.shopeemobile.com/api/v2/product/category_recommend?access_token=' . urlencode($access_token) . '&item_name=' . urlencode($item_name) . '&partner_id=' . urlencode($partner_id) . '&shop_id=' . urlencode($shop_id) . '&sign=' . urlencode(signature($partner_id, $path_api, $access_token, $shop_id, $partner_key)) . '&timestamp=' . time(),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function getAttributes($partner_id, $access_token, $shop_id, $partner_key, $category_id)
{

    $curl = curl_init();
    $path_api = "/api/v2/product/get_attributes";
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://partner.shopeemobile.com/api/v2/product/get_attributes?access_token=' . urlencode($access_token) . '&category_id=' . urlencode($category_id) . '&language=pt-br&partner_id=' . urlencode($partner_id) . '&shop_id=' . urlencode($shop_id) . '&sign=' . urlencode(signature($partner_id, $path_api, $access_token, $shop_id, $partner_key)) . '&timestamp=' . time(),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
}

function getBrandList($partner_id, $access_token, $shop_id, $partner_key, $category_id)
{
    //AINDA NN ESTÁ PRONTO
    $curl = curl_init();
    $path_api = "/api/v2/product/get_attributes";
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://partner.shopeemobile.com/api/v2/product/get_brand_list?access_token=' . urlencode($access_token) . '&category_id=' . urlencode($category_id) . '&language=pt-br&offset=0&page_size=10&partner_id=' . urlencode($partner_id) . '&shop_id=' . urlencode($shop_id) . '&sign=' . urlencode(signature($partner_id, $path_api, $access_token, $shop_id, $partner_key)) . '&status=1&timestamp=' . time(),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
}

function getDtsLimit($partner_id, $access_token, $shop_id, $partner_key, $category_id)
{
    //AINDA NN ESTÁ PRONTO
    $curl = curl_init();
    $path_api = "/api/v2/product/get_dts_limit";

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://partner.shopeemobile.com/api/v2/product/get_dts_limit?access_token=' . urlencode($access_token) . '&category_id=' . urlencode($category_id) . '&partner_id=' . urlencode($partner_id) . '&shop_id=' . urlencode($shop_id) . '&sign=' . urlencode(signature($partner_id, $path_api, $access_token, $shop_id, $partner_key)) . '&timestamp=' . time(),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
}
