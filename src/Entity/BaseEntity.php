<?php declare(strict_types=1);

namespace App\Entity;

class BaseEntity
{
    public const STRING_DEFAULT_LENGTH = 255;

    use TimestampableEntityTrait;
}
