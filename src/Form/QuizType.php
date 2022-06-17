<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Question;
use App\Entity\QuizQuestion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var QuizQuestion $quizQuestion */
        $quizQuestion = $options['quiz_question'];
        $builder
            ->add('answer', ChoiceType::class, [
                'choices' => $this->getQuestion($quizQuestion)->getAnswers(),
                'choice_value' => 'id',
                'choice_label' => 'labelWithCode',
                'expanded' => true, // radio
            ]);
    }

    private function getQuestion(QuizQuestion $quizQuestion): Question
    {
        $question = $quizQuestion->getQuestion();
        if (!$question instanceof Question) {
            throw new \InvalidArgumentException('Invalid question!');
        }

        return $question;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'quiz_question' => null, // QuizQuestion entity
        ]);
    }
}
