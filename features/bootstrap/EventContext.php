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
use ConticketTest\Fixtures\ConferenceFixture;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOMySql\Driver;
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
        $this->client = new Client([
            'base_uri' => $this->getMinkParameter('base_url'),
        ]);
    }

    /**
     * @Given /^I do a request to event list page$/
     */
    public function iDoARequestToEventListPage()
    {
        $this->visitPath('/api/events');

        assert(200 === $this->response->getStatusCode());
    }

    /**
     * @Then /^I should see (\d+) event listed$/
     */
    public function iShouldSeeEventListed($amount)
    {
        Assert::assertEquals(
            $amount,
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
        $params         = $postData->getHash()[0];
        $this->response = $this->client->request(
            $method,
            $this->locatePath($url),
            [
                'form_params' => $params,
            ]
        );
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

    /**
     * @Given /^I have one conference registered on the database$/
     * @throws \Doctrine\ORM\ORMException
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function iHaveOneConferenceRegisteredOnTheDatabase()
    {
        $connection = new Connection([
            'pdo' => new \PDO('mysql:host=localhost;dbname=conticket', 'root', 'root'),
        ],
        new Driver()
        );
        $conferenceFixture = new ConferenceFixture();
        $conferenceFixture->load($connection);
    }

    /**
     * @When I ask for the list of conferences
     *
     * @throws \Assert\AssertionFailedException
     */
    public function iAskForTheListOfConferences()
    {
        $this->visit('/conferences');

        $this->assertResponseStatus(200);
    }

    /**
     * @Then I should see :expectedAmount listed conference
     */
    public function iShouldSeeListedConference($expectedAmount)
    {
        $response = $this->getSession()->getPage()->getContent();

        $responseDecoded = json_decode($response);

        Assert::assertCount(1, $responseDecoded);
    }

    /**
     * @When I ask for the conference details
     */
    public function iAskForTheConferenceDetails()
    {
        $response = $this->getSession()->getPage()->getContent();

        $responseDecoded = json_decode($response);

        $firstConference = reset($responseDecoded);

        $conferenceId = $firstConference->id;

        $this->visit('/conference/' . $conferenceId);
    }
}
