<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[Vich\Uploadable()]
class Product
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  private ?string $name = null;

  #[ORM\Column(length: 255)]
  private ?string $category = null;

  #[ORM\Column]
  #[Assert\PositiveOrZero]
  private ?int $stock = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $thumbnail = null;

  #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'thumbnail')]
  #[Assert\Image()]
  private ?File $thumbnailFile = null;

  #[ORM\Column(nullable: true)]
  private ?\DateTimeImmutable $updatedAt = null;

  public function getThumbnailFile(): ?File
  {
    return $this->thumbnailFile;
  }

  public function setThumbnailFile(?File $thumbnailFile): void
  {
    $this->thumbnailFile = $thumbnailFile;

    if ($thumbnailFile) {
      $this->updatedAt = new \DateTimeImmutable();
    }
  }

  public function getThumbnail(): ?string
  {
    return $this->thumbnail;
  }

  public function setThumbnail(?string $thumbnail): Product
  {
    $this->thumbnail = $thumbnail;
    return $this;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function setName(string $name): static
  {
    $this->name = $name;

    return $this;
  }

  public function setCategory(string $category): static
  {
    $this->category = $category;

    return $this;
  }

  public function getCategory(): ?string
  {
    return $this->category;
  }

  public function getStock(): ?int
  {
    return $this->stock;
  }

  public function setStock(int $stock): static
  {
    $this->stock = $stock;

    return $this;
  }

  public function getUpdatedAt(): ?\DateTimeImmutable
  {
      return $this->updatedAt;
  }

  public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
  {
      $this->updatedAt = $updatedAt;

      return $this;
  }
}
