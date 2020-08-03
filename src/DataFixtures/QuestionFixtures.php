<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    use AppFixturesTrait;

    private const DATA = [
        [
            /*'id'                       =>*/ 1,
            /*'person_id'                =>*/ 1,
            /*'label'                    =>*/ 'What will be displayed?',
            /*'codeImage'                =>*/ 'https://pbs.twimg.com/media/EdmGDDEXoAAcmsH?format=png&name=small',
            /*'answer_explanations'      =>*/ 'PHP namespaces can contain space characters, but they can\'t begin with a backslash. The right answer was "A".',
            /*'live_snippet_url'         =>*/ 'https://3v4l.org/pQOMe',
            /*'twitter_poll_url'         =>*/ 'https://twitter.com/FredBouchery/status/1286207302018699264',
            /*'differences_output_notes' =>*/ 'As I am writing this quiz (2020-07-31), there is a slight difference between all versions and PHP 8.0.0alpha3:<br/>With this last version, the exception message "Foo\Bar" is wrapped by double quotes instead of single quotes for other versions (\'Foo\Bar\'). 🤔',
            /*'created_at'               =>*/ '2020-07-23',
            /*'updated_at'               =>*/ '2020-07-23',
        ],
        [
            /*'id'                       =>*/ 2,
            /*'person_id'                =>*/ 1,
            /*'label'                    =>*/ 'What will be displayed (PHP version >= 7.4)?',
            /*'codeImage'                =>*/ 'https://pbs.twimg.com/media/EdW2xTnXYAIDjBP?format=png&name=medium',
            /*'answer_explanations'      =>*/ '7.4 unpack a Traversable by keeping the iteration order, but it fails when the keys are strings, even if those strings are numeric. The right answer was "D"',
            /*'live_snippet_url'         =>*/ 'https://3v4l.org/qKGPt',
            /*'twitter_poll_url'         =>*/ 'https://twitter.com/FredBouchery/status/1285134865176956929',
            /*'differences_output_notes' =>*/ '',
            /*'created_at'               =>*/ '2020-07-20',
            /*'updated_at'               =>*/ '2020-07-20',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as [$id, $personId, $label, $codeImage, $answerExplanations, $liveSnippetUrl,
            $twitterPollUrl, $differencesOutputNotes, $createdAt, $updatedAt]) {
            $createdAtDateTime = date_create($createdAt);
            $updatedAtDateTime = date_create($updatedAt);
            if (!$createdAtDateTime instanceof \DateTimeInterface || !$updatedAtDateTime instanceof \DateTimeInterface) {
                throw new \InvalidArgumentException(sprintf('Invalide create (%s) or update date (%s).', $createdAt, $updatedAt));
            }

            $person = $this->getPerson($personId);
            $question = (new Question())
                ->setSuggestedBy($person)
                ->setLabel($label)
                ->setCodeImage($codeImage)
                ->setAnswerExplanations($answerExplanations)
                ->setLiveSnippetUrl($liveSnippetUrl)
                ->setTwitterPollUrl($twitterPollUrl)
                ->setDifferencesOutputNotes($differencesOutputNotes)
                ->setCreatedAt($createdAtDateTime)
                ->setUpdatedAt($updatedAtDateTime);

            $manager->persist($question);
            $this->addReference(self::class.$id, $question);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PersonFixtures::class,
        ];
    }
}
