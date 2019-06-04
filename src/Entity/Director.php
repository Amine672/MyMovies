<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DirectorRepository")
 */
class Director
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
    private $name_director;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthdate_director;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movie", mappedBy="director", orphanRemoval=true)
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

    public function getNameDirector(): ?string
    {
        return $this->name_director;
    }

    public function setNameDirector(string $name_director): self
    {
        $this->name_director = $name_director;

        return $this;
    }

    public function getBirthdateDirector(): ?\DateTimeInterface
    {
        return $this->birthdate_director;
    }

    public function setBirthdateDirector(\DateTimeInterface $birthdate_director): self
    {
        $this->birthdate_director = $birthdate_director;

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
            $movie->setDirector($this);
        }

        return $this;
    }

    public function removeMovie(movie $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
            // set the owning side to null (unless already changed)
            if ($movie->getDirector() === $this) {
                $movie->setDirector(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->name_director;
    }

}
