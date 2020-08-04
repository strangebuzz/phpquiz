<?php declare(strict_types=1);

namespace App\Twig;

use Symfony\Component\Serializer\SerializerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ApiExtension extends AbstractExtension
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * If your filter generates SAFE HTML, you should add a third parameter:
     * ['is_safe' => ['html']]
     *
     * @see https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('serialize', [$this, 'serialize']),
        ];
    }

    /**
     * @param mixed $value
     */
    public function serialize($value, string $group = null): string
    {
        $context = $group !== null ? ['groups' => $group] : null;

        return $this->serializer->serialize($value, 'json', $context);
    }
}
