<?php declare(strict_types=1);

namespace App\Form;

use App\Data\QuizData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class QuizRestoreType extends AbstractType
{
    private QuizData $quizData;

    public function __construct(QuizData $quizData)
    {
        $this->quizData = $quizData;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('uuid', TextType::class, [
            'constraints' => [
                new NotBlank(),
                new Uuid(),
                new Callback([$this, 'checkQuiz']),
            ]
        ]);
    }

    /**
     * Check that the uuid is found in the database.
     */
    public function checkQuiz(?string $uuid, ExecutionContextInterface $context): void
    {
        // duplicate with uuid constraint, try to order the constraints with
        // https://symfony.com/doc/current/reference/constraints/Sequentially.html
        if (!uuid_is_valid($uuid)) {
            return;
        }

        try {
            $this->quizData->getQuiz((string) $uuid);
        } catch (\Exception $e) {
            $context->getRoot()->addError(new FormError('Quiz not found!'));
        }
    }
}
