<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActorRepository")
 */
class Actor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name_actor;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthdate_actor;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Movie", inversedBy="actors")
     */
    private $movies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameActor(): ?string
    {
        return $this->name_actor;
    }

    public function setNameActor(string $name_actor): self
    {
        $this->name_actor = $name_actor;

        return $this;
    }

    public function getBirthdateActor(): ?\DateTimeInterface
    {
        return $this->birthdate_actor;
    }

    public function setBirthdateActor(\DateTimeInterface $birthdate_actor): self
    {
        $this->birthdate_actor = $birthdate_actor;

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
}
