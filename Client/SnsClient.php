<?php
/**
 * A generic SNS Client
 *
 * Each SnsClient has an uid and a name.
 */
namespace OAuth2\Client;

require_once(__DIR__ . '/../Client.php');

use OAuth2\Client;

class SnsClient extends Client
{
    protected $uid;
    protected $name;

    public function getUid()
    {
        return $this->uid;
    }

    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
