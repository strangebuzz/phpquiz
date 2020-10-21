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
        [
            /*'question_id' =>*/ 6,
            /*'label'       =>*/ 'Read the ::class documentation on php.net',
            /*'url'         =>*/ 'https://www.php.net/manual/en/language.oop5.basic.php#language.oop5.basic.class.class',
        ],
        [
            /*'question_id' =>*/ 7,
            /*'label'       =>*/ 'Read the Trait documentation on php.net',
            /*'url'         =>*/ 'https://www.php.net/manual/en/language.oop5.traits.php',
        ],
        [
            /*'question_id' =>*/ 8,
            /*'label'       =>*/ 'Read the Class Abstraction documentation on php.net',
            /*'url'         =>*/ 'https://www.php.net/manual/en/language.oop5.abstract.php',
        ],
        [
            /*'question_id' =>*/ 9,
            /*'label'       =>*/ 'Read the "Saner numeric strings" RFC.',
            /*'url'         =>*/ 'https://wiki.php.net/rfc/saner-numeric-strings',
        ],
        [
            /*'question_id' =>*/ 10,
            /*'label'       =>*/ 'Read the magic methods documentation on php.net',
            /*'url'         =>*/ 'https://www.php.net/manual/en/language.oop5.magic.php',
        ],
        [
            /*'question_id' =>*/ 11,
            /*'label'       =>*/ 'Read the "invoke" documentation on php.net',
            /*'url'         =>*/ 'https://www.php.net/manual/en/language.oop5.magic.php#object.invoke',
        ],
        [
            /*'question_id' =>*/ 12,
            /*'label'       =>*/ 'Read the "__set" documentation on php.net',
            /*'url'         =>*/ 'https://www.php.net/manual/en/language.oop5.overloading.php#object.set',
        ],
        [
            /*'question_id' =>*/ 13,
            /*'label'       =>*/ 'Read the "::class" documentation on php.net',
            /*'url'         =>*/ 'https://www.php.net/manual/en/language.oop5.basic.php#language.oop5.basic.class.class',
        ],
        [
            /*'question_id' =>*/ 14,
            /*'label'       =>*/ 'Read the "Variable variables" documentation on php.net',
            /*'url'         =>*/ 'https://www.php.net/manual/en/language.types.string.php#language.types.string.parsing',
        ],
        [
            /*'question_id' =>*/ 15,
            /*'label'       =>*/ 'Read the closure documentation on php.net',
            /*'url'         =>*/ 'https://www.php.net/manual/en/class.closure.php',
        ],
        [
            /*'question_id' =>*/ 16,
            /*'label'       =>*/ 'Read the alternative syntax for control structures documentation on php.net',
            /*'url'         =>*/ 'https://www.php.net/manual/en/control-structures.alternative-syntax.php',
        ],
        [
            /*'question_id' =>*/ 17,
            /*'label'       =>*/ 'Read the nullable types PHP 7.1 new feature on php.net',
            /*'url'         =>*/ 'https://php.net/manual/en/migration71.new-features.php#migration71.new-features.nullable-types',
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
