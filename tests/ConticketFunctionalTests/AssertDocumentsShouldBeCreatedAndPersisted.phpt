--TEST--
Verifies that entities can be created and persisted properly
--FILE--
<?php

require __DIR__ . '/../../vendor/autoload.php';

use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

use AppBundle\Document;

AnnotationDriver::registerAnnotationClasses();

$config = new Configuration();
$config->setProxyDir(sys_get_temp_dir());
$config->setProxyNamespace('Proxies');
$config->setHydratorDir(sys_get_temp_dir());
$config->setHydratorNamespace('Hydrators');
$config->setMetadataDriverImpl(AnnotationDriver::create(__DIR__ . '/../../data/cache/classes'));

$dm = DocumentManager::create(new Connection(), $config);

$user = new Document\User(
    'Abdala Cerqueira',
    'organizacao@phpeste.net'
);
echo 'User was created' . PHP_EOL;

$event = new Document\Event(
    'PHPeste',
    'Conferência de PHP do Nordeste',
    'phpeste.png'
);
echo 'Banner was created' . PHP_EOL;

$ticket = new Document\Ticket(
    'Gold',
    'Acesso VIP',
    100,
    99.99,
    new DateTime('now'),
    new DateTime('now')
);

echo 'Ticket was created' . PHP_EOL;

$event->addTicket($ticket);
echo 'Ticket was added to event' . PHP_EOL;

$coupon = new Document\Coupon(
    'Promotional',
    'Coupon expensive',
    '123',
    9.99,
    10,
    new DateTime('now')
);
echo 'Coupon was created' . PHP_EOL;

$event->addCoupon($coupon);
echo 'Coupon was added to event' . PHP_EOL;

$order = new Document\Order(
    'Compra de ingresso GOLD',
    90.00,
    $ticket,
    $coupon
);
echo 'Order was added to event' . PHP_EOL;

$user->addEvent($event);
echo 'Event was added to the user' . PHP_EOL;

$user->addOrder($order);
echo 'Order was added to the user' . PHP_EOL;

$dm->persist($user);
$dm->flush();
echo 'Persisted with success';

?>
--EXPECT--
User was created
Banner was created
Ticket was created
Ticket was added to event
Coupon was created
Coupon was added to event
Order was added to event
Event was added to the user
Order was added to the user
Persisted with success
