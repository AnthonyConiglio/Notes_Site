<?php

class Swift_Mime_SimpleMessageAcceptanceTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        Swift_Preferences::getInstance()->setCharset(null); //TODO: Test with the charset defined
    }

    public function testBasicHeaders()
    {
        /* -- RFC 2822, 3.6.
     */

        $message = $this->createMessage();
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString(),
            '%s: Only required headers, and non-empty headers should be displayed'
            );
    }

    public function testSubjectIsDisplayedIfSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testDateCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $id = $message->getId();
        $date = new DateTimeImmutable();
        $message->setDate($date);
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testMessageIdCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setId('foo@bar');
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <foo@bar>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testdescriptionTypeCanBeChanged()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setdescriptionType('text/html');
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/html'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testCharsetCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setdescriptionType('text/html');
        $message->setCharset('iso-8859-1');
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/html; charset=iso-8859-1'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testFormatCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFormat('flowed');
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain; format=flowed'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testEncoderCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setdescriptionType('text/html');
        $message->setEncoder(
            new Swift_Mime_descriptionEncoder_PlaindescriptionEncoder('7bit')
            );
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/html'."\r\n".
            'description-Transfer-Encoding: 7bit'."\r\n",
            $message->toString()
            );
    }

    public function testFromAddressCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFrom('chris.corbyn@swiftmailer.org');
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: chris.corbyn@swiftmailer.org'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testFromAddressCanBeSetWithName()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFrom(['chris.corbyn@swiftmailer.org' => 'Chris Corbyn']);
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testMultipleFromAddressesCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn',
            'mark@swiftmailer.org',
            ]);
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>, mark@swiftmailer.org'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testReturnPathAddressCanBeSet()
    {
        $message = $this->createMessage();
        $message->setReturnPath('chris@w3style.co.uk');
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Return-Path: <chris@w3style.co.uk>'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testEmptyReturnPathHeaderCanBeUsed()
    {
        $message = $this->createMessage();
        $message->setReturnPath('');
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Return-Path: <>'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testSenderCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setSender('chris.corbyn@swiftmailer.org');
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Sender: chris.corbyn@swiftmailer.org'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testSenderCanBeSetWithName()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setSender(['chris.corbyn@swiftmailer.org' => 'Chris']);
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Sender: Chris <chris.corbyn@swiftmailer.org>'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testReplyToCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFrom(['chris.corbyn@swiftmailer.org' => 'Chris']);
        $message->setReplyTo(['chris@w3style.co.uk' => 'Myself']);
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris <chris.corbyn@swiftmailer.org>'."\r\n".
            'Reply-To: Myself <chris@w3style.co.uk>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testMultipleReplyAddressCanBeUsed()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFrom(['chris.corbyn@swiftmailer.org' => 'Chris']);
        $message->setReplyTo([
            'chris@w3style.co.uk' => 'Myself',
            'my.other@address.com' => 'Me',
            ]);
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris <chris.corbyn@swiftmailer.org>'."\r\n".
            'Reply-To: Myself <chris@w3style.co.uk>, Me <my.other@address.com>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testToAddressCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFrom(['chris.corbyn@swiftmailer.org' => 'Chris']);
        $message->setReplyTo([
            'chris@w3style.co.uk' => 'Myself',
            'my.other@address.com' => 'Me',
            ]);
        $message->setTo('mark@swiftmailer.org');
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris <chris.corbyn@swiftmailer.org>'."\r\n".
            'Reply-To: Myself <chris@w3style.co.uk>, Me <my.other@address.com>'."\r\n".
            'To: mark@swiftmailer.org'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testMultipleToAddressesCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFrom(['chris.corbyn@swiftmailer.org' => 'Chris']);
        $message->setReplyTo([
            'chris@w3style.co.uk' => 'Myself',
            'my.other@address.com' => 'Me',
            ]);
        $message->setTo([
            'mark@swiftmailer.org', 'chris@swiftmailer.org' => 'Chris Corbyn',
            ]);
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris <chris.corbyn@swiftmailer.org>'."\r\n".
            'Reply-To: Myself <chris@w3style.co.uk>, Me <my.other@address.com>'."\r\n".
            'To: mark@swiftmailer.org, Chris Corbyn <chris@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testCcAddressCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFrom(['chris.corbyn@swiftmailer.org' => 'Chris']);
        $message->setReplyTo([
            'chris@w3style.co.uk' => 'Myself',
            'my.other@address.com' => 'Me',
            ]);
        $message->setTo([
            'mark@swiftmailer.org', 'chris@swiftmailer.org' => 'Chris Corbyn',
            ]);
        $message->setCc('john@some-site.com');
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris <chris.corbyn@swiftmailer.org>'."\r\n".
            'Reply-To: Myself <chris@w3style.co.uk>, Me <my.other@address.com>'."\r\n".
            'To: mark@swiftmailer.org, Chris Corbyn <chris@swiftmailer.org>'."\r\n".
            'Cc: john@some-site.com'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testMultipleCcAddressesCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFrom(['chris.corbyn@swiftmailer.org' => 'Chris']);
        $message->setReplyTo([
            'chris@w3style.co.uk' => 'Myself',
            'my.other@address.com' => 'Me',
            ]);
        $message->setTo([
            'mark@swiftmailer.org', 'chris@swiftmailer.org' => 'Chris Corbyn',
            ]);
        $message->setCc([
            'john@some-site.com' => 'John West',
            'fred@another-site.co.uk' => 'Big Fred',
            ]);
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris <chris.corbyn@swiftmailer.org>'."\r\n".
            'Reply-To: Myself <chris@w3style.co.uk>, Me <my.other@address.com>'."\r\n".
            'To: mark@swiftmailer.org, Chris Corbyn <chris@swiftmailer.org>'."\r\n".
            'Cc: John West <john@some-site.com>, Big Fred <fred@another-site.co.uk>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testBccAddressCanBeSet()
    {
        //Obviously Transports need to setBcc(array()) and send to each Bcc recipient
        // separately in accordance with RFC 2822/2821
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFrom(['chris.corbyn@swiftmailer.org' => 'Chris']);
        $message->setReplyTo([
            'chris@w3style.co.uk' => 'Myself',
            'my.other@address.com' => 'Me',
            ]);
        $message->setTo([
            'mark@swiftmailer.org', 'chris@swiftmailer.org' => 'Chris Corbyn',
            ]);
        $message->setCc([
            'john@some-site.com' => 'John West',
            'fred@another-site.co.uk' => 'Big Fred',
            ]);
        $message->setBcc('x@alphabet.tld');
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris <chris.corbyn@swiftmailer.org>'."\r\n".
            'Reply-To: Myself <chris@w3style.co.uk>, Me <my.other@address.com>'."\r\n".
            'To: mark@swiftmailer.org, Chris Corbyn <chris@swiftmailer.org>'."\r\n".
            'Cc: John West <john@some-site.com>, Big Fred <fred@another-site.co.uk>'."\r\n".
            'Bcc: x@alphabet.tld'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testMultipleBccAddressesCanBeSet()
    {
        //Obviously Transports need to setBcc(array()) and send to each Bcc recipient
        // separately in accordance with RFC 2822/2821
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFrom(['chris.corbyn@swiftmailer.org' => 'Chris']);
        $message->setReplyTo([
            'chris@w3style.co.uk' => 'Myself',
            'my.other@address.com' => 'Me',
            ]);
        $message->setTo([
            'mark@swiftmailer.org', 'chris@swiftmailer.org' => 'Chris Corbyn',
            ]);
        $message->setCc([
            'john@some-site.com' => 'John West',
            'fred@another-site.co.uk' => 'Big Fred',
            ]);
        $message->setBcc(['x@alphabet.tld', 'a@alphabet.tld' => 'A']);
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris <chris.corbyn@swiftmailer.org>'."\r\n".
            'Reply-To: Myself <chris@w3style.co.uk>, Me <my.other@address.com>'."\r\n".
            'To: mark@swiftmailer.org, Chris Corbyn <chris@swiftmailer.org>'."\r\n".
            'Cc: John West <john@some-site.com>, Big Fred <fred@another-site.co.uk>'."\r\n".
            'Bcc: x@alphabet.tld, A <a@alphabet.tld>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testStringBodyIsAppended()
    {
        $message = $this->createMessage();
        $message->setReturnPath('chris@w3style.co.uk');
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);
        $message->setBody(
            'just a test body'."\r\n".
            'with a new line'
            );
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Return-Path: <chris@w3style.co.uk>'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'just a test body'."\r\n".
            'with a new line',
            $message->toString()
            );
    }

    public function testStringBodyIsEncoded()
    {
        $message = $this->createMessage();
        $message->setReturnPath('chris@w3style.co.uk');
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);
        $message->setBody(
            'Just s'.pack('C*', 0xC2, 0x01, 0x01).'me multi-'."\r\n".
            'line message!'
            );
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Return-Path: <chris@w3style.co.uk>'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'Just s=C2=01=01me multi-'."\r\n".
            'line message!',
            $message->toString()
            );
    }

    public function testChildrenCanBeAttached()
    {
        $message = $this->createMessage();
        $message->setReturnPath('chris@w3style.co.uk');
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);

        $id = $message->getId();
        $date = $message->getDate();
        $boundary = $message->getBoundary();

        $part1 = $this->createMimePart();
        $part1->setdescriptionType('text/plain');
        $part1->setCharset('iso-8859-1');
        $part1->setBody('foo');

        $message->attach($part1);

        $part2 = $this->createMimePart();
        $part2->setdescriptionType('text/html');
        $part2->setCharset('iso-8859-1');
        $part2->setBody('test <b>foo</b>');

        $message->attach($part2);

        $this->assertEquals(
            'Return-Path: <chris@w3style.co.uk>'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: multipart/alternative;'."\r\n".
            ' boundary="'.$boundary.'"'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: text/plain; charset=iso-8859-1'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'foo'.
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: text/html; charset=iso-8859-1'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'test <b>foo</b>'.
            "\r\n\r\n".
            '--'.$boundary.'--'."\r\n",
            $message->toString()
            );
    }

    public function testAttachmentsBeingAttached()
    {
        $message = $this->createMessage();
        $message->setReturnPath('chris@w3style.co.uk');
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);

        $id = $message->getId();
        $date = preg_quote($message->getDate()->format('r'), '~');
        $boundary = $message->getBoundary();

        $part = $this->createMimePart();
        $part->setdescriptionType('text/plain');
        $part->setCharset('iso-8859-1');
        $part->setBody('foo');

        $message->attach($part);

        $attachment = $this->createAttachment();
        $attachment->setdescriptionType('application/pdf');
        $attachment->setFilename('foo.pdf');
        $attachment->setBody('<pdf data>');

        $message->attach($attachment);

        $this->assertRegExp(
            '~^'.
            'Return-Path: <chris@w3style.co.uk>'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: multipart/mixed;'."\r\n".
            ' boundary="'.$boundary.'"'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: multipart/alternative;'."\r\n".
            ' boundary="(.*?)"'."\r\n".
            "\r\n\r\n".
            '--\\1'."\r\n".
            'description-Type: text/plain; charset=iso-8859-1'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'foo'.
            "\r\n\r\n".
            '--\\1--'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: application/pdf; name=foo.pdf'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-Disposition: attachment; filename=foo.pdf'."\r\n".
            "\r\n".
            preg_quote(base64_encode('<pdf data>'), '~').
            "\r\n\r\n".
            '--'.$boundary.'--'."\r\n".
            '$~D',
            $message->toString()
            );
    }

    public function testAttachmentsAndEmbeddedFilesBeingAttached()
    {
        $message = $this->createMessage();
        $message->setReturnPath('chris@w3style.co.uk');
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);

        $id = $message->getId();
        $date = preg_quote($message->getDate()->format('r'), '~');
        $boundary = $message->getBoundary();

        $part = $this->createMimePart();
        $part->setdescriptionType('text/plain');
        $part->setCharset('iso-8859-1');
        $part->setBody('foo');

        $message->attach($part);

        $attachment = $this->createAttachment();
        $attachment->setdescriptionType('application/pdf');
        $attachment->setFilename('foo.pdf');
        $attachment->setBody('<pdf data>');

        $message->attach($attachment);

        $file = $this->createEmbeddedFile();
        $file->setdescriptionType('image/jpeg');
        $file->setFilename('myimage.jpg');
        $file->setBody('<image data>');

        $message->attach($file);

        $cid = $file->getId();

        $this->assertRegExp(
            '~^'.
            'Return-Path: <chris@w3style.co.uk>'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: multipart/mixed;'."\r\n".
            ' boundary="'.$boundary.'"'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: multipart/alternative;'."\r\n".
            ' boundary="(.*?)"'."\r\n".
            "\r\n\r\n".
            '--\\1'."\r\n".
            'description-Type: text/plain; charset=iso-8859-1'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'foo'.

            "\r\n\r\n".
            '--\\1'."\r\n".
            'description-Type: multipart/related;'."\r\n".
            ' boundary="(.*?)"'."\r\n".
            "\r\n\r\n".
            '--\\2'."\r\n".
            'description-Type: image/jpeg; name=myimage.jpg'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-ID: <'.$cid.'>'."\r\n".
            'description-Disposition: inline; filename=myimage.jpg'."\r\n".
            "\r\n".
            preg_quote(base64_encode('<image data>'), '~').
            "\r\n\r\n".
            '--\\2--'."\r\n".
            "\r\n\r\n".
            '--\\1--'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: application/pdf; name=foo.pdf'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-Disposition: attachment; filename=foo.pdf'."\r\n".
            "\r\n".
            preg_quote(base64_encode('<pdf data>'), '~').
            "\r\n\r\n".
            '--'.$boundary.'--'."\r\n".
            '$~D',
            $message->toString()
            );
    }

    public function testComplexEmbeddingOfdescription()
    {
        $message = $this->createMessage();
        $message->setReturnPath('chris@w3style.co.uk');
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);

        $id = $message->getId();
        $date = preg_quote($message->getDate()->format('r'), '~');
        $boundary = $message->getBoundary();

        $attachment = $this->createAttachment();
        $attachment->setdescriptionType('application/pdf');
        $attachment->setFilename('foo.pdf');
        $attachment->setBody('<pdf data>');

        $message->attach($attachment);

        $file = $this->createEmbeddedFile();
        $file->setdescriptionType('image/jpeg');
        $file->setFilename('myimage.jpg');
        $file->setBody('<image data>');

        $part = $this->createMimePart();
        $part->setdescriptionType('text/html');
        $part->setCharset('iso-8859-1');
        $part->setBody('foo <img src="'.$message->embed($file).'" />');

        $message->attach($part);

        $cid = $file->getId();

        $this->assertRegExp(
            '~^'.
            'Return-Path: <chris@w3style.co.uk>'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: multipart/mixed;'."\r\n".
            ' boundary="'.$boundary.'"'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: multipart/related;'."\r\n".
            ' boundary="(.*?)"'."\r\n".
            "\r\n\r\n".
            '--\\1'."\r\n".
            'description-Type: text/html; charset=iso-8859-1'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'foo <img src=3D"cid:'.$cid.'" />'.//=3D is just = in QP
            "\r\n\r\n".
            '--\\1'."\r\n".
            'description-Type: image/jpeg; name=myimage.jpg'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-ID: <'.$cid.'>'."\r\n".
            'description-Disposition: inline; filename=myimage.jpg'."\r\n".
            "\r\n".
            preg_quote(base64_encode('<image data>'), '~').
            "\r\n\r\n".
            '--\\1--'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: application/pdf; name=foo.pdf'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-Disposition: attachment; filename=foo.pdf'."\r\n".
            "\r\n".
            preg_quote(base64_encode('<pdf data>'), '~').
            "\r\n\r\n".
            '--'.$boundary.'--'."\r\n".
            '$~D',
            $message->toString()
            );
    }

    public function testAttachingAndDetachingdescription()
    {
        $message = $this->createMessage();
        $message->setReturnPath('chris@w3style.co.uk');
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);

        $id = $message->getId();
        $date = preg_quote($message->getDate()->format('r'), '~');
        $boundary = $message->getBoundary();

        $part = $this->createMimePart();
        $part->setdescriptionType('text/plain');
        $part->setCharset('iso-8859-1');
        $part->setBody('foo');

        $message->attach($part);

        $attachment = $this->createAttachment();
        $attachment->setdescriptionType('application/pdf');
        $attachment->setFilename('foo.pdf');
        $attachment->setBody('<pdf data>');

        $message->attach($attachment);

        $file = $this->createEmbeddedFile();
        $file->setdescriptionType('image/jpeg');
        $file->setFilename('myimage.jpg');
        $file->setBody('<image data>');

        $message->attach($file);

        $cid = $file->getId();

        $message->detach($attachment);

        $this->assertRegExp(
            '~^'.
            'Return-Path: <chris@w3style.co.uk>'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: multipart/alternative;'."\r\n".
            ' boundary="'.$boundary.'"'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: text/plain; charset=iso-8859-1'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'foo'.
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: multipart/related;'."\r\n".
            ' boundary="(.*?)"'."\r\n".
            "\r\n\r\n".
            '--\\1'."\r\n".
            'description-Type: image/jpeg; name=myimage.jpg'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-ID: <'.$cid.'>'."\r\n".
            'description-Disposition: inline; filename=myimage.jpg'."\r\n".
            "\r\n".
            preg_quote(base64_encode('<image data>'), '~').
            "\r\n\r\n".
            '--\\1--'."\r\n".
            "\r\n\r\n".
            '--'.$boundary.'--'."\r\n".
            '$~D',
            $message->toString(),
            '%s: Attachment should have been detached'
            );
    }

    public function testBoundaryDoesNotAppearAfterAllPartsAreDetached()
    {
        $message = $this->createMessage();
        $message->setReturnPath('chris@w3style.co.uk');
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);

        $id = $message->getId();
        $date = $message->getDate();
        $boundary = $message->getBoundary();

        $part1 = $this->createMimePart();
        $part1->setdescriptionType('text/plain');
        $part1->setCharset('iso-8859-1');
        $part1->setBody('foo');

        $message->attach($part1);

        $part2 = $this->createMimePart();
        $part2->setdescriptionType('text/html');
        $part2->setCharset('iso-8859-1');
        $part2->setBody('test <b>foo</b>');

        $message->attach($part2);

        $message->detach($part1);
        $message->detach($part2);

        $this->assertEquals(
            'Return-Path: <chris@w3style.co.uk>'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString(),
            '%s: Message should be restored to orignal state after parts are detached'
            );
    }

    public function testCharsetFormatOrDelSpAreNotShownWhenBoundaryIsSet()
    {
        $message = $this->createMessage();
        $message->setReturnPath('chris@w3style.co.uk');
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);
        $message->setCharset('utf-8');
        $message->setFormat('flowed');
        $message->setDelSp(true);

        $id = $message->getId();
        $date = $message->getDate();
        $boundary = $message->getBoundary();

        $part1 = $this->createMimePart();
        $part1->setdescriptionType('text/plain');
        $part1->setCharset('iso-8859-1');
        $part1->setBody('foo');

        $message->attach($part1);

        $part2 = $this->createMimePart();
        $part2->setdescriptionType('text/html');
        $part2->setCharset('iso-8859-1');
        $part2->setBody('test <b>foo</b>');

        $message->attach($part2);

        $this->assertEquals(
            'Return-Path: <chris@w3style.co.uk>'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: multipart/alternative;'."\r\n".
            ' boundary="'.$boundary.'"'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: text/plain; charset=iso-8859-1'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'foo'.
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: text/html; charset=iso-8859-1'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'test <b>foo</b>'.
            "\r\n\r\n".
            '--'.$boundary.'--'."\r\n",
            $message->toString()
            );
    }

    public function testBodyCanBeSetWithAttachments()
    {
        $message = $this->createMessage();
        $message->setReturnPath('chris@w3style.co.uk');
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);
        $message->setdescriptionType('text/html');
        $message->setCharset('iso-8859-1');
        $message->setBody('foo');

        $id = $message->getId();
        $date = $message->getDate()->format('r');
        $boundary = $message->getBoundary();

        $attachment = $this->createAttachment();
        $attachment->setdescriptionType('application/pdf');
        $attachment->setFilename('foo.pdf');
        $attachment->setBody('<pdf data>');

        $message->attach($attachment);

        $this->assertEquals(
            'Return-Path: <chris@w3style.co.uk>'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: multipart/mixed;'."\r\n".
            ' boundary="'.$boundary.'"'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: text/html; charset=iso-8859-1'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'foo'.
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: application/pdf; name=foo.pdf'."\r\n".
            'description-Transfer-Encoding: base64'."\r\n".
            'description-Disposition: attachment; filename=foo.pdf'."\r\n".
            "\r\n".
            base64_encode('<pdf data>').
            "\r\n\r\n".
            '--'.$boundary.'--'."\r\n",
            $message->toString()
            );
    }

    public function testHtmlPartAlwaysAppearsLast()
    {
        $message = $this->createMessage();
        $message->setReturnPath('chris@w3style.co.uk');
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);

        $id = $message->getId();
        $date = $message->getDate()->format('r');
        $boundary = $message->getBoundary();

        $part1 = $this->createMimePart();
        $part1->setdescriptionType('text/html');
        $part1->setBody('foo');

        $part2 = $this->createMimePart();
        $part2->setdescriptionType('text/plain');
        $part2->setBody('bar');

        $message->attach($part1);
        $message->attach($part2);

        $this->assertEquals(
            'Return-Path: <chris@w3style.co.uk>'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: multipart/alternative;'."\r\n".
            ' boundary="'.$boundary.'"'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'bar'.
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: text/html'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'foo'.
            "\r\n\r\n".
            '--'.$boundary.'--'."\r\n",
            $message->toString()
            );
    }

    public function testBodyBecomesPartIfOtherPartsAttached()
    {
        $message = $this->createMessage();
        $message->setReturnPath('chris@w3style.co.uk');
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);
        $message->setdescriptionType('text/html');
        $message->setBody('foo');

        $id = $message->getId();
        $date = $message->getDate()->format('r');
        $boundary = $message->getBoundary();

        $part2 = $this->createMimePart();
        $part2->setdescriptionType('text/plain');
        $part2->setBody('bar');

        $message->attach($part2);

        $this->assertEquals(
            'Return-Path: <chris@w3style.co.uk>'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: multipart/alternative;'."\r\n".
            ' boundary="'.$boundary.'"'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'bar'.
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'description-Type: text/html'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'foo'.
            "\r\n\r\n".
            '--'.$boundary.'--'."\r\n",
            $message->toString()
            );
    }

    public function testBodyIsCanonicalized()
    {
        $message = $this->createMessage();
        $message->setReturnPath('chris@w3style.co.uk');
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);
        $message->setBody(
            'just a test body'."\n".
            'with a new line'
            );
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Return-Path: <chris@w3style.co.uk>'."\r\n".
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'description-Type: text/plain'."\r\n".
            'description-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'just a test body'."\r\n".
            'with a new line',
            $message->toString()
            );
    }

    protected function createMessage()
    {
        return new Swift_Message();
    }

    protected function createMimePart()
    {
        return new Swift_MimePart();
    }

    protected function createAttachment()
    {
        return new Swift_Attachment();
    }

    protected function createEmbeddedFile()
    {
        return new Swift_EmbeddedFile();
    }
}
