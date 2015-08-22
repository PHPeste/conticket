--TEST--
Verifies that entities can be created and persisted properly
--FILE--
<?php

require __DIR__ . '/../../vendor/autoload.php';

use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

use Conticket\Document;

AnnotationDriver::registerAnnotationClasses();

$config = new Configuration();
$config->setProxyDir(__DIR__ . '/../data/cache/proxy');
$config->setProxyNamespace('Proxies');
$config->setHydratorDir(__DIR__ . '/../data/cache/hydrators');
$config->setHydratorNamespace('Hydrators');
$config->setMetadataDriverImpl(AnnotationDriver::create(__DIR__ . '/../data/cache/classes'));

$dm = DocumentManager::create(new Connection(), $config);

$user = new Document\User();
$user->setName("Abdala Cerqueira");
$user->setEmail("organizacao@phpeste.net");

$event = new Document\Event();
$event->setName("PHPeste");
$event->setDescription("Conferência de PHP do Nordeste");
$event->setBanner("phpeste.png");

$ticket = new Document\Ticket();
$ticket->setName('Gold');
$ticket->setDescription('Acesso VIP');
$ticket->setQuantity(100);
$ticket->setValue(99.99);

$event->addTicket($ticket);

$coupon = new Document\Coupon;
$coupon->setValue(9.99);

$event->addCoupon($coupon);

$order = new Document\Order;
$order->setName('Compra de ingresso GOLD');
$order->setValue(90.00);
$order->setTicket($ticket);
$order->setCoupon($coupon);

$user->addEvent($event);
$user->addOrder($order);

$dm->persist($user);
$dm->flush();

echo "Registrado com sucesso!";

?>
--EXPECT--
Registrado com sucesso!
