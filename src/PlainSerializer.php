<?php

namespace Gri3li\SymfonyMessengerSerializerPlain;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * A plain Symfony Messenger serializer without stamps handling
 *
 * @author Mikhail Gerasimov <migerasimoff@gmail.com>
 */
readonly class PlainSerializer implements SerializerInterface
{
    /**
     * @param JsonEncoder $encoder
     */
    public function __construct(
        private JsonEncoder $encoder = new JsonEncoder(defaultContext: [JsonDecode::ASSOCIATIVE => false]),
    ) {
    }

    /**
     * @param array $encodedEnvelope
     * @return Envelope
     * @throws MessageDecodingFailedException
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        if (empty($encodedEnvelope['body'])) {
            throw new MessageDecodingFailedException('Encoded envelope should have "body".');
        }
        try {
            $message = $this->encoder->decode($encodedEnvelope['body'], JsonEncoder::FORMAT);
        } catch (\Throwable $e) {
            throw new MessageDecodingFailedException('Could not decode message: ' . $e->getMessage(), 0, $e);
        }

        return new Envelope($message);
    }

    /**
     * @param Envelope $envelope
     * @return array
     * @throws MessageDecodingFailedException
     */
    public function encode(Envelope $envelope): array
    {
        try {
            $encodedEnvelope['body'] = $this->encoder->encode($envelope->getMessage(), JsonEncoder::FORMAT);
        } catch (\Throwable $e) {
            throw new MessageDecodingFailedException('Could not encode message: ' . $e->getMessage(), 0, $e);
        }

        return $encodedEnvelope;
    }
}
