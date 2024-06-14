<?php

namespace App\Entity;

use App\Repository\UserAvatarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserAvatarRepository::class)]
#[Vich\Uploadable()]
class UserAvatar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $avatar = null;

    #[Vich\UploadableField(mapping: 'avatars', fileNameProperty: 'avatar')]
    #[Assert\Image]
    private ?File $avatarFile = null;

  public function getAvatarFile(): ?File
  {
    return $this->avatarFile;
  }

  public function setAvatarFile(?File $avatarFile): static
  {
    $this->avatarFile = $avatarFile;
    return $this;
  }

    #[ORM\OneToOne(inversedBy: 'userAvatar', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
