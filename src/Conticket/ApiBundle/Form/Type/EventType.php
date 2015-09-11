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
namespace Conticket\ApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Conticket\ApiBundle\Document\Event;
use Conticket\ApiBundle\Document\Gateway;
use Conticket\ApiBundle\Document\Ticket;
use Conticket\ApiBundle\Document\Coupon;

final class EventType extends AbstractType implements DataMapperInterface
{
    const TYPE_NAME = 'event';
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'text')
                ->add('name', 'text')
                ->add('description', 'text')
                ->add('banner', 'text')
                ->add($builder->create('gateway', new GatewayType()))
                ->add('ticket', 'collection')
                ->add('coupon', 'collection')
                ->setDataMapper($this);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
            'csrf_protection' => false,
            'empty_data' => null
        ]);
    }

    public function getName()
    {
        return static::TYPE_NAME;
    }
    
    public function mapDataToForms($data, $forms)
    {
        if (! $data) {
            return;
        }
        
        $forms = iterator_to_array($forms);
        
        $forms['name']->setData($data->getName());
        $forms['description']->setData($data->getDescription());
        $forms['banner']->setData($data->getBanner());
        $forms['gateway']->setData($data->getGateway());
        $forms['ticket']->setData($data->getTickets());
        $forms['coupon']->setData($data->getCoupons());
    }
    
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        
        $gateway = $forms['gateway']->getData();
        $tickets = $forms['ticket']->getData();
        $coupons = $forms['coupon']->getData();
        $params = [
            $forms['name']->getData(),
            $forms['description']->getData(),
            $forms['banner']->getData(),
            $this->createGateway($gateway)
        ];
        
        $data = $this->resolveEventDocument($data, $params);
        
        if (count($tickets)) {
            foreach ($tickets as $ticket) {
                $data->addTicket($this->createTicket($ticket));
            }
        }
        
        if (count($tickets)) {
            foreach ($coupons as $coupon) {
                $data->addCoupon($this->createCoupon($coupon));
            }
        }
    }
    
    protected function resolveEventDocument($data, array $params)
    {
        if (! $data) {
            return new Event(...$params);
        } 
        
        return $data->populate(...$params);
    }
    
    protected function createGateway($data)
    {
        if (! count($data)) {
            return null;
        }
        
        return new Gateway(
            $data['name'], 
            $data['type'], 
            $data['key']
        );
    }
    
    protected function createTicket($data)
    {
        return new Ticket(
            $data['name'], 
            $data['description'], 
            $data['quantity'], 
            $data['value'],
            new \DateTime($data['start']),
            new \DateTime($data['end']),
            $data['status']
        );
    }
    
    protected function createCoupon($data)
    {
        return new Coupon(
            $data['name'], 
            $data['description'], 
            $data['code'], 
            $data['value'],
            $data['quantoty'],
            new \DateTime($data['expire'])
        );
    }
}
