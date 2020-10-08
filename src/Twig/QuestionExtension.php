<?php declare(strict_types=1);

namespace App\Twig;

use App\Entity\Question;
use Symfony\Bridge\Twig\Extension\AssetExtension;
use Symfony\Bridge\Twig\Extension\HttpFoundationExtension;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Questions assets helpers.
 */
class QuestionExtension extends AbstractExtension
{
    private HttpFoundationExtension $httpFoundationExtension;
    private AssetExtension $assetExtension;

    public function __construct(HttpFoundationExtension $httpFoundationExtension, AssetExtension $assetExtension)
    {
        $this->httpFoundationExtension = $httpFoundationExtension;
        $this->assetExtension = $assetExtension;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('question_image', [$this, 'questionImage']),
        ];
    }

    public function questionImage(Question $question): string
    {
        return $this->httpFoundationExtension->generateAbsoluteUrl(
            $this->assetExtension->getAssetUrl('img/questions/'.$question->getCodeImageFile())
        );
    }
}
