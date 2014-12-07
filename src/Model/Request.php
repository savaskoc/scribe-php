<?php
namespace Hyperion\Scribe\Model;

use Hyperion\Scribe\Exceptions\OAuthException;
use Hyperion\Scribe\Utils\MapUtils;
use Hyperion\Scribe\Utils\URLUtils;

class Request
{
    const CONTENT_LENGTH = "Content-Length";
    private $url;
    private $verb;
    private $querystringParams;
    private $bodyParams;
    private $headers;
    private $payload = null;
    private $connection;
    private $charset;
    private $connectTimeout = null;
    private $readTimeout = null;

    public function __construct($verb, $url)
    {
        $this->verb = $verb;
        $this->url = $url;
        $this->querystringParams = array();
        $this->bodyParams = array();
        $this->headers = array();
    }

    public function send()
    {
        try {
            $this->createConnection();
            return $this->doSend();
        } catch (\Exception $ioe) {
            throw new OAuthException("Problems while creating connection", $ioe);
        }
    }

    private function createConnection()
    {
        $effectiveUrl = URLUtils::appendParametersToQueryString($this->url, $this->querystringParams);
        if ($this->connection == null) {
            $url = new URL($effectiveUrl);
            $this->connection = $url->openConnection();
        }
    }

    public function doSend()
    {
        $this->connection->setRequestMethod($this->verb);
        if ($this->connectTimeout != null) {
            $this->connection->setConnectTimeout($this->connectTimeout);
        }
        if ($this->readTimeout != null) {
            $this->connection->setReadTimeout($this->readTimeout);
        }
        $this->addHeaders($this->connection);
        if ($this->verb == Verb::PUT || $this->verb == Verb::POST) {
            $this->addBody($this->connection, $this->getBodyContents());
        }
        return new Response($this->connection);
    }

    public function addHeaders(HttpURLConnection $conn)
    {
        foreach ($this->headers as $key => $val) {
            $conn->setRequestProperty($key, $val);
        }
    }

    public function addBody(HttpURLConnection $conn, $content)
    {
        $conn->setRequestProperty(self::CONTENT_LENGTH, strlen($content));
        $conn->setDoOutput(true);
        $conn->write($content);
    }

    public function getBodyContents()
    {
        return ($this->payload != null) ? $this->payload : URLUtils::formURLEncodeMap($this->bodyParams);
    }

    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    public function addBodyParameter($key, $value)
    {
        $this->bodyParams[$key] = $value;
    }

    public function addQuerystringParameter($key, $value)
    {
        $this->querystringParams[$key] = $value;
    }

    public function addPayload($payload)
    {
        $this->payload = $payload;
    }

    public function getQueryStringParams()
    {
        try {
            $url = new URL($this->url);
            $query = $url->getQuery();
            $params = array();
            $params = array_merge($params, MapUtils::queryStringToMap($query));
            $params = array_merge($params, $this->querystringParams);
            return $params;
        } catch (\Exception $mue) {
            throw new OAuthException("Malformed URL", $mue);
        }
    }

    public function getBodyParams()
    {
        return $this->bodyParams;
    }

    public function getSanitizedUrl()
    {
        $url = preg_replace("/\\?.*/", "", $this->url);
        $url = preg_replace("/\\:\\d{4}/", "", $url);
        return $url;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getCharset()
    {
        return $this->charset;
    }

    public function setCharset($charsetName)
    {
        $this->charset = $charsetName;
    }

    public function setConnectTimeout($duration)
    {
        $this->connectTimeout = $duration;
    }

    public function setReadTimeout($duration)
    {
        $this->readTimeout = $duration;
    }

    public function setConnection(HttpURLConnection $connection)
    {
        $this->connection = $connection;
    }

    public function __toString()
    {
        return sprintf("@Request(%s %s)", $this->getVerb(), $this->getUrl());
    }

    public function getVerb()
    {
        return $this->verb;
    }

    public function getUrl()
    {
        return $this->url;
    }
}