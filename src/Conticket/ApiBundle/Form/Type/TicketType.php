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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\DataMapperInterface;

use Conticket\ApiBundle\Document\Ticket;
    
final class TicketType extends AbstractType implements DataMapperInterface
{
    const TYPE_NAME = 'ticket';
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
                ->add('description', 'textarea')
                ->add('quantity', 'integer')
                ->add('value', 'money')
                ->add('start', 'date')
                ->add('end', 'date')
                ->add('status', 'text')
                ->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
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
        $forms['quantity']->setData($data->getQuantity());
        $forms['value']->setData($data->getValue());
        $forms['start']->setData($data->getStart());
        $forms['end']->setData($data->getEnd());
        $forms['status']->setData($data->getStatus());
    }
    
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
                
        $data = new Ticket(
            $forms['name']->getData(), 
            $forms['description']->getData(),
            $forms['quantity']->getData(),
            $forms['value']->getData(),
            new \DateTime($forms['start']->getData()),
            new \DateTime($forms['end']->getData()),
            $forms['status']->getData()
        );
    }
}
