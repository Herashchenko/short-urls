<?php

namespace App\Controller;

use App\Service\UrlService;
use App\Service\UrlStatisticsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class StatisticsController extends AbstractController
{
    /**
     * @param string $shortCode
     * @param UrlService $urlService
     * @return Response
     */
    public function showStatistics(
        string $shortCode,
        UrlService $urlService
    ): Response {
        $url = $urlService->getUrlByShortCode($shortCode);

        if (!$url) {
            return $this->redirectToRoute('index');
        }

        return $this->render('statistics.html.twig', [
            'url' => $url
        ]);
    }

    /**
     * @param string $shortCode
     * @param UrlService $urlService
     * @param UrlStatisticsService $statisticsService
     * @return Response
     */
    public function chartData(
        string $shortCode,
        UrlService $urlService,
        UrlStatisticsService $statisticsService
    ): Response {
        $url = $urlService->getUrlByShortCode($shortCode);

        if (!$url) {
            return new Response('',404);
        }

        $result = $statisticsService->prepareStatisticsForChart($url);
        return new Response(json_encode($result));
    }
}
