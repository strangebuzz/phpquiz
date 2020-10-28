<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Link;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LinkFixtures extends Fixture implements DependentFixtureInterface
{
    use AppFixturesTrait;

    public function load(ObjectManager $manager): void
    {
        foreach ($this->loadYaml(self::class)['links'] as $link) {
            [$questionId, $label, $url] = array_values($link);
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
