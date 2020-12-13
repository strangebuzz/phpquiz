<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Hautelook\AliceBundle\FixtureLocatorInterface;
use Nelmio\Alice\IsAServiceTrait;

final class CustomOrderFilesLocator implements FixtureLocatorInterface
{
    use IsAServiceTrait;

    private FixtureLocatorInterface $decoratedFixtureLocator;

    public function __construct(FixtureLocatorInterface $decoratedFixtureLocator)
    {
        $this->decoratedFixtureLocator = $decoratedFixtureLocator;
    }

    /**
     * Reverse the quesiton files ordering so the natural order is preserved.
     * Question_001 will have id = 1 on so on. Otherwise the order is revesed.
     * (question 1 is the last question).
     *
     * {@inheritdoc}
     */
    public function locateFiles(array $bundles, string $environment): array
    {
        return array_reverse($this->decoratedFixtureLocator->locateFiles($bundles, $environment));
    }
}
