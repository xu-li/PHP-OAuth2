<?php
/**
 * Tencent Weibo Wrapper
 *
 * @see http://dev.t.qq.com/
 */
namespace OAuth2\Client;

require_once(__DIR__ . '/SnsClient.php');
require_once(__DIR__ . '/../GrantType/IGrantType.php');
require_once(__DIR__ . '/../GrantType/AuthorizationCode.php');

use OAuth2\Client\SnsClient;

class TWeibo extends SnsClient
{
    const AUTHORIZATION_ENDPOINT = 'https://open.t.qq.com/cgi-bin/oauth2/authorize';
    const TOKEN_ENDPOINT         = 'https://open.t.qq.com/cgi-bin/oauth2/access_token';

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

        // auto set the openid and access token
        if (isset($ret) && $ret['code'] == 200)
        {
            $info = array();
            parse_str($ret['result'], $info);
            if (!empty($info))
            {
                if (isset($info['access_token']))
                {
                    $this->setAccessToken($info['access_token']);
                }

                if (isset($info['openid']))
                {
                    $this->setUid($info['openid']);
                }

                if (isset($info['name']))
                {
                    $this->setName($info['name']);
                }
            }
        }

        return $ret;
    }

    /**
     * fetch
     *
     * @see OAuth2\Client::fetch
     */
    public function fetch($protected_resource_url, $parameters = array(), $http_method = self::HTTP_METHOD_GET, array $http_headers = array(), $form_content_type = self::HTTP_FORM_CONTENT_TYPE_MULTIPART)
    {
        // common parameters
        // http://wiki.open.t.qq.com/index.php/OAuth2.0%E9%89%B4%E6%9D%83#.E8.AF.B7.E6.B1.82.E5.8F.82.E6.95.B0.EF.BC.88.E5.85.AC.E5.85.B1.E9.83.A8.E5.88.86.EF.BC.89
        $parameters['oauth_consumer_key'] = $this->getOAuthConsumerKey();
        $parameters['oauth_version'] = '2.a';
        $parameters['openid'] = $this->getUid();

        return parent::fetch($protected_resource_url, $parameters, $http_method, $http_headers, $form_content_type);
    }

    /**
     * getOAuthConsumerKey
     */
    protected function getOAuthConsumerKey()
    {
        return $this->client_id;
    }
}
