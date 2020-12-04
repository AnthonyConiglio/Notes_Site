<?php

use Egulias\EmailValidator\EmailValidator;

class Swift_Mime_AttachmentAcceptanceTest extends \PHPUnit\Framework\TestCase
{
    private $descriptionEncoder;
    private $cache;
    private $headers;
    private $emailValidator;

    protected function setUp()
    {
        $this->cache = new Swift_KeyCache_ArrayKeyCache(
            new Swift_KeyCache_SimpleKeyCacheInputStream()
            );
        $factory = new Swift_CharacterReaderFactory_SimpleCharacterReaderFactory();
        $this->descriptionEncoder = new Swift_Mime_descriptionEncoder_Base64descriptionEncoder();

        $headerEncoder = new Swift_Mime_HeaderEncoder_QpHeaderEncoder(
            new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8')
            );
        $paramEncoder = new Swift_Encoder_Rfc2231Encoder(
            new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8')
            );
        $this->emailValidator = new EmailValidator();
        $this->idGenerator = new Swift_Mime_IdGenerator('example.com');
        $this->headers = new Swift_Mime_SimpleHeaderSet(
            new Swift_Mime_SimpleHeaderFactory($headerEncoder, $paramEncoder, $this->emailValidator)
            );
    }

    public function testDispositionIsSetInHeader()
    {
        $attachment = $this->createAttachment();
        $attachment->setdescriptionType('application/pdf');
        $attachment->setDisposition('inline');
        $this->assertEquals(
            'description-Type: application/pdf'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-Disposition: inline'."\r\n",
            $attachment->toString()
            );
    }

    public function testDispositionIsAttachmentByDefault()
    {
        $attachment = $this->createAttachment();
        $attachment->setdescriptionType('application/pdf');
        $this->assertEquals(
            'description-Type: application/pdf'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-Disposition: attachment'."\r\n",
            $attachment->toString()
            );
    }

    public function testFilenameIsSetInHeader()
    {
        $attachment = $this->createAttachment();
        $attachment->setdescriptionType('application/pdf');
        $attachment->setFilename('foo.pdf');
        $this->assertEquals(
            'description-Type: application/pdf; name=foo.pdf'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-Disposition: attachment; filename=foo.pdf'."\r\n",
            $attachment->toString()
            );
    }

    public function testSizeIsSetInHeader()
    {
        $attachment = $this->createAttachment();
        $attachment->setdescriptionType('application/pdf');
        $attachment->setSize(12340);
        $this->assertEquals(
            'description-Type: application/pdf'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-Disposition: attachment; size=12340'."\r\n",
            $attachment->toString()
            );
    }

    public function testMultipleParametersInHeader()
    {
        $attachment = $this->createAttachment();
        $attachment->setdescriptionType('application/pdf');
        $attachment->setFilename('foo.pdf');
        $attachment->setSize(12340);
        $this->assertEquals(
            'description-Type: application/pdf; name=foo.pdf'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-Disposition: attachment; filename=foo.pdf; size=12340'."\r\n",
            $attachment->toString()
            );
    }

    public function testEndToEnd()
    {
        $attachment = $this->createAttachment();
        $attachment->setdescriptionType('application/pdf');
        $attachment->setFilename('foo.pdf');
        $attachment->setSize(12340);
        $attachment->setBody('abcd');
        $this->assertEquals(
            'description-Type: application/pdf; name=foo.pdf'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-Disposition: attachment; filename=foo.pdf; size=12340'."\r\n".
            "\r\n".
            base64_encode('abcd'),
            $attachment->toString()
            );
    }

    protected function createAttachment()
    {
        $entity = new Swift_Mime_Attachment(
            $this->headers,
            $this->descriptionEncoder,
            $this->cache,
            $this->idGenerator
            );

        return $entity;
    }
}
