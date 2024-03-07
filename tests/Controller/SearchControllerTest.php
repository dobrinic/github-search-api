<?php

namespace App\Tests\Controller;

use App\Controller\Search\v1\SearchController;
use App\Service\SearchProvider\SearchProviderFactory;
use App\Service\SearchServiceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class SearchControllerTest extends TestCase
{
    public function testMissingTermParameter(): void
    {
        $providerFactory = $this->createMock(SearchProviderFactory::class);
        $searchService = $this->createMock(SearchServiceInterface::class);

        $controller = new SearchController();

        $request = Request::create('/search/v1/github', 'GET', ['provider' => 'github']);

        $response = $controller('github', $request, $providerFactory, $searchService);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error', $content);
        $this->assertEquals('Term parameter is missing', $content['error']);
    }
}