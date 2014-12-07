<?php
namespace Hyperion\Scribe\Utils;

use Hyperion\Scribe\Exceptions\IllegalArgumentException;
use Hyperion\Scribe\Model\OAuthConstants;

class Preconditions
{
    const DEFAULT_MESSAGE = "Received an invalid parameter";
    const URL_PATTERN = "/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/";

    public static function checkNotNull($object, $errorMsg)
    {
        self::check($object !== null, $errorMsg);
    }

    private static function check($requirements, $error)
    {
        $message = ($error == null || strlen(trim($error)) <= 0) ? self::DEFAULT_MESSAGE : $error;
        if (!$requirements) {
            throw new IllegalArgumentException($message);
        }
    }

    public static function checkValidUrl($url, $errorMsg)
    {
        self::checkEmptyString($url, $errorMsg);
        self::check(self::isUrl($url), $errorMsg);
    }

    public static function checkEmptyString($string, $errorMsg)
    {
        self::check($string != null && !(trim($string) == ""), $errorMsg);
    }

    private static function isUrl($url)
    {
        return preg_match(self::URL_PATTERN, $url);
    }

    public static function checkValidOAuthCallback($url, $errorMsg)
    {
        self::checkEmptyString($url, $errorMsg);
        if (strtolower($url) !== OAuthConstants::OUT_OF_BAND) {
            self::check(self::isUrl($url), $errorMsg);
        }
    }
}