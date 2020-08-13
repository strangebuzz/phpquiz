<?php declare(strict_types=1);

namespace App\Twig;

use App\Entity\Question;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Source helpers for code snippets.
 */
final class SourceExtension extends AbstractExtension
{
    private KernelInterface $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('source', [$this, 'getSource']),
        ];
    }

    /**
     * Get all content of a snippet.
     */
    public function getSource(Question $question): string
    {
        $filename = $this->kernel->getProjectDir().sprintf('/code/%d.php', $question->getId());
        if (!is_file($filename)) {
            throw new \InvalidArgumentException(sprintf('Question code not found, create the "/code/%d.php" file.', $question->getId()));
        }

        return (string) file_get_contents($filename);
    }
}
