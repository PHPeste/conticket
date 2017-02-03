<?php

declare(strict_types=1);

(function () {
    require __DIR__ . '/../vendor/autoload.php';

    /* @var $serviceManager \Zend\ServiceManager\ServiceManager */
    $serviceManager = require __DIR__ . '/../config/service-manager.php';

    $app = $serviceManager->get(\Zend\Expressive\Application::class);

})();
