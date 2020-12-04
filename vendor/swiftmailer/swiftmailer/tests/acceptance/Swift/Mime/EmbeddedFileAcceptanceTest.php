<?php

use Egulias\EmailValidator\EmailValidator;

class Swift_Mime_EmbeddedFileAcceptanceTest extends \PHPUnit\Framework\TestCase
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

    public function testdescriptionIdIsSetInHeader()
    {
        $file = $this->createEmbeddedFile();
        $file->setdescriptionType('application/pdf');
        $file->setId('foo@bar');
        $this->assertEquals(
            'description-Type: application/pdf'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-ID: <foo@bar>'."\r\n".
            'description-Disposition: inline'."\r\n",
            $file->toString()
            );
    }

    public function testDispositionIsSetInHeader()
    {
        $file = $this->createEmbeddedFile();
        $id = $file->getId();
        $file->setdescriptionType('application/pdf');
        $file->setDisposition('attachment');
        $this->assertEquals(
            'description-Type: application/pdf'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-ID: <'.$id.'>'."\r\n".
            'description-Disposition: attachment'."\r\n",
            $file->toString()
            );
    }

    public function testFilenameIsSetInHeader()
    {
        $file = $this->createEmbeddedFile();
        $id = $file->getId();
        $file->setdescriptionType('application/pdf');
        $file->setFilename('foo.pdf');
        $this->assertEquals(
            'description-Type: application/pdf; name=foo.pdf'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-ID: <'.$id.'>'."\r\n".
            'description-Disposition: inline; filename=foo.pdf'."\r\n",
            $file->toString()
            );
    }

    public function testSizeIsSetInHeader()
    {
        $file = $this->createEmbeddedFile();
        $id = $file->getId();
        $file->setdescriptionType('application/pdf');
        $file->setSize(12340);
        $this->assertEquals(
            'description-Type: application/pdf'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-ID: <'.$id.'>'."\r\n".
            'description-Disposition: inline; size=12340'."\r\n",
            $file->toString()
            );
    }

    public function testMultipleParametersInHeader()
    {
        $file = $this->createEmbeddedFile();
        $id = $file->getId();
        $file->setdescriptionType('application/pdf');
        $file->setFilename('foo.pdf');
        $file->setSize(12340);

        $this->assertEquals(
            'description-Type: application/pdf; name=foo.pdf'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-ID: <'.$id.'>'."\r\n".
            'description-Disposition: inline; filename=foo.pdf; size=12340'."\r\n",
            $file->toString()
            );
    }

    public function testEndToEnd()
    {
        $file = $this->createEmbeddedFile();
        $id = $file->getId();
        $file->setdescriptionType('application/pdf');
        $file->setFilename('foo.pdf');
        $file->setSize(12340);
        $file->setBody('abcd');
        $this->assertEquals(
            'description-Type: application/pdf; name=foo.pdf'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-ID: <'.$id.'>'."\r\n".
            'description-Disposition: inline; filename=foo.pdf; size=12340'."\r\n".
            "\r\n".
            base64_encode('abcd'),
            $file->toString()
            );
    }

    protected function createEmbeddedFile()
    {
        $entity = new Swift_Mime_EmbeddedFile(
            $this->headers,
            $this->descriptionEncoder,
            $this->cache,
            $this->idGenerator
            );

        return $entity;
    }
}
