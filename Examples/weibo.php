<?php
$path = __DIR__ . DIRECTORY_SEPARATOR . '..';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

date_default_timezone_set('Asia/Shanghai');

require('Client/Weibo.php');

const CLIENT_ID     = '2190273302';
const CLIENT_SECRET = '5ab2cf740ba174e198d72a63cca20c9b';
const REDIRECT_URI  = 'http://php.localhost/PHP-OAuth2-lixu/Examples/weibo.php';

$client = new OAuth2\Client\Weibo(CLIENT_ID, CLIENT_SECRET);
if (!isset($_GET['code']))
{
    $auth_url = $client->getAuthUrl(REDIRECT_URI);
    header('Location: ' . $auth_url);
    die('Redirect');
}
else
{
    $params = array('code' => $_GET['code'], 'redirect_uri' => REDIRECT_URI);
    $client->getToken($params);
    $response = $client->fetch('https://api.weibo.com/2/account/get_uid.json');

    /*
    $response = $client->fetch('https://upload.api.weibo.com/2/statuses/upload.json', array(
        'status' => 'Test uploading picture at ' . date('Y-m-d H:i:s'),
        'pic' => '@' . __DIR__ . DIRECTORY_SEPARATOR . 'oauth-logo.png',
    ), 'POST');
    */
    
    var_dump($response, $response['result']);
}
