<?php

namespace App\Service;

use App\Service\SearchProvider\SearchProviderInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubSearchService implements SearchServiceInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private ParameterBagInterface $parameterBag
        )
    {
    }

    public function getResult(SearchProviderInterface $searchProvider, string $term): array
    {
        $rocksQuery = sprintf('"%s rocks" type:issue', $term);

        $positiveResponse = $this->client->request('GET', $searchProvider->getSearchUrl(), [
            'query' => [
                'q' => $rocksQuery,
            ],
            'headers' => [
                // 'Authorization' => 'Bearer ' . $searchProvider->getToken(),
                'Accept' => 'application/vnd.github.text-match+json',
            ],
        ]);

        $statusCode = $positiveResponse->getStatusCode();
        // return $positiveResponse->getContent();

        return $positiveResponse->toArray();

    }
}