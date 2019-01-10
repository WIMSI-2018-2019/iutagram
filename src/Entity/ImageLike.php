<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity()
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 */
class ImageLike
{
    use HasTimestamp;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     *
     * @var User
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="Image", inversedBy="likes")
     *
     * @var Image
     */
    private $subject;

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    public function getSubject(): Image
    {
        return $this->subject;
    }

    public function setSubject(Image $subject): void
    {
        $this->subject = $subject;
    }
}
