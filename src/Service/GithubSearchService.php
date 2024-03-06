<?php

namespace App\Service;

use App\Entity\SearchCache;
use App\Service\SearchProvider\SearchProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubSearchService implements SearchServiceInterface
{
    public function __construct(
        private HttpClientInterface    $client,
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function getResult(SearchProviderInterface $searchProvider, string $term): array
    {
        $record = $this->entityManager->getRepository(SearchCache::class)->findOneBy(['searchProvider' => $searchProvider->getName(), 'term' => $term]);

        if ($record !== null) {
            return $record; //TODO: return formatted response
        }

        $rocksTerm = strtolower($term) . ' rocks';
        $rocksQuery = sprintf('"%s" type:issue', $rocksTerm);

        $positiveResponse = $this->client->request('GET', $searchProvider->getSearchUrl(), [
            'query' => ['q' => $rocksQuery],
            'headers' => ['Accept' => 'application/vnd.github.text-match+json']
        ]);

        $sucksTerm = strtolower($term) . ' sucks';
        $sucksQuery = sprintf('"%s" type:issue', $sucksTerm);

        $negativeResponse = $this->client->request('GET', $searchProvider->getSearchUrl(), [
            'query' => ['q' => $sucksQuery],
            'headers' => ['Accept' => 'application/vnd.github.text-match+json']
        ]);

        $statusCode = $positiveResponse->getStatusCode();
        $content = $positiveResponse->getContent();
        $resultsArray = $positiveResponse->toArray();
        $totalResults = $resultsArray['total_count'];

        if ($totalResults === 0) {
            return [0]; // No results, return score as 0
        }

        $positiveResults = 0;
        $negativeResults = 0;

        foreach ($resultsArray['items'] as $item) {
            $jsonString = json_encode($item);
            $jsonStringLower = strtolower($jsonString);

            $count = substr_count($jsonStringLower, $rocksTerm);

            $positiveResults += $count;
        }

        $score = ($positiveResults - $negativeResults) / $totalResults * 10;
        $scoreRatio = max(0, min(10, $score));

        dd($scoreRatio);

        return $resultsArray;

    }
}