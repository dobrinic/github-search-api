<?php

namespace App\Service\SearchProvider;

use App\Service\SearchProvider\GithubSearchProvider;
use App\Service\SearchProvider\TwitterSearchProvider;
use App\Service\SearchProvider\SearchProviderInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SearchProviderFactory
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function getProvider(string $provider): SearchProviderInterface
    {
        return match ($provider) {
            'github' => new GithubSearchProvider($this->parameterBag),
            'twitter' => new TwitterSearchProvider($this->parameterBag),
            default => throw new \InvalidArgumentException("Unknown provider: $provider"),// should return 404
        };
    }
}
