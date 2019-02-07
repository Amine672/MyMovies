<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 */
class Movie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Actor", mappedBy="movies")
     */
    private $actors;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Genre", mappedBy="movie")
     */
    private $genres;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Top", mappedBy="movies")
     */
    private $tops;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Director", inversedBy="movies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $director;

    public function __construct()
    {
        $this->actors = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->tops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

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
     * @return Collection|Actor[]
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(Actor $actor): self
    {
        if (!$this->actors->contains($actor)) {
            $this->actors[] = $actor;
            $actor->addMovie($this);
        }

        return $this;
    }

    public function removeActor(Actor $actor): self
    {
        if ($this->actors->contains($actor)) {
            $this->actors->removeElement($actor);
            $actor->removeMovie($this);
        }

        return $this;
    }

    /**
     * @return Collection|Genre[]
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
            $genre->addMovie($this);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        if ($this->genres->contains($genre)) {
            $this->genres->removeElement($genre);
            $genre->removeMovie($this);
        }

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
            $top->addMovie($this);
        }

        return $this;
    }

    public function removeTop(Top $top): self
    {
        if ($this->tops->contains($top)) {
            $this->tops->removeElement($top);
            $top->removeMovie($this);
        }

        return $this;
    }

    public function getDirector(): ?Director
    {
        return $this->director;
    }

    public function setDirector(?Director $director): self
    {
        $this->director = $director;

        return $this;
    }
}
