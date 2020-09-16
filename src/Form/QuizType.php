<?php declare(strict_types=1);

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
        $builder
            ->add('answer', ChoiceType::class, [
                'choices' => $this->getQuestion($options)->getAnswers(),
                'choice_value' => 'id',
                'choice_label' => 'labelWithCode',
                'expanded' => true, // radio
            ])
        ;
    }

    /**
     * @param array<string,mixed> $options
     */
    private function getQuestion(array $options): Question
    {
        $quizQuestion = $options['quiz_question'];
        if (!$quizQuestion instanceof QuizQuestion) {
            throw new \InvalidArgumentException('Invalid quiz question!');
        }

        $question = $quizQuestion->getQuestion();
        if (!$question instanceof Question) {
            throw new \InvalidArgumentException('Invalid question!');
        }

        return $question;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'quiz_question' => null // QuizQuestion entity
        ]);
    }
}
