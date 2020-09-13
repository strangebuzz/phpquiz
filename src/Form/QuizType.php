<?php declare(strict_types=1);

namespace App\Form;

use App\Entity\QuizQuestion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $quizQuestions = $options['quiz_question'];
        if (!$quizQuestions instanceof QuizQuestion) {
            throw new \InvalidArgumentException('Invalid quiz!');
        }

        $answers = $quizQuestions->getQuestion()->getAnswers();
        $builder
            ->add('quiz_question_id', HiddenType::class)
            ->add('answer', ChoiceType::class, [
                'choices' => $answers,
                'choice_value' => 'id',
                'choice_label' => 'labelWithCode',
                'expanded' => true, // radio
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'quiz_question' => null // QuizQuestion entity
        ]);
    }
}
