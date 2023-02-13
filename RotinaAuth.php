<?php
//** Métodos Rotina de Autenticação **
//Os dados abaixo são apenas ficcionais
$partner_id = "851249";
//Tokens de acesso são necessários para obter e modificar APIs relacionadas a dados de vendedores. Cada token de acesso é válido por 4 horas e pode ser reutilizado dentro de um período de validade. O token de acesso precisa ser atualizado periodicamente.
$access_token = "367a0a8eb9d1837cbf7c43b587a0faa4";
$shop_id = "1001094";
$partner_key = "57615053704d6470644f554a78656d50484143644964436a5568777544524579";
$code = "494d7a4a4f5a66524556776f66425453";
$host = "https://partner.shopeemobile.com";

//Existem 4 passos para a concluir sua autorização: Gerar o link de autorização, adquirir autorização da loja, usar o código de autorização, e obter e atualizar o token de acesso

//Método que gera a url de acesso para o dono da loja dar a autorização
function authShop($partner_id, $partner_key)
{
    global $host;
    $path = "/api/v2/shop/auth_partner";
    $redirectUrl = "https://www.google.com/";

    $timest = time();
    $baseString = sprintf("%s%s%s", $partner_id, $path, $timest);
    $sign = hash_hmac('sha256', $baseString, $partner_key);
    $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s&redirect=%s", $host, $path, $partner_id, $timest, $sign, $redirectUrl);
    return $url;
}

//Usado para gerar uma assinatura que sempre será necessário ao requisitar a API
function signature($partner_id, $path_api, $access_token, $shop_id, $partner_key)
{
    $base_string = $partner_id . $path_api . time() . $access_token . $shop_id;
    $sign = hash_hmac('sha256', $base_string, $partner_key);
    return $sign;
}

//Os métodos abaixo são usado para gerar e atualizar os tokens de autorização
function getTokenShopLevel($code, $partner_id, $partner_key, $shop_id)
{
    global $host;
    $path = "/api/v2/auth/token/get";

    $timest = time();
    $body = array("code" => $code,  "shop_id" => $shop_id, "partner_id" => $partner_id);
    $baseString = sprintf("%s%s%s", $partner_id, $path, $timest);
    $sign = hash_hmac('sha256', $baseString, $partner_key);
    $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s", $host, $path, $partner_id, $timest, $sign);


    $c = curl_init($url);
    curl_setopt($c, CURLOPT_POST, 1);
    curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    $resp = curl_exec($c);
    echo $resp;

    $ret = json_decode($resp, true);

    if (array_key_exists("access_token", $ret)) {
        $accessToken = $ret["access_token"];
    } else {
        return ("O AccessToken não foi encontrado!");
    }

    if (array_key_exists("refresh_token", $ret)) {
        $newRefreshToken = $ret["refresh_token"];
    } else {
        return "O RefreshToken não foi encontrado";
    }

    echo "\naccess_token: $accessToken, refresh_token: $newRefreshToken raw: $ret" . "\n";
    return $ret;
}

function getTokenAccountLevel($code, $partner_id, $partner_key, $mainAccountId)
{
    global $host;
    $path = "/api/v2/auth/token/get";

    $timest = time();
    $body = array("code" => $code,  "main_account_id" => $mainAccountId, "partner_id" => $partner_id);
    $baseString = sprintf("%s%s%s", $partner_id, $path, $timest);

    $sign = hash_hmac('sha256', $baseString, $partner_key);
    $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s", $host, $path, $partner_id, $timest, $sign);

    $c = curl_init($url);
    curl_setopt($c, CURLOPT_POST, 1);
    curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($c);
    echo "\nraw result " . $result . "\n";

    $ret = json_decode($result, true);
    $accessToken = $ret["access_token"];
    $newRefreshToken = $ret["refresh_token"];
    echo "\naccess_token: " . $accessToken . ", refresh_token: " . $newRefreshToken . "\n";
    return $ret;
}

function getAccessTokenShopLevel($partner_id, $partner_key, $shop_id, $refreshToken)
{
    global $host;
    $path = "/api/v2/auth/access_token/get";

    $timest = time();
    $body = array("partner_id" => $partner_id, "shop_id" => $shop_id, "refresh_token" => $refreshToken);
    $baseString = sprintf("%s%s%s", $partner_id, $path, $timest);
    $sign = hash_hmac('sha256', $baseString, $partner_key);
    $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s", $host, $path, $partner_id, $timest, $sign);


    $c = curl_init($url);
    curl_setopt($c, CURLOPT_POST, 1);
    curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($c);
    echo "\nraw result " . $result . "\n";

    $ret = json_decode($result, true);

    $accessToken = $ret["access_token"];
    $newRefreshToken = $ret["refresh_token"];
    echo "\naccess_token: " . $accessToken . ", refresh_token: " . $newRefreshToken . "\n";
    return $ret;
}
