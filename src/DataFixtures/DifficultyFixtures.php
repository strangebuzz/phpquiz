<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Difficulty;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DifficultyFixtures extends Fixture
{
    private const DATA = [
        [
            /*'id'    =>*/ 1,
            /*'label' =>*/ 'basic',
        ],
        [
            /*'id'    =>*/ 2,
            /*'label' =>*/ 'medium',
        ],
        [
            /*'id'    =>*/ 3,
            /*'label' =>*/ 'expert',
        ]
    ];

    /**
     * The following annotation is to prevent PHPSorm from reporting a false positive.
     *
     * @noinspection PhpStrictTypeCheckingInspection
     * @noinspection PhpParamsInspection
     */
    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as [$id, $label]) {
            $difficulty = (new Difficulty())->setLabel($label);
            $manager->persist($difficulty);
            $this->addReference(self::class.$id, $difficulty);
        }
        $manager->flush();
    }
}
