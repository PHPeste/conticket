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

declare(strict_types=1);

namespace Feature;

use ConticketTest\Fixtures\ConferenceFixture;
use PHPUnit_Framework_Assert as Assert;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class ConferenceContext extends AbstractContext
{
    /**
     * @Given /^I have one conference registered on the database$/
     * @throws \InvalidArgumentException
     */
    public function iHaveOneConferenceRegisteredOnTheDatabase(): void
    {
        $conferenceFixture = new ConferenceFixture();
        $conferenceFixture->load($this->connection());
    }

    /**
     * @Given /^I should see "([^"]*)" on json response$/
     */
    public function iShouldSeeOnJsonResponse($text): void
    {
        Assert::assertContains($text, $this->getSession()->getPage()->getContent());
    }

    /**
     * @When I ask for the list of conferences
     *
     * @throws \Assert\AssertionFailedException
     */
    public function iAskForTheListOfConferences(): void
    {
        $this->visit('/conferences');

        $this->assertResponseStatus(200);
    }

    /**
     * @Then I should see :expectedAmount listed conference
     */
    public function iShouldSeeListedConference(string $expectedAmount): void
    {
        $response = $this->getSession()->getPage()->getContent();

        $responseDecoded = json_decode($response);

        Assert::assertCount(1, $responseDecoded);
    }

    /**
     * @When I ask for the conference details
     */
    public function iAskForTheConferenceDetails(): void
    {
        $response = $this->getSession()->getPage()->getContent();

        $responseDecoded = json_decode($response);

        $firstConference = reset($responseDecoded);

        $conferenceId = $firstConference->id;

        $this->visit('/conference/' . $conferenceId);
    }
}
