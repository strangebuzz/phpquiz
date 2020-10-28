<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Difficulty;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class DifficultyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = Yaml::parseFile(__DIR__.'/DifficultyFixtures.yaml');
        foreach ($data['difficulties'] as $id => $difficulty) {
            $difficulty = (new Difficulty())->setLabel($difficulty['label']);
            $manager->persist($difficulty);
            $this->addReference(self::class.$id, $difficulty);
        }
        $manager->flush();
    }
}
