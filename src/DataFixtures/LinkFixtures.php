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
        [
            /*'question_id' =>*/ 3,
            /*'label'       =>*/ 'Read the property_exists function documentation on php.net',
            /*'url'         =>*/ 'https://www.php.net/manual/en/function.property-exists.php',
        ],
        [
            /*'question_id' =>*/ 4,
            /*'label'       =>*/ 'Read the array functions documentation on php.net',
            /*'url'         =>*/ 'https://www.php.net/manual/en/ref.array.php',
        ],
        [
            /*'question_id' =>*/ 5,
            /*'label'       =>*/ 'Read the array_merge function documentation on php.net',
            /*'url'         =>*/ 'https://www.php.net/manual/en/function.array-merge.php',
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
