<?php

namespace App\Service;

use App\Entity\SearchCache;
use App\Service\SearchProvider\SearchProviderInterface;

interface SearchServiceInterface
{
    public function getResult(SearchProviderInterface $searchProvider, string $searchTerm): SearchCache;
}
