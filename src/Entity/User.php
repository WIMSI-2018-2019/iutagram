<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     accessControl="is_granted('ROLE_USER')",
 *     collectionOperations={
 *          "api_users_follows_get_subresource"={"normalization_context"={"groups"={"get_user_follows", "timestamps"}}}
 *     },
 *     itemOperations={
 *          "get"={"normalization_context"={"groups"={"get_user", "timestamps"}}}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
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
     * @Groups({"get_user", "get_comment", "get_images", "get_image", "get_user_follows"})
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @Groups({"get_user", "get_user_follows"})
     * @ORM\OrderBy({"createdAt"="DESC"})
     * @ORM\OneToMany(targetEntity="Image", mappedBy="user")
     *
     * @var Collection<Image>
     */
    private $images;

    /**
     * @ApiSubresource
     * @ORM\ManyToMany(targetEntity="User", inversedBy="followers", cascade={"persist"})
     * @ORM\JoinTable(
     *     joinColumns={@ORM\JoinColumn(name="follower_id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="follow_id")}
     * )
     *
     * @var Collection<User>
     */
    private $follows;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="follows")
     *
     * @var Collection<User>
     */
    private $followers;

    /**
     * @ORM\Column(type="json")
     *
     * @var array
     */
    private $roles = [];

    public function __construct()
    {
        $this->images    = new ArrayCollection;
        $this->followers = new ArrayCollection();
        $this->follows   = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getRoles(): array
    {
        $roles   = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @return Collection<User>
     */
    public function getFollows(): Collection
    {
        return $this->follows;
    }

    public function setFollows(array $follows): void
    {
        $this->follows = new ArrayCollection($follows);
    }

    /**
     * @return Collection<User>
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }


    public function setFollowers(array $followers): void
    {
        $this->followers = new ArrayCollection($followers);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return Collection<Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function getSalt()
    {
        // Argon2i includes salt in hash
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function __toString()
    {
        return $this->getEmail();
    }
}
