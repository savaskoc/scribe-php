<?php
namespace Hyperion\Scribe\Builder\Api;
use Hyperion\Scribe\Model\Token;

class FlickrApi extends DefaultApi10a
{
    const ACCESS_TOKEN_ENDPOINT = 'http://www.flickr.com/services/oauth/access_token';
    const AUTHORIZE_URL = "http://www.flickr.com/services/oauth/authorize?oauth_token=%s&perms=%s";
    const REQUEST_TOKEN_ENDPOINT = 'http://www.flickr.com/services/oauth/request_token';

    public function getAccessTokenEndpoint()
    {
        return self::ACCESS_TOKEN_ENDPOINT;
    }

    public function getAuthorizationUrl(Token $requestToken)
    {
        return sprintf(self::AUTHORIZE_URL, $requestToken->getToken(), 'read');
    }

    public function getRequestTokenEndpoint()
    {
        return self::REQUEST_TOKEN_ENDPOINT;
    }
}

?>
