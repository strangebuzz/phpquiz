<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    use AppFixturesTrait;

    public const COUNT = 18;

    public function load(ObjectManager $manager): void
    {
        $questions = $this->loadYaml(self::class)['questions'];
        foreach ($questions as $question) {
            [/*previous_question*/, $id, /*next_question*/, $personId, $difficultyId, $label, $reminder, $codeImage, $codeImageFile, $answerExplanations,
                $liveSnippetUrl, $twitterPollUrl, $differencesOutputNotes, $createdAt, $updatedAt] = array_values($question);
            $createdAtDateTime = date_create($createdAt);
            $updatedAtDateTime = date_create($updatedAt);
            if (!$createdAtDateTime instanceof \DateTimeInterface || !$updatedAtDateTime instanceof \DateTimeInterface) {
                throw new \InvalidArgumentException(sprintf('Invalide create (%s) or update date (%s).', $createdAt, $updatedAt));
            }

            $question = (new Question())
                ->setSuggestedBy($this->getPerson($personId))
                ->setDifficulty($this->getDifficulty($difficultyId))
                ->setLabel($label)
                ->setReminder($reminder)
                ->setCodeImage($codeImage)
                ->setCodeImageFile($codeImageFile)
                ->setAnswerExplanations($answerExplanations)
                ->setLiveSnippetUrl($liveSnippetUrl)
                ->setTwitterPollUrl($twitterPollUrl)
                ->setDifferencesOutputNotes($differencesOutputNotes)
                ->setCreatedAt($createdAtDateTime)
                ->setUpdatedAt($updatedAtDateTime);

            $manager->persist($question);
            $this->addReference(self::class.$id, $question);
        }

        // prev and next questions
        foreach ($questions as $question) {
            [$previousQuestionId, $id, $nextQuestionId] = array_values($question);
            $previousQuestion = is_int($previousQuestionId) ? $this->getQuestion($previousQuestionId) : null;
            $nextQuestion = is_int($nextQuestionId) ? $this->getQuestion($nextQuestionId) : null;
            $this->getQuestion($id)
                ->setPreviousQuestion($previousQuestion)
                ->setNextQuestion($nextQuestion);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PersonFixtures::class,
            DifficultyFixtures::class,
        ];
    }
}
