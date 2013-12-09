<?php
$path = __DIR__ . DIRECTORY_SEPARATOR . '..';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

date_default_timezone_set('Asia/Shanghai');

require('Client/TWeibo.php');

const CLIENT_ID     = '801294226';
const CLIENT_SECRET = '2aa3f28efcce4a0c0d54bddbb2a3fdd5';
const REDIRECT_URI  = 'http://php.localhost/PHP-OAuth2-lixu/Examples/tweibo.php';

$client = new OAuth2\Client\TWeibo(CLIENT_ID, CLIENT_SECRET);
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
    $response = $client->fetch('https://open.t.qq.com/api/user/info');
    /*
    $response = $client->fetch('http://open.t.qq.com/api/t/add_pic', array(
        'content' => 'Test uploading picture at ' . date('Y-m-d H:i:s'),
        'pic' => '@' . __DIR__ . DIRECTORY_SEPARATOR . 'oauth-logo.png',
    ), 'POST');
    */
    
    var_dump($response, $response['result']);
}
