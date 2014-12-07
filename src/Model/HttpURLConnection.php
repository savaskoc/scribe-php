<?php
namespace Hyperion\Scribe\Model;
interface HttpURLConnection
{
    public function connect();

    public function setRequestMethod($method);

    public function setConnectTimeout($t);

    public function setReadTimeout($t);

    public function setRequestProperty($key, $val);

    public function setDoOutput($boolean);

    public function write($content);

    public function getResponseBody();

    public function getErrors();

    public function getResponseCode();

    public function getHeaderFields();
}