<?php
namespace Hyperion\Scribe\OAuth;

use Hyperion\Scribe\Model\OAuthRequest;
use Hyperion\Scribe\Model\Token;
use Hyperion\Scribe\Model\Verifier;

interface OAuthService
{
    public function getRequestToken();

    public function getAccessToken(Token $requestToken, Verifier $verifier);

    public function signRequest(Token $accessToken, OAuthRequest $request);

    public function getVersion();

    public function getAuthorizationUrl(Token $requestToken);
}