<?php

namespace App\Http\Response;

class Response
{
    protected $statusCode;
    protected $headers = [];
    protected $body;

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function addHeader($header)
    {
        $this->headers[] = $header;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function send()
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $header) {
            header($header);
        }
        echo $this->body;
    }
}