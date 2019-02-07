<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name_user;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $lastname_user;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Top", mappedBy="users", orphanRemoval=true)
     */
    private $tops;

    public function __construct()
    {
        $this->tops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameUser(): ?string
    {
        return $this->name_user;
    }

    public function setNameUser(string $name_user): self
    {
        $this->name_user = $name_user;

        return $this;
    }

    public function getLastnameUser(): ?string
    {
        return $this->lastname_user;
    }

    public function setLastnameUser(string $lastname_user): self
    {
        $this->lastname_user = $lastname_user;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|Top[]
     */
    public function getTops(): Collection
    {
        return $this->tops;
    }

    public function addTop(Top $top): self
    {
        if (!$this->tops->contains($top)) {
            $this->tops[] = $top;
            $top->setUsers($this);
        }

        return $this;
    }

    public function removeTop(Top $top): self
    {
        if ($this->tops->contains($top)) {
            $this->tops->removeElement($top);
            // set the owning side to null (unless already changed)
            if ($top->getUsers() === $this) {
                $top->setUsers(null);
            }
        }

        return $this;
    }
}
