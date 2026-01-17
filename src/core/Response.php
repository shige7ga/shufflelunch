<?php

class Response
{
    private $content;
    private $statusCode;
    private $statusText;

    public function send()
    {
        echo $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setStatusContent($statusCode, $statusText)
    {
        $this->statusCode = $statusCode;
        $this->statusText = $statusText;
    }
}
