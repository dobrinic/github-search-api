<?php

namespace App\Service\SearchProvider;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TwitterSearchProvider implements SearchProviderInterface
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
        throw new \RuntimeException('Not yet implemented');
    }

    public function getSearchUrl(): string
    {
        throw new \RuntimeException('Not yet implemented');
    }

    public function getName(): string
    {
        throw new \RuntimeException('Not yet implemented');
    }

    public function getToken(): string
    {
        throw new \RuntimeException('Not yet implemented');
    }
}