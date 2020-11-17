<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Project specific Timestampable behavior trait.
 *
 * @see https://github.com/l3pp4rd/DoctrineExtensions/blob/master/doc/timestampable.md#traits
 * @see TimestampableEntity
 */
trait TimestampableEntityTrait
{
    /**
     * @Gedmo\Timestampable(on="create")
     *
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected ?\DateTime $createdAt = null;

    /**
     * @Gedmo\Timestampable(on="update")
     *
     * @ORM\Column(type="datetime", name="updated_at")
     */
    protected ?\DateTime $updatedAt = null;

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
}
