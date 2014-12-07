<?php
namespace Hyperion\Scribe\Model;
class HttpURLConnectionCurl implements HttpURLConnection
{
    private $url;
    private $requestMethod;
    private $connectionTimeout = 30000;
    private $readTimeout = 30000;
    private $requestProperties = array();
    private $doOutput = true;
    private $body;
    private $responseBody;
    private $responseHeaders;
    private $errors;
    private $code;
    private $requestInfo;
    private $rawResponse;
    private $ch;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function connect()
    {
        $this->ch = curl_init($this->url);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->readTimeout);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, $this->doOutput);
        curl_setopt($this->ch, CURLOPT_HEADER, 1);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        if ($this->requestProperties) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->requestProperties);
        }
        if ($this->requestMethod == Verb::POST) {
            curl_setopt($this->ch, CURLOPT_POST, 1);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->body);
        }
        if ($this->requestMethod == Verb::PUT) {
            curl_setopt($this->ch, CURLOPT_PUT, 1);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->body);
        }
        $this->rawResponse = curl_exec($this->ch);
        $this->requestInfo = curl_getinfo($this->ch);
        $this->responseBody = $this->extractBody();
        $this->responseHeaders = $this->extractHeaders();
        if (curl_errno($this->ch)) {
            $this->errors = curl_error($this->ch);
        }
        $this->code = $this->extractCode();
        curl_close($this->ch);
    }

    private function extractBody()
    {
        return trim(substr($this->rawResponse, $this->requestInfo['header_size']));
    }

    private function extractHeaders()
    {
        $headers = array();
        $rawHeader = substr($this->rawResponse, 0, $this->requestInfo['header_size']);
        $headerLines = explode("\r\n", trim($rawHeader));
        array_shift($headerLines);
        foreach ($headerLines as $header) {
            if ($header != "") {
                $key = substr($header, 0, strpos($header, ":"));
                $val = substr($header, strpos($header, ":") + 1);
                $headers[$key] = $val;
            }
        }
        return $headers;
    }

    private function extractCode()
    {
        return $this->requestInfo['http_code'];
    }

    public function setRequestMethod($method)
    {
        $this->requestMethod = $method;
    }

    public function setConnectTimeout($t)
    {
        $this->connectionTimeout = $t;
    }

    public function setReadTimeout($t)
    {
        $this->readTimeout = $t;
    }

    public function setRequestProperty($key, $val)
    {
        $this->requestProperties[] = sprintf("%s: %s", $key, $val);
    }

    public function setDoOutput($boolean)
    {
        $this->doOutput = $boolean;
    }

    public function write($content)
    {
        $this->body = $content;
    }

    public function getResponseBody()
    {
        return $this->responseBody;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getResponseCode()
    {
        return $this->code;
    }

    public function getHeaderFields()
    {
        return $this->responseHeaders;
    }
}