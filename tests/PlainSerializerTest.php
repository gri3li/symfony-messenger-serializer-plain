<?php

namespace Gri3li\SymfonyMessengerSerializerPlain\Tests;

use Gri3li\SymfonyMessengerSerializerPlain\PlainSerializer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;

class PlainSerializerTest extends TestCase
{
    public function testDecodeReturnsEnvelope(): void
    {
        $serializer = new PlainSerializer();
        $encodedEnvelope = ['body' => '{"param": "Test param"}'];
        $envelope = $serializer->decode($encodedEnvelope);

        $this->assertEquals('Test param', $envelope->getMessage()->param);
    }

    public function testDecodeThrowsExceptionForInvalidJson(): void
    {
        $this->expectException(MessageDecodingFailedException::class);

        $invalidEncodedEnvelope = ['body' => 'invalid json'];
        $serializer = new PlainSerializer();
        $serializer->decode($invalidEncodedEnvelope);
    }

    public function testEncodeReturnsEncodedArray(): void
    {
        $message = (object)['param' => 'Test param'];
        $envelope = new Envelope($message);
        $serializer = new PlainSerializer();
        $encoded = $serializer->encode($envelope);

        $this->assertArrayHasKey('body', $encoded);
        $this->assertEquals('{"param":"Test param"}', $encoded['body']);
    }

    public function testEncodeHandlesEmptyMessage(): void
    {
        $message = (object)[];
        $envelope = new Envelope($message);
        $serializer = new PlainSerializer();
        $encoded = $serializer->encode($envelope);

        $this->assertArrayHasKey('body', $encoded);
        $this->assertEquals('{}', $encoded['body']);
    }
}
