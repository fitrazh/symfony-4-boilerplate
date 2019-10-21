<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRewardRepository")
 */
class UserReward
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=35, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $rangeMin;

    /**
     * @ORM\Column(type="float")
     */
    private $rangeMax;

    /**
     * @ORM\Column(type="float")
     */
    private $reward;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $balanceRewards;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRangeMin(): ?float
    {
        return $this->rangeMin;
    }

    public function setRangeMin(float $rangeMin): self
    {
        $this->rangeMin = $rangeMin;

        return $this;
    }

    public function getRangeMax(): ?float
    {
        return $this->rangeMax;
    }

    public function setRangeMax(float $rangeMax): self
    {
        $this->rangeMax = $rangeMax;

        return $this;
    }

    public function getReward(): ?float
    {
        return $this->reward;
    }

    public function setReward(float $reward): self
    {
        $this->reward = $reward;

        return $this;
    }

    public function getBalanceRewards(): ?float
    {
        return $this->balanceRewards;
    }

    public function setBalanceRewards(?float $balanceRewards): self
    {
        $this->balanceRewards = $balanceRewards;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
