<?php

namespace App\Service;

use App\Entity\SearchCache;
use App\Service\SearchProvider\SearchProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubSearchService implements SearchServiceInterface
{
    private const POSITIVE_INDICATOR = 'rocks';
    private const NEGATIVE_INDICATOR = 'sucks';

    public function __construct(
        private readonly HttpClientInterface    $client,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function getResult(SearchProviderInterface $searchProvider, string $searchTerm): SearchCache
    {
        $record = $this->entityManager->getRepository(SearchCache::class)->findOneBy(['searchProvider' => $searchProvider->getName(), 'term' => $searchTerm]);

        if ($record !== null) {
            return $record;
        }

        $positiveSearchTerm = strtolower($searchTerm) . ' ' . self::POSITIVE_INDICATOR;
        $negativeSearchTerm = strtolower($searchTerm) . ' ' . self::NEGATIVE_INDICATOR;

        $positive = $this->search($searchProvider->getSearchUrl(), $positiveSearchTerm);
        $negative = $this->search($searchProvider->getSearchUrl(), $negativeSearchTerm);

        $positiveCount = $this->countOccurrences($positive, $positiveSearchTerm);
        $negativeCount = $this->countOccurrences($negative, $negativeSearchTerm);

        $totalCount = $positiveCount + $negativeCount;

        $score = ($totalCount > 0) ? ($positiveCount / $totalCount) * 10 : 0;
        $scoreRatio = round(max(0, min(10, $score)), 2);

        $newRecord = new SearchCache();
        $newRecord
            ->setSearchProvider($searchProvider->getName())
            ->setScore($scoreRatio)
            ->setTerm($searchTerm);

        $this->entityManager->persist($newRecord);
        $this->entityManager->flush();

        return $newRecord;

    }

    private function search(string $url, string $searchTerm): array
    {
        $query = sprintf('"%s" type:issue', $searchTerm);

        try {
            $response = $this->client->request('GET', $url, [
                'query' => ['q' => $query],
                'headers' => ['Accept' => 'application/vnd.github.v3+json']
            ]);

            $resultsArray = $response->toArray();

        } catch (ClientExceptionInterface|DecodingExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e) {
            return ['total_count' => 0];// depending on the app requirements we could return specific message, or a generic one instead of result=0
        }

        return $resultsArray;
    }

    private function countOccurrences(array $results, string $searchTerm): int
    {
        if ($results['total_count'] === 0) {
            return 0;
        }

        $hits = 0;
        foreach ($results['items'] as $item) {
            $jsonString = json_encode($item);
            $jsonStringLower = strtolower($jsonString);

            $count = substr_count($jsonStringLower, $searchTerm);

            $hits += $count;
        }

        return $hits;
    }
}