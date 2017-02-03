<?php

use Interop\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\Router\FastRouteRouter;

return (function () {
    return [
        // @todo move factories to proper classes
        'factories' => [
            Application::class     => function (ContainerInterface $container) {
                return new Application($container->get(FastRouteRouter::class), $container);
            },
            FastRouteRouter::class => function (ContainerInterface $container) {
                return new FastRouteRouter();
            },
        ]
    ];
})();
