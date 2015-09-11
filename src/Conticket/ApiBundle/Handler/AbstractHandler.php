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
namespace Conticket\ApiBundle\Handler;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;

use Doctrine\ODM\MongoDB\DocumentManager;

use Conticket\ApiBundle\Document\DocumentInterface;

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
    
    public function post(AbstractType $formType, array $params)
    {
        return $this->processForm(null, $formType, $params, Request::METHOD_POST);
    }
    
    public function put(DocumentInterface $document, AbstractType $formType, array $params)
    {
        return $this->processForm($document, $formType, $params);
    }
    
    private function processForm($document, AbstractType $formType, array $params, $method = Request::METHOD_PUT)
    {
        $form = $this->formFactory->create($formType, $document, ['method' => $method]);
        $form->submit($params, Request::METHOD_PATCH !== $method);
        
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
        
        return $errors;
    }
}
