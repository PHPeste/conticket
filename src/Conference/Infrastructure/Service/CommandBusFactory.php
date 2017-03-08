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

declare(strict_types=1);

namespace Conticket\Conference\Infrastructure\Service;

use Interop\Container\ContainerInterface;
use Prooph\Common\Event\ActionEvent;
use Prooph\Common\Event\ActionEventEmitter;
use Prooph\Common\Event\ActionEventListenerAggregate;
use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\MessageBus;
use Prooph\ServiceBus\Plugin\ServiceLocatorPlugin;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class CommandBusFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): CommandBus
    {
        $commandBus = new CommandBus();
        $commandBus->utilize(new ServiceLocatorPlugin($container));
        $commandBus->utilize($this->buildCommandRouter($container));

        return $commandBus;
    }

    private function buildCommandRouter(ContainerInterface $container): ActionEventListenerAggregate
    {
        return new class($container)  implements ActionEventListenerAggregate
        {
            /**
             * @var ContainerInterface
             */
            private $container;

            public function __construct(ContainerInterface $container)
            {
                $this->container = $container;
            }

            /**
             * {@inheritDoc}
             */
            public function attach(ActionEventEmitter $dispatcher)
            {
                $dispatcher->attachListener(MessageBus::EVENT_ROUTE, [$this, 'onRoute']);
            }

            /**
             * {@inheritDoc}
             *
             * @throws \BadMethodCallException
             */
            public function detach(ActionEventEmitter $dispatcher)
            {
                throw new \BadMethodCallException('Not implemented');
            }

            public function onRoute(ActionEvent $actionEvent)
            {
                $actionEvent->setParam(
                    MessageBus::EVENT_PARAM_MESSAGE_HANDLER,
                    (string) $actionEvent->getParam(MessageBus::EVENT_PARAM_MESSAGE_NAME)
                );
            }
        };
    }
}
