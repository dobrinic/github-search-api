<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Controller\api\Search\v2\SearchController;
use App\Controller\api\Search\v2\SearchController as SearchControllerV2;
use App\Repository\SearchCacheRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SearchCacheRepository::class)]
#[ORM\Index(columns: ["term"], name: "term_idx")]
#[ORM\Index(columns: ["search_provider"], name: "search_provider_idx")]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/v1/{searchProvider}/search',
            uriVariables: ['searchProvider', 'term'],
            requirements: ['searchProvider' => '.{2,}'],
            controller: SearchController::class,
            normalizationContext: ['groups' => ['cache_v1:read']],
            read: false,
            name: 'app_search_v1'
        ),
        new Get(
            uriTemplate: '/v2/{searchProvider}/search',
            uriVariables: ['searchProvider', 'term'],
            requirements: ['searchProvider' => '.{2,}'],
            controller: SearchControllerV2::class,
            normalizationContext: ['groups' => ['cache_v2:read']],
            read: false,
            name: 'app_search_v2'
    )],
)]
class SearchCache
{
    use TimestampableEntity;

    #[Groups(['cache_v2:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: true)]
    private ?int $id = null;

    #[Groups(['cache_v1:read', 'cache_v2:read'])]
    #[ORM\Column(length: 50)]
    private ?string $term = null;

    #[Groups(['cache_v1:read', 'cache_v2:read'])]
    #[ORM\Column(type: Types::FLOAT, precision: 4, scale: 2)]
    private ?float $score = null;

    #[Groups(['cache_v1:read', 'cache_v2:read'])]
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
