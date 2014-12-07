<?php
namespace Hyperion\Scribe\Utils;
class URLUtils
{
    const EMPTY_STRING = "";
    const PAIR_SEPARATOR = "=";
    const PARAM_SEPARATOR = "&";
    const QUERY_STRING_SEPARATOR = '?';
    private static $ENCODING_RULES = array(array("*", "%2A"), array("+", "%20"), array("%7E", "~"));

    public static function percentEncode($string)
    {
        $encoded = self::formURLEncode($string);
        foreach (self::$ENCODING_RULES as $r) {
            $rule = new EncodingRule($r);
            $rule->apply($encoded);
        }
        return $encoded;
    }

    public static function formURLEncode($string)
    {
        Preconditions::checkNotNull($string, "Cannot encode null string");
        return urlencode($string);
    }

    public static function formURLDecode($string)
    {
        Preconditions::checkNotNull($string, "Cannot decode null string");
        return urldecode($string);
    }

    public static function appendParametersToQueryString($url, $params)
    {
        Preconditions::checkNotNull($url, "Cannot append to null URL");
        $queryString = self::formURLEncodeMap($params);
        if (!$queryString) {
            return $url;
        } else {
            $url .= strpos($url, self::QUERY_STRING_SEPARATOR) !== false ? self::PARAM_SEPARATOR : self::QUERY_STRING_SEPARATOR;
            $url .= $queryString;
            return $url;
        }
    }

    public static function formURLEncodeMap($map)
    {
        Preconditions::checkNotNull($map, "Cannot url-encode a null object");
        return $map ? self::doFormUrlEncode($map) : self::EMPTY_STRING;
    }

    private static function doFormUrlEncode(array $map)
    {
        $encodedString = "";
        foreach ($map as $key => $value) {
            $encodedString .= self::PARAM_SEPARATOR . self::formURLEncode($key);
            if ($map[$key]) {
                $encodedString .= self::PAIR_SEPARATOR . self::formURLEncode($map[$key]);
            }
        }
        return substr($encodedString, 1);
    }
}

final class EncodingRule
{
    private $ch;
    private $toCh;

    public function __construct(array $rule)
    {
        $this->ch = $rule[0];
        $this->toCh = $rule[1];
    }

    public function apply(&$string)
    {
        $string = str_replace($this->ch, $this->toCh, $string);
    }
}