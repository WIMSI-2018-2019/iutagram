<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={},
 *     itemOperations={
 *          "get"={"normalization_context"={"groups"={"get_comment", "timestamps"}}}
 *     },
 * )
 * @ORM\Entity()
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 */
class Comment
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
     * @Groups({"get_comment", "get_image"})
     * @ORM\ManyToOne(targetEntity="User")
     *
     * @var User
     */
    private $author;

    /**
     * @Groups({"get_comment"})
     * @ORM\ManyToOne(targetEntity="Image", inversedBy="comments")
     *
     * @var Image
     */
    private $subject;

    /**
     * @Groups({"get_comment", "get_image"})
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $text;

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

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }
}
