<?php
namespace Hyperion\Scribe\Laravel;

use Hyperion\Scribe\Builder\ServiceBuilder;
use Hyperion\Scribe\Model\OAuthRequest;
use Hyperion\Scribe\Model\Token;
use Hyperion\Scribe\Model\Verb;

class Builder
{
    private $builder;

    public function __construct()
    {
        $this->builder = new ServiceBuilder();
    }

    public function build($api, Token $token, $callback = '', $scope = [])
    {
        return $this->builder->provider($api)
                             ->apiKey($token->getToken())
                             ->apiSecret($token->getSecret())
                             ->callback($callback)
                             ->scope($scope)
                             ->build();
    }

    public function request($verb, $url, $data, Token $accessToken, $provider)
    {
        $request = new OAuthRequest($verb, $url);

        $functionName = ($verb === Verb::GET || $verb === Verb::DELETE) ? 'addBodyParameter' : 'addQuerystringParameter';
        foreach ($data as $key => $value)
            call_user_func([$request, $functionName], $key, $value);

        $provider->signRequest($accessToken, $request);

        return $request->send()->getBody();
    }
}