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
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=50)
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
     * @ORM\OneToMany(targetEntity="App\Entity\RateMovie", mappedBy="movie")
     */
    private $rateMovies;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Director", inversedBy="movies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $director;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $overview;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img;



    public function __construct()
    {
        $this->actors = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->tops = new ArrayCollection();
        $this->rateMovies = new ArrayCollection();
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

    public function getCreatedAt(): ?string
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
            $rateMovie->setMovie($this);
        }

        return $this;
    }

    public function removeRateMovie(RateMovie $rateMovie): self
    {
        if ($this->rateMovies->contains($rateMovie)) {
            $this->rateMovies->removeElement($rateMovie);
            // set the owning side to null (unless already changed)
            if ($rateMovie->getMovie() === $this) {
                $rateMovie->setMovie(null);
            }
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

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): self
    {
        $this->overview = $overview;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }

}
