<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\Persistence\ObjectManager;

class PersonFixtures extends Fixture
{
    use AppFixturesTrait;

    /**
     * @var Connection
     */
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }


    public function load(ObjectManager $manager): void
    {
        $this->connection->exec('alter sequence person_id_seq restart');

        foreach ($this->loadYaml(self::class)['persons'] as $person) {
            [$id, $twitter, $pseudo] = array_values($person);
            if (empty($twitter) && empty($pseudo)) {
                throw new \InvalidArgumentException('The Twitter or the pseudo should be filled.');
            }
            $person = (new Person())
                ->setTwitter($twitter)
                ->setPseudo($pseudo);

            $manager->persist($person);
            $this->addReference(self::class.':'.$pseudo, $person);
        }
        $manager->flush();
    }
}
