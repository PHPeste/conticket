<?php

declare(strict_types=1);

namespace Conticket\Conference\Infrastructure\Service;

use Interop\Container\ContainerInterface;
use Prooph\Common\Event\ActionEvent;
use Prooph\Common\Event\ActionEventEmitter;
use Prooph\Common\Event\ActionEventListenerAggregate;
use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\MessageBus;
use Prooph\ServiceBus\Plugin\ServiceLocatorPlugin;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class CommandBusFactory
{
    public function __invoke(ContainerInterface $container): CommandBus
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
