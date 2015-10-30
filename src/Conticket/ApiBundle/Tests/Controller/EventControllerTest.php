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
namespace Conticket\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Doctrine\Common\DataFixtures\Executor\MongoDBExecutor;
use Doctrine\Common\DataFixtures\Purger\MongoDBPurger;

use Conticket\ApiBundle\Tests\Fixtures\Document\LoadEventData;
    
class EventControllerTest extends WebTestCase
{
    protected $kernelDir;
    protected $event;
    
    public function setUp()
    {
        $this->client = static::createClient();
        $this->loadFixtures();
    }
    
    public function tearDown()
    {
        $container = $this->client->getContainer();
        $purger    = new MongoDBPurger($container->get('doctrine_mongodb.odm.document_manager'));
        
        $purger->purge();
    }
    
    public function testGetEventsAction()
    {
        $this->client->request('GET', '/api/events', ['ACCEPT' => 'application/json']);
        
        $response = $this->client->getResponse();
        $content  = $response->getContent();
        $decoded  = json_decode($content, true);
        
        $this->assertJsonResponse($response, 200);
        $this->assertTrue(in_array($this->event->getId(), array_column($decoded['events'], 'id')));
    }
    
    public function testGetEventAction()
    {
        $this->client->request('GET', '/api/events/' . $this->event->getId(), ['ACCEPT' => 'application/json']);
        
        $response = $this->client->getResponse();
        $content  = $response->getContent();
        $decoded  = json_decode($content, true);
        
        $this->assertJsonResponse($response, 200);
        $this->assertEquals($this->event->getId(), $decoded['event']['id']);
    }
    
    public function testPostEventAction()
    {
        $this->client->request(
            'POST',
            '/api/events',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"name":"title1","description":"oi","banner":"image.jpg","gateway":{"name":"coisinha","type":"tipinho","key":"comida"},"tickets":[{"name":"ingresso 1"}],"coupons":[{"name":"cupom 1"}]}'
        );
        
        $this->assertJsonResponse($this->client->getResponse(), 201, false);
    }

    public function testPutEventAction()
    {
        $this->client->request(
            'PUT',
            '/api/events/' . $this->event->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"name":"title2"}'
        );
        
        $response = $this->client->getResponse();
        
        $this->assertEquals($response->getStatusCode(), 204, $response->getContent());
    }
    
    protected function assertJsonResponse(
        $response, 
        $statusCode = 200, 
        $checkValidJson =  true, 
        $contentType = 'application/json'
    )
    {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', $contentType),
            $response->headers
        );

        if ($checkValidJson) {
            $decode = json_decode($response->getContent());
            $this->assertTrue(($decode != null && $decode != false),
                'is response valid json: [' . $response->getContent() . ']'
            );
        }
    }
    
    protected function loadFixtures()
    {
        $container = $this->client->getContainer();
        $executor  = new MongoDBExecutor($container->get('doctrine_mongodb.odm.document_manager'));
        
        $executor->execute([new LoadEventData], true);
         
        $events = LoadEventData::$events;
        $this->event = array_pop($events);
    }
    
    protected function getContainer()
    {
        if (!empty($this->kernelDir)) {
            $tmpKernelDir = isset($_SERVER['KERNEL_DIR']) ? $_SERVER['KERNEL_DIR'] : null;
            $_SERVER['KERNEL_DIR'] = getcwd().$this->kernelDir;
        }

        $cacheKey = $this->kernelDir.'|test';
        if (empty($this->containers[$cacheKey])) {
            $options = ['environment' => 'test'];
            $kernel = $this->createKernel($options);
            $kernel->boot();

            $this->containers[$cacheKey] = $kernel->getContainer();
        }

        if (isset($tmpKernelDir)) {
            $_SERVER['KERNEL_DIR'] = $tmpKernelDir;
        }

        return $this->containers[$cacheKey];
    }
}
