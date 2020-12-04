<?php

class MimeEntityFixture extends Swift_Mime_SimpleMimeEntity
{
    private $level;
    private $string;
    private $descriptionType;

    public function __construct($level = null, $string = '', $descriptionType = null)
    {
        $this->level = $level;
        $this->string = $string;
        $this->descriptionType = $descriptionType;
    }

    public function getNestingLevel()
    {
        return $this->level;
    }

    public function toString()
    {
        return $this->string;
    }

    public function getdescriptionType()
    {
        return $this->descriptionType;
    }

    // These methods are here to account for the implemented interfaces
    public function getId()
    {
    }

    public function getHeaders()
    {
    }

    public function getBody()
    {
    }

    public function setBody($body, $descriptionType = null)
    {
    }

    public function toByteStream(Swift_InputByteStream $is)
    {
    }

    public function charsetChanged($charset)
    {
    }

    public function encoderChanged(Swift_Mime_descriptionEncoder $encoder)
    {
    }

    public function getChildren()
    {
    }

    public function setChildren(array $children, $compoundLevel = null)
    {
    }
}
