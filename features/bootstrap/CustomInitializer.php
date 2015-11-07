<?php

namespace Feature;

use Behat\Behat\Context\Initializer\ContextInitializer;
use Behat\Behat\Context\Context;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
class CustomInitializer implements ContextInitializer
{
    /**
     * @param Context $context
     *
     * @return bool
     */
    public function supportsContext(Context $context)
    {
        return $context instanceof AbstractContext;
    }

    /**
     * {@inheritDoc}
     */
    public function initializeContext(Context $context)
    {
        if (! $this->supportsContext($context)) {
            return;
        }

        // TODO: Move this parameters to behat.yml or services.yml
        AnnotationDriver::registerAnnotationClasses();

        $config = new Configuration();
        $config->setProxyDir(sys_get_temp_dir());
        $config->setProxyNamespace('Proxies');
        $config->setHydratorDir(sys_get_temp_dir());
        $config->setHydratorNamespace('Hydrators');
        $config->setMetadataDriverImpl(AnnotationDriver::create(__DIR__ . '/../../src/Conticket/ApiBundle/Document/'));
        $config->setDefaultDB('symfony');

        $documentManager = DocumentManager::create(
            new Connection(getenv('MONGO_HOST') ? getenv('MONGO_HOST') : '192.168.33.99'),
            $config
        );

        /** @var AbstractContext $context */
        $context->setDocumentManager($documentManager);

        if (getenv('BASE_URL')) {
            echo 'Content: ' . "\n";
            echo file_get_contents('http://' . getenv('BASE_URL'));
            $context->setMinkParameter('base_url', 'http://' . getenv('BASE_URL'));
        }
    }
}
