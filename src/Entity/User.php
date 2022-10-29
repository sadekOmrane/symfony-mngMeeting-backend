<?php

namespace App\Entity;

use App\Entity\Department;
use App\Entity\Reservation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource()
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    private $plainPassword;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="employees")
     */
    private $department;



    /**
     * @ORM\OneToMany(targetEntity=Reclamation::class, mappedBy="proprietaire")
     */
    private $reclamations;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="responsable")
     */
    private $reunion;

    /**
     * @ORM\ManyToMany(targetEntity=Reservation::class, inversedBy="users")
     */
    private $reunions;

    /**
     * @ORM\ManyToMany(targetEntity=Notification::class, mappedBy="users")
     */
    private $notifications;

    /**
     * @ORM\OneToMany(targetEntity=ReadedNotification::class, mappedBy="user")
     */
    private $readedNotifications;

    public function __construct()
    {
        $this->reunions = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
        $this->reunion = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->readedNotifications = new ArrayCollection();
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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
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
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function __toString()
    {
        return $this->email;
    }


    /**
     * @return Collection<int, Reclamation>
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations[] = $reclamation;
            $reclamation->setProprietaire($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getProprietaire() === $this) {
                $reclamation->setProprietaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReunions(): Collection
    {
        return $this->reunions;
    }

    public function addReunion(Reservation $reunion): self
    {
        if (!$this->reunions->contains($reunion)) {
            $this->reunions[] = $reunion;
        }

        return $this;
    }

    public function removeReunion(Reservation $reunion): self
    {
        $this->reunions->removeElement($reunion);

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->addUser($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            $notification->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ReadedNotification>
     */
    public function getReadedNotifications(): Collection
    {
        return $this->readedNotifications;
    }

    public function addReadedNotification(ReadedNotification $readedNotification): self
    {
        if (!$this->readedNotifications->contains($readedNotification)) {
            $this->readedNotifications[] = $readedNotification;
            $readedNotification->setUser($this);
        }

        return $this;
    }

    public function removeReadedNotification(ReadedNotification $readedNotification): self
    {
        if ($this->readedNotifications->removeElement($readedNotification)) {
            // set the owning side to null (unless already changed)
            if ($readedNotification->getUser() === $this) {
                $readedNotification->setUser(null);
            }
        }

        return $this;
    }
}
