<?php

use PHPUnit\Framework\TestCase;
use App\Service\GithubSearchService;
use App\Entity\SearchCache;
use App\Service\SearchProvider\SearchProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SearchCacheRepository;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class GithubSearchServiceTest extends TestCase
{
    public function testRetrieveExistingRecordFromCache(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $searchProvider = $this->createMock(SearchProviderInterface::class);

        $searchProvider->method('getName')->willReturn('github');
        $searchProvider->method('getSearchUrl')->willReturn('https://api.github.com/search/issues');

        $searchCache = new SearchCache();
        
        $entityManager->method('getRepository')->willReturn($this->createStub(SearchCacheRepository::class));
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->willReturn($this->createStub(SearchCacheRepository::class));

        $searchCacheRepository = $this->createStub(SearchCacheRepository::class);
        $searchCacheRepository->method('findOneBy')->willReturn($searchCache);

        $entityManager->method('getRepository')->willReturn($searchCacheRepository);

        $service = new GithubSearchService(
            new MockHttpClient(),
            $entityManager
        );

        $result = $service->getResult($searchProvider, 'java');

        $this->assertInstanceOf(SearchCache::class, $result);
    }

}
