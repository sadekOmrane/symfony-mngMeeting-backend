<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NotificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=NotificationRepository::class)
 */
class Notification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createAt;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="notifications")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=ReadedNotification::class, mappedBy="notification")
     */
    private $readedNotifications;

    /**
     * @ORM\ManyToOne(targetEntity=Reservation::class, inversedBy="notifications")
     */
    private $reunion;






    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->readedNotifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

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
            $readedNotification->setNotification($this);
        }

        return $this;
    }

    public function removeReadedNotification(ReadedNotification $readedNotification): self
    {
        if ($this->readedNotifications->removeElement($readedNotification)) {
            // set the owning side to null (unless already changed)
            if ($readedNotification->getNotification() === $this) {
                $readedNotification->setNotification(null);
            }
        }

        return $this;
    }

    public function getReunion(): ?Reservation
    {
        return $this->reunion;
    }

    public function setReunion(?Reservation $reunion): self
    {
        $this->reunion = $reunion;

        return $this;
    }
}
