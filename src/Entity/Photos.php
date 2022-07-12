<?php

namespace App\Entity;

use App\Repository\PhotosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotosRepository::class)]
class Photos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $name;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'photos')]
    #[ORM\JoinColumn(nullable: false)]
    private $photo_owner;

    #[ORM\ManyToOne(targetEntity: Albumes::class, inversedBy: 'phptp_path')]
    #[ORM\JoinColumn(nullable: false)]
    private $photo_album;

    #[ORM\Column(type: 'string', length: 255)]
    private $photo_path;

    #[ORM\Column(type: 'datetime_immutable')]
    private $date_add;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhotoOwner(): ?User
    {
        return $this->photo_owner;
    }

    public function setPhotoOwner(?User $photo_owner): self
    {
        $this->photo_owner = $photo_owner;

        return $this;
    }

    public function getPhotoAlbum(): ?Albumes
    {
        return $this->photo_album;
    }

    public function setPhotoAlbum(?Albumes $photo_album): self
    {
        $this->photo_album = $photo_album;

        return $this;
    }

    public function getPhotoPath(): ?string
    {
        return $this->photo_path;
    }

    public function setPhotoPath(string $photo_path): self
    {
        $this->photo_path = $photo_path;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeImmutable
    {
        return $this->date_add;
    }

    public function setDateAdd(\DateTimeImmutable $date_add): self
    {
        $this->date_add = $date_add;

        return $this;
    }
}
