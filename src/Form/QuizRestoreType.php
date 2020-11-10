<?php

declare(strict_types=1);

namespace App\Form;

use App\Data\QuizData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
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
                new Sequentially([
                    new NotBlank(),
                    new Uuid(),
                    new Callback([$this, 'checkQuiz']),
                ]),
            ],
        ]);
    }

    /**
     * Check that the uuid is found in the database. This constraint must be called
     * only if the uuid validity has been checked before.
     *
     * @see buildForm
     */
    public function checkQuiz(string $uuid, ExecutionContextInterface $context): void
    {
        try {
            $this->quizData->getQuiz($uuid);
        } catch (NotFoundHttpException $e) {
            $uuidField = $context->getObject();
            if (!$uuidField instanceof Form) {
                throw new \RuntimeException('Invalid form field.');
            }

            $uuidField->addError(new FormError('Quiz not found!'));
        }
    }
}
