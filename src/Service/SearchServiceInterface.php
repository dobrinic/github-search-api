<?php

namespace App\Service;

use App\Service\SearchProvider\SearchProviderInterface;

interface SearchServiceInterface
{
    public function getResult(SearchProviderInterface $searchProvider, string $term): array;
}
