<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Link;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LinkFixtures extends Fixture implements DependentFixtureInterface
{
    use AppFixturesTrait;

    private const DATA = [
        [
            /*'question_id' =>*/ 1,
            /*'label'       =>*/ 'Read the namespaces documentation on php.net',
            /*'url'         =>*/ 'https://www.php.net/manual/en/language.namespaces.definition.php',
        ],
        [
            /*'question_id' =>*/ 2,
            /*'label'       =>*/ 'Read the generators documentation on php.net',
            /*'url'         =>*/ 'https://www.php.net/manual/en/language.generators.syntax.php',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as [$questionId, $label, $url]) {
            $question = $this->getQuestion($questionId);
            $link = (new Link())
                ->setLabel($label)
                ->setQuestion($question)
                ->setUrl((string) $url);

            $manager->persist($link);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QuestionFixtures::class,
        ];
    }
}
