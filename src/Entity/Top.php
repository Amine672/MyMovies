<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TopRepository")
 */
class Top
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name_top;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Movie", inversedBy="tops")
     */
    private $movies;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tops")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RateTop", mappedBy="top")
     */
    private $rateTops;


    public function __construct()
    {
        $this->movies = new ArrayCollection();
        $this->rates = new ArrayCollection();
        $this->rateTops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameTop(): ?string
    {
        return $this->name_top;
    }

    public function setNameTop(string $name_top): self
    {
        $this->name_top = $name_top;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|movie[]
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(movie $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies[] = $movie;
        }

        return $this;
    }

    public function removeMovie(movie $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
        }

        return $this;
    }

    public function getUsers(): ?user
    {
        return $this->users;
    }

    public function setUsers(?user $users): self
    {
        $this->users = $users;

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
            $rateTop->setTop($this);
        }

        return $this;
    }

    public function removeRateTop(RateTop $rateTop): self
    {
        if ($this->rateTops->contains($rateTop)) {
            $this->rateTops->removeElement($rateTop);
            // set the owning side to null (unless already changed)
            if ($rateTop->getTop() === $this) {
                $rateTop->setTop(null);
            }
        }

        return $this;
    }

}
