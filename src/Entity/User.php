<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 * fields = {"email"},
 * message = "This email is already registrate",
 * )
 * @UniqueEntity(
 * fields = {"username"},
 * message = "This username is already registrate",
 * )
 */
class User Implements UserInterface
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
    private $username;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $userlastname;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\Length(min="8", minMessage="Your password must have 8 caractere min")
     */
    private $password;

    /**
     * 
     * @Assert\EqualTo(propertyPath="password", message="You didnt write the same password")
     */
    public $confirm_password;


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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        
        return $this;
    }

    public function getUserlastname(): ?string
    {
        return $this->username;
    }

    public function setUserlastname(string $userlastname): self
    {
        $this->userlastname = $userlastname;
        
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
    
    public function getRoles(){
        return ['ROLE_USER'];
    }
 
    public function getSalt(){
 
    }
 
    public function eraseCredentials(){
     
    }

}
