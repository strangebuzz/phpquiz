<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @covers Person
 */
final class PersonTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = static::getContainer()->get('validator');
    }

    /**
     * @covers Person::validate
     */
    public function testValidate(): void
    {
        $person = new Person();
        $person->setTwitter('twitter');
        $person->setPseudo('pseudo');
        $violations = $this->validator->validate($person);
        self::assertCount(1, $violations);
        foreach ($violations as $violation) {
            if ($violation instanceof ConstraintViolation) {
                self::assertContains('Twitter or the pseudo', $violation->getMessage());
            }
        }
    }
}
