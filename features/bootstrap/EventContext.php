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
use Behat\MinkExtension\Context\MinkContext;
use Documents\Event;

/**
 * Event Context.
 *
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
class EventContext extends MinkContext
{
    /**
     * @Given /^application has following events:$/
     *
     * @param TableNode $table
     */
    public function applicationHasFollowingEvents(TableNode $table)
    {
        //TODO: fill database with data
    }

    /**
     * @Given /^I do a request to event list page$/
     */
    public function iDoARequestToEventListPage()
    {
        $this->visitPath('/events');
    }

    /**
     * @Then /^I should see (\d+) event listed$/
     */
    public function iShouldSeeEventListed()
    {
        echo $this->getSession()->getPage()->getContent();
    }
}
