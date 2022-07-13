<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface//, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $user_name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $user_lastname;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $avatar;

    #[ORM\Column(type: 'datetime_immutable')]
    private $date_add;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $date_update;

    #[ORM\Column(type: 'string', length: 255)]
    private $token;

    #[ORM\ManyToMany(targetEntity: Albumes::class, mappedBy: 'album_users')]
    private $albumes;

    #[ORM\ManyToMany(targetEntity: AlbumesAdmin::class, mappedBy: 'id_user')]
    private $albumesAdmins;

    #[ORM\OneToMany(mappedBy: 'photo_owner', targetEntity: Photos::class)]
    private $photos;

    public function __construct()
    {
        $this->albumes = new ArrayCollection();
        $this->albumesAdmins = new ArrayCollection();
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(?string $user_name): self
    {
        $this->user_name = $user_name;

        return $this;
    }

    public function getUserLastname(): ?string
    {
        return $this->user_lastname;
    }

    public function setUserLastname(?string $user_lastname): self
    {
        $this->user_lastname = $user_lastname;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

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

    public function getDateUpdate(): ?\DateTimeImmutable
    {
        return $this->date_update;
    }

    public function setDateUpdate(?\DateTimeImmutable $date_update): self
    {
        $this->date_update = $date_update;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return Collection<int, Albumes>
     */
    public function getAlbumes(): Collection
    {
        return $this->albumes;
    }

    public function addAlbume(Albumes $albume): self
    {
        if (!$this->albumes->contains($albume)) {
            $this->albumes[] = $albume;
            $albume->addAlbumUser($this);
        }

        return $this;
    }

    public function removeAlbume(Albumes $albume): self
    {
        if ($this->albumes->removeElement($albume)) {
            $albume->removeAlbumUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, AlbumesAdmin>
     */
    public function getAlbumesAdmins(): Collection
    {
        return $this->albumesAdmins;
    }

    public function addAlbumesAdmin(AlbumesAdmin $albumesAdmin): self
    {
        if (!$this->albumesAdmins->contains($albumesAdmin)) {
            $this->albumesAdmins[] = $albumesAdmin;
            $albumesAdmin->addIdUser($this);
        }

        return $this;
    }

    public function removeAlbumesAdmin(AlbumesAdmin $albumesAdmin): self
    {
        if ($this->albumesAdmins->removeElement($albumesAdmin)) {
            $albumesAdmin->removeIdUser($this);
        }

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
            $photo->setPhotoOwner($this);
        }

        return $this;
    }

    public function removePhoto(Photos $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getPhotoOwner() === $this) {
                $photo->setPhotoOwner(null);
            }
        }

        return $this;
    }
}
