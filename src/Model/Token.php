<?php
namespace Hyperion\Scribe\Model;
class Token
{
    private $token;
    private $secret;
    private $rawResponse;

    public function __construct($token, $secret, $rawResponse = null)
    {
        $this->token = $token;
        $this->secret = $secret;
        $this->rawResponse = $rawResponse;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function getRawResponse()
    {
        if ($this->rawResponse == null) {
            throw new \Exception("This token object was not constructed by scribe and does not have a rawResponse");
        }
        return $this->rawResponse;
    }

    public function __toString()
    {
        return sprintf("Token[%s , %s]", $this->token, $this->secret);
    }
}