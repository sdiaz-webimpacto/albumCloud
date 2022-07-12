<?php

namespace App\Entity;

use App\Repository\AlbumesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumesRepository::class)]
class Albumes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $album_name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $album_banner;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'albumes')]
    private $album_users;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $title;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $icon;

    #[ORM\Column(type: 'datetime_immutable')]
    private $date_add;

    #[ORM\OneToMany(mappedBy: 'photo_album', targetEntity: Photos::class)]
    private $photos;

    public function __construct()
    {
        $this->album_users = new ArrayCollection();
        $this->phptp_path = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlbumName(): ?string
    {
        return $this->album_name;
    }

    public function setAlbumName(string $album_name): self
    {
        $this->album_name = $album_name;

        return $this;
    }

    public function getAlbumBanner(): ?string
    {
        return $this->album_banner;
    }

    public function setAlbumBanner(?string $album_banner): self
    {
        $this->album_banner = $album_banner;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getAlbumUsers(): Collection
    {
        return $this->album_users;
    }

    public function addAlbumUser(User $albumUser): self
    {
        if (!$this->album_users->contains($albumUser)) {
            $this->album_users[] = $albumUser;
        }

        return $this;
    }

    public function removeAlbumUser(User $albumUser): self
    {
        $this->album_users->removeElement($albumUser);

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

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

    /**
     * @return Collection<int, Photos>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photos $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setPhotoAlbum($this);
        }

        return $this;
    }

    public function removePhoto(Photos $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getPhotoAlbum() === $this) {
                $photo->setPhotoAlbum(null);
            }
        }

        return $this;
    }
}
