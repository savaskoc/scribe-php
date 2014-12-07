<?php
namespace Hyperion\Scribe\Utils;
class MapUtils
{
    const EMPTY_STRING = "";
    const PAIR_SEPARATOR = "=";
    const PARAM_SEPARATOR = "&";

    public static function sort($map)
    {
        Preconditions::checkNotNull($map, "Cannot sort a null object.");
        ksort($map);
        return $map;
    }

    public static function decodeAndAppendEntries(array $source, array &$target)
    {
        foreach ($source as $key => $value) {
            $target[URLUtils::percentEncode($key)] = URLUtils::percentEncode($value);
        }
    }

    public static function concatSortedPercentEncodedParams(array $params)
    {
        $result = "";
        foreach ($params as $key => $value) {
            $result .= $key . self::PAIR_SEPARATOR;
            $result .= $value . self::PARAM_SEPARATOR;
        }
        return substr($result, 0, strlen($result) - 1);
    }

    public static function queryStringToMap($queryString)
    {
        $result = array();
        if ($queryString != null && strlen($queryString) > 0) {
            $pairs = explode(self::PARAM_SEPARATOR, $queryString);
            foreach ($pairs as $pair) {
                $keyVal = explode(self::PAIR_SEPARATOR, $pair);
                $key = URLUtils::formURLDecode($keyVal[0]);
                $value = count($keyVal) > 1 ? URLUtils::formURLDecode($keyVal[1]) : self::EMPTY_STRING;
                $result[$key] = $value;
            }
        }
        return $result;
    }
}