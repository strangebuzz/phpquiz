<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    use AppFixturesTrait;

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }


    public function load(ObjectManager $manager): void
    {
        $questions = $this->loadYaml(self::class)['questions'];

        $this->connection->exec('alter sequence question_id_seq restart');

        foreach ($questions as $id => $data) {
            $createdAt = new \DateTime($data['created_at']);
            if (isset($data['updated_at'])) {
                $updatedAt = new \DateTime($data['updated_at']);
            } else {
                $updatedAt = clone $createdAt;
            }

            $question = (new Question())
                ->setId($id)
                ->setSuggestedBy($this->getPerson(PersonFixtures::class.':'.$data['person']))
                ->setDifficulty($data['difficulty'])
                ->setLabel($data['label'])
                ->setDescription($data['description'])
                ->setAnswerExplanations($data['answer_explanations'])
                ->setSourceUrl($data['sourceUrl'])
                ->setCreatedAt($createdAt)
                ->setUpdatedAt($updatedAt)
            ;

            $manager->persist($question);

            foreach ($data['answers'] as $order => $answerData) {
                $answer = (new Answer())
                    ->setOrder($order)
                    ->setLabel($answerData['label'])
                    ->setQuestion($question)
                    ->setScore($answerData['score'])
                ;
                $manager->persist($answer);
            }

            $this->setReference(self::class.':'.$id, $question);
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
