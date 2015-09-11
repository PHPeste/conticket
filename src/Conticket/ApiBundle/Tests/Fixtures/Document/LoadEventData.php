<?php
    
namespace Conticket\ApiBundle\Tests\Fixtures\Document;

use Doctrine\Common\Persistence\ObjectManager;

use Conticket\ApiBundle\Document;

class LoadEventData implements FixtureInterface
{
    static public $events = array();
    
    public function load(ObjectManager $manager)
    {
        $user = new Document\User(
            'Abdala Cerqueira',
            'organizacao@phpeste.net'
        );
        
        $gateway = new Document\Gateway('PagMenosVirtual', 'pagmenos', '123indizinho');
        
        $event = new Document\Event(
            'PHPeste',
            'Conferência de PHP do Nordeste',
            'phpeste.png',
            $gateway
        );
        
        $ticket = new Document\Ticket(
            'Gold',
            'Acesso VIP',
            100,
            99.99,
            new DateTime('now'),
            new DateTime('now')
        );

        $event->addTicket($ticket);
        
        $coupon = new Document\Coupon(
            'Promotional',
            'Coupon expensive',
            '123',
            9.99,
            10,
            new DateTime('now')
        );
        
        $event->addCoupon($coupon);
        
        $order = new Document\Order(
            'Compra de ingresso GOLD',
            90.00,
            $ticket,
            $coupon
        );
        
        $user->addEvent($event);
        
        $user->addOrder($order);
        
        $manager->persist($user);
        $manager->flush();
        
        self::$events[] = $event;
    }
}