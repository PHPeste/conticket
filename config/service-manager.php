<?php

declare(strict_types=1);

// NOTE: Encapsulate in an IIFE to avoid future mistakes with
// variables in global space.
return (function () {
    return new \Zend\ServiceManager\ServiceManager(
        array_merge_recursive(
            require __DIR__ . '/services.php',
            require __DIR__ . '/middlewares.php'
        )
    );
})();
