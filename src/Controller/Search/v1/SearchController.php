<?php

namespace App\Controller\Search\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\SearchServiceInterface;
use App\Service\SearchProvider\SearchProviderFactory;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search/v1/{provider}', name: 'app_search_v1', requirements: ['provider' => '.{2,}'])]
    public function __invoke(string $provider, Request $request, SearchProviderFactory $providerFactory, SearchServiceInterface $searchService): Response
    {
        if (null === $term = $request->get('term')){
            throw new Exception('search term missing');
        }

        $searchProvider = $providerFactory->getProvider($provider);

        $result = $searchService->getResult($searchProvider, $term);

        return $this->json($result);
    }
}
