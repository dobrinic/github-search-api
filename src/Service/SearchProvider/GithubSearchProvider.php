<?php

namespace App\Service\SearchProvider;

use App\Service\SearchProvider\SearchProviderInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GithubSearchProvider implements SearchProviderInterface
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function getSearchUrl(): string
    {
        if (null === $searchUrl = $this->parameterBag->get('github_provider_search_url')) {
            throw new \RuntimeException('github_provider_search_url parameter is not defined.');
        }
        
        return $searchUrl;
    }

    public function getName(): string
    {
        return 'github';
    }

    public function getToken(): string
    {
        return $this->parameterBag->get('github_provider_token');
    }
}