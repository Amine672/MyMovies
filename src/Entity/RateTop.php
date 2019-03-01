<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RateTopRepository")
 */
class RateTop
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $rate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="rateTops")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Top", inversedBy="rateTops")
     */
    private $top;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTop(): ?top
    {
        return $this->top;
    }

    public function setTop(?top $top): self
    {
        $this->top = $top;

        return $this;
    }
}
