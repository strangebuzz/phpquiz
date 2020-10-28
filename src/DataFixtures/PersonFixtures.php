<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PersonFixtures extends Fixture
{
    use AppFixturesTrait;

    public function load(ObjectManager $manager): void
    {
        foreach ($this->loadYaml(self::class)['persons'] as $person) {
            [$id, $twitter, $pseudo] = array_values($person);
            if (empty($twitter) && empty($pseudo)) {
                throw new \InvalidArgumentException('The Twitter or the pseudo should be filled.');
            }
            $person = (new Person())
                ->setTwitter($twitter)
                ->setPseudo($pseudo);

            $manager->persist($person);
            $this->addReference(self::class.$id, $person);
        }
        $manager->flush();
    }
}
