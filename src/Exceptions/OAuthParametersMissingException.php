<?php
namespace Hyperion\Scribe\Exceptions;

use Hyperion\Scribe\Model\OAuthRequest;

class OAuthParametersMissingException extends OAuthException
{
    const MSG = "Could not find oauth parameters in request: %s. OAuth parameters must be specified with the addOAuthParameter() method";

    public function __construct(OAuthRequest $request)
    {
        parent::__construct(sprintf(self::MSG, $request));
    }
}