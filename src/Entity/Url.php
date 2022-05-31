<?php

namespace App\Entity;

use App\Repository\UrlRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UrlRepository::class)
 */
class Url
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max=255)
     */
    private $url_from;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     * @Assert\Length(max=20)
     */
    private $short_code;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expiration_date;

    /**
     * @ORM\OneToMany(targetEntity=UrlStatistics::class, mappedBy="url", orphanRemoval=true)
     */
    private $statistics;

    public function __construct()
    {
        $this->statistics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlFrom(): ?string
    {
        return $this->url_from;
    }

    public function setUrlFrom(string $url_from): self
    {
        $this->url_from = $url_from;

        return $this;
    }

    public function getShortCode(): ?string
    {
        return $this->short_code;
    }

    public function setShortCode(string $short_code): self
    {
        $this->short_code = $short_code;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(\DateTimeInterface $expiration_date): self
    {
        $this->expiration_date = $expiration_date;

        return $this;
    }

    /**
     * @return Collection<int, UrlStatistics>
     */
    public function getStatistics(): Collection
    {
        return $this->statistics;
    }

    public function addStatistic(UrlStatistics $statistic): self
    {
        if (!$this->statistics->contains($statistic)) {
            $this->statistics[] = $statistic;
            $statistic->setUrl($this);
        }

        return $this;
    }

    public function removeStatistic(UrlStatistics $statistic): self
    {
        if ($this->statistics->removeElement($statistic)) {
            // set the owning side to null (unless already changed)
            if ($statistic->getUrl() === $this) {
                $statistic->setUrl(null);
            }
        }

        return $this;
    }
}
