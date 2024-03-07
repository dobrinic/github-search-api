<?php

namespace App\Controller\Search\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\SearchServiceInterface;
use App\Service\SearchProvider\SearchProviderFactory;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search/v1/{provider}', name: 'app_search_v1', requirements: ['provider' => '.{2,}'])]
    public function __invoke(string $provider, Request $request, SearchProviderFactory $providerFactory, SearchServiceInterface $searchService): JsonResponse
    {
        if (null === $term = $request->get('term')) {
            return new JsonResponse(['error' => 'Term parameter is missing'], 400);
        }

        try {
            $searchProvider = $providerFactory->getProvider($provider);
            $result = $searchService->getResult($searchProvider, $term);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()]);
        }

        return $this->json($result);
    }
}
