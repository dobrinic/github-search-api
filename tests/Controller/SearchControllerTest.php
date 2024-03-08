<?php

namespace App\Tests\Controller;

use App\Controller\api\Search\v1\SearchController;
use App\Entity\SearchCache;
use App\Service\SearchProvider\SearchProviderFactory;
use App\Service\SearchServiceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SearchControllerTest extends TestCase
{
    public function testControllerReturnType(): void
    {
        $parameterBag = $this->createMock(ParameterBagInterface::class);
        $searchService = $this->createMock(SearchServiceInterface::class);

        $providerFactory = new SearchProviderFactory($parameterBag);

        $provider = $providerFactory->getProvider('github');
        $result = $searchService->getResult($provider, 'java');

        $this->assertInstanceOf(SearchCache::class, $result);
    }

    public function testExceptionHandling(): void
    {
        $providerFactory = $this->createMock(SearchProviderFactory::class);
        $searchService = $this->createMock(SearchServiceInterface::class);

        $provider = $providerFactory->getProvider('$searchProvider');
        $searchService->getResult($provider, 'java');

        $request = new Request([], [], ['term' => 'java']);
        $controller = new SearchController();

        $providerFactory->expects($this->once())
            ->method('getProvider')
            ->willThrowException(new \InvalidArgumentException('Unknown provider: provider'));

        $response = $controller('github', $request, $providerFactory, $searchService);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Unknown provider: provider', $data['error']);
    }

    public function testMissingTermParameter(): void
    {
        $providerFactory = $this->createMock(SearchProviderFactory::class);
        $searchService = $this->createMock(SearchServiceInterface::class);

        $request = new Request();
        $controller = new SearchController();

        $response = $controller('provider', $request, $providerFactory, $searchService);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['error' => 'Term parameter is missing']),
            $response->getContent()
        );
    }
}