<?php

namespace App\Service\SearchProvider;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SearchProviderFactory
{
    public function __construct(private readonly ParameterBagInterface $parameterBag)
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
