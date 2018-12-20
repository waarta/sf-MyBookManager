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
     * @ORM\Column(type="string", length=255)
     */
    private $nameUser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $passwordUser;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MarquePage", mappedBy="user", orphanRemoval=true)
     */
    private $marquePages;

    public function __construct()
    {
        $this->marquePages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameUser(): ?string
    {
        return $this->nameUser;
    }

    public function setNameUser(string $nameUser): self
    {
        $this->nameUser = $nameUser;

        return $this;
    }

    public function getPasswordUser(): ?string
    {
        return $this->passwordUser;
    }

    public function setPasswordUser(string $passwordUser): self
    {
        $this->passwordUser = $passwordUser;

        return $this;
    }

    /**
     * @return Collection|MarquePage[]
     */
    public function getMarquePages(): Collection
    {
        return $this->marquePages;
    }

    public function addMarquePage(MarquePage $marquePage): self
    {
        if (!$this->marquePages->contains($marquePage)) {
            $this->marquePages[] = $marquePage;
            $marquePage->setUser($this);
        }

        return $this;
    }

    public function removeMarquePage(MarquePage $marquePage): self
    {
        if ($this->marquePages->contains($marquePage)) {
            $this->marquePages->removeElement($marquePage);
            // set the owning side to null (unless already changed)
            if ($marquePage->getUser() === $this) {
                $marquePage->setUser(null);
            }
        }

        return $this;
    }
}
