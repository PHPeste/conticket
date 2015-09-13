<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */ 
namespace Conticket\ApiBundle\Tests\Fixtures\Document;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
    
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
            new \DateTime('now'),
            new \DateTime('now')
        );

        $event->addTicket($ticket);
        
        $coupon = new Document\Coupon(
            'Promotional',
            'Coupon expensive',
            '123',
            9.99,
            10,
            new \DateTime('now')
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