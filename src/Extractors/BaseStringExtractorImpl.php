<?php
namespace Hyperion\Scribe\Extractors;

use Hyperion\Scribe\Exceptions\OAuthParametersMissingException;
use Hyperion\Scribe\Model\OAuthRequest;
use Hyperion\Scribe\Utils\MapUtils;
use Hyperion\Scribe\Utils\Preconditions;
use Hyperion\Scribe\Utils\URLUtils;

class BaseStringExtractorImpl implements BaseStringExtractor
{
    const AMPERSAND_SEPARATED_STRING = "%s&%s&%s";

    public function extract(OAuthRequest $request)
    {
        $this->checkPreconditions($request);
        $verb = URLUtils::percentEncode($request->getVerb());
        $url = URLUtils::percentEncode($request->getSanitizedUrl());
        $params = $this->getSortedAndEncodedParams($request);
        return sprintf(self::AMPERSAND_SEPARATED_STRING, $verb, $url, $params);
    }

    private function checkPreconditions(OAuthRequest $request)
    {
        Preconditions::checkNotNull($request, "Cannot extract base string from null object");
        $oauthParameters = $request->getOauthParameters();
        if (!$oauthParameters) {
            throw new OAuthParametersMissingException($request);
        }
    }

    private function getSortedAndEncodedParams(OAuthRequest $request)
    {
        $params = array();
        MapUtils::decodeAndAppendEntries($request->getQueryStringParams(), $params);
        MapUtils::decodeAndAppendEntries($request->getBodyParams(), $params);
        MapUtils::decodeAndAppendEntries($request->getOauthParameters(), $params);
        $params = MapUtils::sort($params);
        return URLUtils::percentEncode(MapUtils::concatSortedPercentEncodedParams($params));
    }
}