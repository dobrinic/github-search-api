<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SearchCacheRepository;
use Doctrine\DBAL\Types\Types;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SearchCacheRepository::class)]
#[ORM\Index(columns: ["term"], name: "term_idx")]
#[ORM\Index(columns: ["search_provider"], name: "search_provider_idx")]
#[ApiResource]
class SearchCache
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $term = null;

    #[ORM\Column(type: Types::FLOAT, precision: 4, scale: 2)]
    private ?float $score = null;

    #[ORM\Column(length: 50)]
    private ?string $searchProvider = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTerm(): ?string
    {
        return $this->term;
    }

    public function setTerm(string $term): static
    {
        $this->term = $term;

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getSearchProvider(): ?string
    {
        return $this->searchProvider;
    }

    public function setSearchProvider(string $searchProvider): static
    {
        $this->searchProvider = $searchProvider;

        return $this;
    }
}
