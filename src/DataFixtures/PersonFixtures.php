<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PersonFixtures extends Fixture
{
    private const DATA = [
        [
            /*'id'      =>*/ 1,
            /*'twitter' =>*/ 'FredBouchery',
            /*'pseudo'  =>*/ null,
        ],
        [
            /*'id'      =>*/ 2,
            /*'twitter' =>*/ 'C0il',
            /*'pseudo'  =>*/ null,
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
        foreach (self::DATA as [$id, $twitter, $pseudo]) {
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
