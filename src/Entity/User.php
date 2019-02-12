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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RateMovie", mappedBy="user")
     */
    private $rateMovies;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RateTop", mappedBy="user")
     */
    private $rateTops;




    public function __construct()
    {
        $this->tops = new ArrayCollection();
        $this->rateMovies = new ArrayCollection();
        $this->rateTops = new ArrayCollection();
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

    public function getRate(): ?Rate
    {
        return $this->rate;
    }

    public function setRate(?Rate $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @return Collection|RateMovie[]
     */
    public function getRateMovies(): Collection
    {
        return $this->rateMovies;
    }

    public function addRateMovie(RateMovie $rateMovie): self
    {
        if (!$this->rateMovies->contains($rateMovie)) {
            $this->rateMovies[] = $rateMovie;
            $rateMovie->setUser($this);
        }

        return $this;
    }

    public function removeRateMovie(RateMovie $rateMovie): self
    {
        if ($this->rateMovies->contains($rateMovie)) {
            $this->rateMovies->removeElement($rateMovie);
            // set the owning side to null (unless already changed)
            if ($rateMovie->getUser() === $this) {
                $rateMovie->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RateTop[]
     */
    public function getRateTops(): Collection
    {
        return $this->rateTops;
    }

    public function addRateTop(RateTop $rateTop): self
    {
        if (!$this->rateTops->contains($rateTop)) {
            $this->rateTops[] = $rateTop;
            $rateTop->setUser($this);
        }

        return $this;
    }

    public function removeRateTop(RateTop $rateTop): self
    {
        if ($this->rateTops->contains($rateTop)) {
            $this->rateTops->removeElement($rateTop);
            // set the owning side to null (unless already changed)
            if ($rateTop->getUser() === $this) {
                $rateTop->setUser(null);
            }
        }

        return $this;
    }

}
