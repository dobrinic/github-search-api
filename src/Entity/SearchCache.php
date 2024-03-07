<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\SearchCacheRepository;
use Doctrine\DBAL\Types\Types;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SearchCacheRepository::class)]
#[ORM\Index(columns: ["term"], name: "term_idx")]
#[ORM\Index(columns: ["search_provider"], name: "search_provider_idx")]
#[ApiResource(
    operations: [new Get()],
    normalizationContext: ['groups' => ['cache:read']],
)]
class SearchCache
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['cache:read'])]
    #[ORM\Column(length: 50)]
    private ?string $term = null;

    #[Groups(['cache:read'])]
    #[ORM\Column(type: Types::FLOAT, precision: 4, scale: 2)]
    private ?float $score = null;

    #[Groups(['cache:read'])]
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
