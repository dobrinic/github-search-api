<?php

namespace App\Service\SearchProvider;

interface SearchProviderInterface
{
    public function getSearchUrl(): string;
    public function getName(): string;
    public function getToken(): string;
}
