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
namespace Feature;

use Behat\Gherkin\Node\TableNode;
use Conticket\ApiBundle\Document\Event;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_Assert as Assert;

/**
 * Event Context.
 *
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
class EventContext extends AbstractContext
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Response
     */
    protected $response;

    /**
     * EventContext constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @Given /^application has following events:$/
     *
     * @param TableNode $table
     */
    public function applicationHasFollowingEvents(TableNode $table)
    {
        $this->getDocumentManager()
            ->getSchemaManager()
            ->dropDocumentCollection(Event::class);

        foreach ($table->getHash() as $row) {
            $event = new Event($row['name'], $row['description'], $row['banner']);

            $this->getDocumentManager()->persist($event);
            $this->getDocumentManager()->flush();
        }
    }

    /**
     * @Given /^I do a request to event list page$/
     */
    public function iDoARequestToEventListPage()
    {
        $this->visitPath('/api/events');
    }

    /**
     * @Then /^I should see (\d+) event listed$/
     */
    public function iShouldSeeEventListed($amount)
    {
        Assert::assertSame(
            (int) $amount,
            count(json_decode($this->getSession()->getPage()->getContent()))
        );
    }

    /**
     * @Given /^I should see "([^"]*)" on json response$/
     */
    public function iShouldSeeOnJsonResponse($text)
    {
        Assert::assertContains($text, $this->getSession()->getPage()->getContent());
    }

    /**
     * @When /^I "([^"]*)" to "([^"]*)" the following data:$/
     *
     * @param           $method
     * @param           $url
     * @param TableNode $postData
     */
    public function iToUrlTheFollowingData($method, $url, TableNode $postData)
    {
        $absoluteUrl    = $this->getMinkParameter('base_url') . ltrim($url, '/');
        $this->response = $this->client->request($method, $absoluteUrl, $postData->getHash());
    }

    /**
     * @Then /^I should see "([^"]*)" on last json response$/
     *
     * @param $expected
     *
     * @throws \Exception
     */
    public function iShouldSeeOnLastJsonResponse($expected)
    {

        if (false === strpos($this->response->getBody(), $expected)) {
            throw new \Exception(sprintf('"%s" is expects on "%s"', $expected, $this->response->getBody()));
        }
    }

    /**
     * @Given /^the response status code should be (\d+) at last response$/
     *
     * @param int $statusCode
     */
    public function theResponseStatusCodeShouldBeAtLastResponse($statusCode)
    {
        Assert::assertEquals(
            $statusCode,
            $this->response->getStatusCode()
        );
    }
}
