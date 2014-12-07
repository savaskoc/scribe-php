<?php
namespace Hyperion\Scribe\Model;
class OAuthConstants
{
    const TIMESTAMP = "oauth_timestamp";
    const SIGN_METHOD = "oauth_signature_method";
    const SIGNATURE = "oauth_signature";
    const CONSUMER_SECRET = "oauth_consumer_secret";
    const CONSUMER_KEY = "oauth_consumer_key";
    const CALLBACK = "oauth_callback";
    const VERSION = "oauth_version";
    const NONCE = "oauth_nonce";
    const PARAM_PREFIX = "oauth_";
    const TOKEN = "oauth_token";
    const TOKEN_SECRET = "oauth_token_secret";
    const OUT_OF_BAND = "oob";
    const VERIFIER = "oauth_verifier";
    const HEADER = "Authorization";
    const SCOPE = "scope";
    const ACCESS_TOKEN = "access_token";
    const CLIENT_ID = "client_id";
    const CLIENT_SECRET = "client_secret";
    const REDIRECT_URI = "redirect_uri";
    const CODE = "code";

    public static function getEmptyToken()
    {
        return new Token("", "");
    }
}