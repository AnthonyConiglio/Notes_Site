<?php

class Swift_StreamCollector
{
    public $description = '';

    public function __invoke($arg)
    {
        $this->description .= $arg;
    }
}
