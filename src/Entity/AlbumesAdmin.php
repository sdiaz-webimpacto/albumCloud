<?php

namespace App\Entity;

use App\Repository\AlbumesAdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumesAdminRepository::class)]
class AlbumesAdmin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: Albumes::class)]
    private $album_id;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'albumesAdmins')]
    private $id_user;

    public function __construct()
    {
        $this->album_id = new ArrayCollection();
        $this->id_user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Albumes>
     */
    public function getAlbumId(): Collection
    {
        return $this->album_id;
    }

    public function addAlbumId(Albumes $albumId): self
    {
        if (!$this->album_id->contains($albumId)) {
            $this->album_id[] = $albumId;
        }

        return $this;
    }

    public function removeAlbumId(Albumes $albumId): self
    {
        $this->album_id->removeElement($albumId);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getIdUser(): Collection
    {
        return $this->id_user;
    }

    public function addIdUser(User $idUser): self
    {
        if (!$this->id_user->contains($idUser)) {
            $this->id_user[] = $idUser;
        }

        return $this;
    }

    public function removeIdUser(User $idUser): self
    {
        $this->id_user->removeElement($idUser);

        return $this;
    }
}
