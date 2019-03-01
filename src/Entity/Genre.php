<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GenreRepository")
 */
class Genre
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
    private $name_genre;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Movie", inversedBy="genres")
     */
    private $movie;

    public function __construct()
    {
        $this->movie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameGenre(): ?string
    {
        return $this->name_genre;
    }

    public function setNameGenre(string $name_genre): self
    {
        $this->name_genre = $name_genre;

        return $this;
    }

    /**
     * @return Collection|movie[]
     */
    public function getMovie(): Collection
    {
        return $this->movie;
    }

    public function addMovie(movie $movie): self
    {
        if (!$this->movie->contains($movie)) {
            $this->movie[] = $movie;
        }

        return $this;
    }

    public function removeMovie(movie $movie): self
    {
        if ($this->movie->contains($movie)) {
            $this->movie->removeElement($movie);
        }

        return $this;
    }
}
