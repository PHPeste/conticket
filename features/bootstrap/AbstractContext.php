<?php

namespace Feature;

use Behat\MinkExtension\Context\MinkContext;
use Doctrine\ODM\MongoDB\DocumentManager;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
class AbstractContext extends MinkContext
{
    /**
     * @var DocumentManager
     */
    protected $documentManager;

    /**
     * @return DocumentManager
     */
    public function getDocumentManager()
    {
        return $this->documentManager;
    }

    /**
     * @param DocumentManager $documentManager
     */
    public function setDocumentManager(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }
}
