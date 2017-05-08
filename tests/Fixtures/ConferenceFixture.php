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

namespace ConticketTest\Fixtures;

use Conticket\Conference\Domain\ConferenceId;
use Doctrine\DBAL\Connection;

final class ConferenceFixture
{
    public function load(Connection $connection): void
    {
        // @todo use other fixture to create/drop table
        $connection->query('DROP TABLE IF EXISTS conferences');
        $connection->query('CREATE TABLE conferences (
          id VARCHAR(36) NOT NULL UNIQUE,
          name VARCHAR(255) NOT NULL
        )');

        $connection->query('DELETE FROM conferences');
        $connection->query('INSERT INTO conferences(id, name) VALUES ("'.(string) ConferenceId::new().'", "PHPeste")');
    }
}
