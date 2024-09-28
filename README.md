PlainSerializer for Symfony Messenger
=====================================

This package provides a simplified implementation of the [`SerializerInterface`](https://github.com/symfony/messenger/blob/7.1/Transport/Serialization/SerializerInterface.php)  for [Symfony Messenger](https://symfony.com/doc/current/components/messenger.html). It serializes and deserializes messages without stamps support, making it a lightweight solution for interacting with microservices that do not support the Symfony Messenger message format.

Installation
------------

Install the package via Composer:

```
composer require gri3li/symfony-messenger-serializer-plain
```

Usage
-----

Since all messages will be serialized and deserialized as instances of `StdClass`, you will most likely need to provide custom implementations of the interfaces:

* [`SendersLocatorInterface`](https://github.com/symfony/messenger/blob/7.1/Transport/Sender/SendersLocatorInterface.php): Defines which sender will be used for dispatching a message.
* [`HandlersLocatorInterface`](https://github.com/symfony/messenger/blob/7.1/Handler/HandlersLocatorInterface.php): Defines which handler will process the message.

By creating your own implementations of these interfaces, you can retain full control over how messages are routed and handled, even without class-based differentiation.