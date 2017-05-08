<?php

declare(strict_types=1);

use Zend\ServiceManager\ServiceManager;

return (function (): ServiceManager {
    return new ServiceManager(
        array_merge_recursive(
            require __DIR__ . '/services.php',
            require __DIR__ . '/commands.php',
            require __DIR__ . '/middlewares.php',
            require __DIR__ . '/repositories.php'
        )
    );
})();
