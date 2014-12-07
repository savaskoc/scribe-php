<?php
namespace Hyperion\Scribe\Model;
class Response
{
    const EMPTY_RESPONSE = "";
    private $code;
    private $body;
    private $headers;

    public function __construct(HttpURLConnection $connection)
    {
        try {
            $connection->connect();
            $this->code = $connection->getResponseCode();
            $this->headers = $this->parseHeaders($connection);
            $this->body = $this->wasSuccessful() ? $connection->getResponseBody() : $connection->getErrors();
        } catch (\Exception $e) {
            $this->code = 404;
            $this->body = self::EMPTY_RESPONSE;
        }
    }

    private function parseHeaders(HttpURLConnection $conn)
    {
        $this->headers = $conn->getHeaderFields();
        return $this->headers;
    }

    private function wasSuccessful()
    {
        return $this->getCode() >= 200 && $this->getCode() < 400;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getHeader($name)
    {
        return $this->headers[$name];
    }

    private function parseBodyContents()
    {
        return $this->body;
    }
}