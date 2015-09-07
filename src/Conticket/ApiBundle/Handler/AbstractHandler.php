<?php
    
namespace Conticket\ApiBundle\Handler;

use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Conticket\ApiBundle\Document\DocumentInterface;
use Symfony\Component\Form\AbstractType;

abstract class AbstractHandler
{
    private $documentManager;
    private $repository;
    private $formFactory;
    
    public function __construct(DocumentManager $documentManager, FormFactoryInterface $formFactory)
    {
        $this->documentManager = $documentManager;
        $this->formFactory     = $formFactory;
        $this->repository      = $documentManager->getRepository($this->getRepositoryClassName());
    }
    
    abstract public function getRepositoryClassName();
    
    public function all($limit = 5, $offset = 0)
    {
        return $this->repository->findBy([], null, $limit, $offset);
    }
    
    public function find($id)
    {
        return $this->repository->find($id);
    }
    
    public function post(DocumentInterface $document, AbstractType $formType, array $params)
    {
        return $this->processForm($document, $formType, $params, 'POST');
    }
    
    public function put(DocumentInterface $document, AbstractType $formType, array $params)
    {
        return $this->processForm($document, $formType, $params);
    }
    
    private function processForm(DocumentInterface $document, AbstractType $formType, array $params, $method = "PUT")
    {
        $form = $this->formFactory->create($formType, $document, ['method' => $method]);
        $form->submit($params, 'PATCH' !== $method);
        
        if ($form->isValid()) {
            $document = $form->getData();
            $this->documentManager->persist($document);
            $this->documentManager->flush();

            return $document;
        }
        
        $messages = implode(', ', $this->getErrorMessages($form));
        
        throw new \RuntimeException('Invalid submitted data. ' . $messages);
    }
    
    private function getErrorMessages(\Symfony\Component\Form\Form $form) 
    {
        $errors = [];
        
        foreach ($form->getErrors(true) as $key => $error) {
            $errors[$key] = $error->getMessage();
        }   
        var_dump($errors);exit;
        return $errors;
    }
}