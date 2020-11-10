<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Difficulty;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DifficultyFixtures extends Fixture
{
    use AppFixturesTrait;

    public function load(ObjectManager $manager): void
    {
        foreach ($this->loadYaml(self::class)['difficulties'] as $id => $difficulty) {
            $difficulty = (new Difficulty())->setLabel($difficulty['label']);
            $manager->persist($difficulty);
            $this->addReference(self::class.$id, $difficulty);
        }
        $manager->flush();
    }
}
