<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DistrictRepository")
 */
class District
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $miasto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $dzielnica;

    /**
     * @ORM\Column(type="integer")
     */
    public $ludnosc;

    /**
     * @ORM\Column(type="float")
     */
    public $powierzchnia;

    public function getId()
    {
        return $this->id;
    }

    public function getMiasto(): ?string
    {
        return $this->miasto;
    }

    public function setMiasto(string $miasto): self
    {
        $this->miasto = $miasto;

        return $this;
    }

    public function getDzielnica(): ?string
    {
        return $this->dzielnica;
    }

    public function setDzielnica(string $dzielnica): self
    {
        $this->dzielnica = $dzielnica;

        return $this;
    }

    public function getLudnosc(): ?int
    {
        return $this->ludnosc;
    }

    public function setLudnosc(int $ludnosc): self
    {
        $this->ludnosc = $ludnosc;

        return $this;
    }

    public function getPowierzchnia(): ?float
    {
        return $this->powierzchnia;
    }

    public function setPowierzchnia(float $powierzchnia): self
    {
        $this->powierzchnia = $powierzchnia;

        return $this;
    }
}
