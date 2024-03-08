<?php

namespace App\Controller\api\Search\v1;

use App\Entity\SearchCache;
use App\Service\SearchProvider\SearchProviderFactory;
use App\Service\SearchServiceInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class SearchController extends AbstractController
{
    public function __invoke(string $searchProvider, Request $request, SearchProviderFactory $providerFactory, SearchServiceInterface $searchService): JsonResponse|SearchCache
    {
        if (null === $term = $request->get('term')) {
            return new JsonResponse(['error' => 'Term parameter is missing'], 400);
        }

        try {
            $provider = $providerFactory->getProvider($searchProvider);
            $result = $searchService->getResult($provider, $term);
        } catch (Exception $e) {
            // Log message
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        return $result;
    }
}
