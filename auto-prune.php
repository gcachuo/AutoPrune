<?php
setcookie('XDEBUG_SESSION', 'PHPSTORM');
$json = [];

$curl = curl_init();

$config = json_decode(file_get_contents('config.prod.json'));

$token = $config->token;
$server = $config->server;
$days = $config->days;
$auth = "Bot {$token}";

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://discordapp.com/api/guilds/{$server}/prune?days={$days}&compute_prune_count=true",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "",
    CURLOPT_HTTPHEADER => array(
        "Authorization: {$auth}"
    ),
));

$json['response'] = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    $json['error'] = "cURL Error #:" . $err;
}

echo json_encode($json);