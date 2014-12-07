<?php
namespace Hyperion\Scribe\Extractors;

use Hyperion\Scribe\Exceptions\OAuthParametersMissingException;
use Hyperion\Scribe\Model\OAuthRequest;
use Hyperion\Scribe\Utils\MapUtils;
use Hyperion\Scribe\Utils\Preconditions;
use Hyperion\Scribe\Utils\URLUtils;

class HeaderExtractorImpl implements HeaderExtractor
{
    const PARAM_SEPARATOR = ", ";
    const PREAMBLE = "OAuth ";

    public function extract(OAuthRequest $request)
    {
        $this->checkPreconditions($request);
        $parameters = MapUtils::sort($request->getOauthParameters());
        $header = self::PREAMBLE;
        foreach ($parameters as $key => $value) {
            if (strlen($header) > strlen(self::PREAMBLE)) {
                $header .= self::PARAM_SEPARATOR;
            }
            $header .= sprintf("%s=\"%s\"", $key, URLUtils::percentEncode($value));
        }
        return $header;
    }

    private function checkPreconditions(OAuthRequest $request)
    {
        Preconditions::checkNotNull($request, "Cannot extract a header from a null object");
        $params = $request->getOauthParameters();
        if (!$params) {
            throw new OAuthParametersMissingException($request);
        }
    }
}