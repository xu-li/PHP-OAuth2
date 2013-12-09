<?php
/**
 * Weibo Wrapper
 *
 * @see http://open.weibo.com/
 */
namespace OAuth2\Client;

require_once(__DIR__ . '/SnsClient.php');
require_once(__DIR__ . '/../GrantType/IGrantType.php');
require_once(__DIR__ . '/../GrantType/AuthorizationCode.php');

use OAuth2\Client\SnsClient;

class Weibo extends SnsClient
{
    const AUTHORIZATION_ENDPOINT = 'https://api.weibo.com/oauth2/authorize';
    const TOKEN_ENDPOINT         = 'https://api.weibo.com/oauth2/access_token';

    /**
     * getAuthUrl
     *
     * @see OAuth2\Client::getAuthenticationUrl
     */
    public function getAuthUrl($redirect_uri, array $extra_parameters = array())
    {
        return parent::getAuthenticationUrl(self::AUTHORIZATION_ENDPOINT, $redirect_uri, $extra_parameters);
    }

    /** 
     * getToken
     *
     * @see OAuth2\Client::getAccessToken
     */
    public function getToken(array $parameters)
    {
        $ret = parent::getAccessToken(self::TOKEN_ENDPOINT, 'authorization_code', $parameters);

        // auto set access token
        if (isset($ret) && $ret['code'] == 200)
        {
        var_dump($ret['result']);
        die();
            if (!empty($ret['result']))
            {
                // set access token
                if (isset($ret['result']['access_token']))
                {
                    $this->setAccessToken($ret['result']['access_token']);
                }

                // set uid
                if (isset($ret['result']['uid']))
                {
                    $this->setUid($ret['result']['uid']);
                }
            }
        }

        return $ret;
    }

    /**
     * Get the name
     *
     * Checks if we have already set the name, or fetch it from weibo api
     */
    public function getName()
    {
        if (empty($this->name))
        {
            // fetch
        }
        return parent::getName();
    }
}
