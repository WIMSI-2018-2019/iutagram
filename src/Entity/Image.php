<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity()
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 */
class Image
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="images")
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $path;

    /**
     * @ORM\Column(type="text", nullable=false)
     *
     * @var string
     */
    private $text;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="subject")
     *
     * @var Collection<Comment>
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="ImageLike", mappedBy="subject")
     *
     * @var Collection<Comment>
     */
    private $likes;

    public function __construct()
    {
        $this->comments = new ArrayCollection;
        $this->likes = new ArrayCollection;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return Collection<Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @return Collection<ImageLike>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }
}
