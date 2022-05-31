<?php

namespace App\Controller;

use App\Service\UrlService;
use App\Service\UrlStatisticsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    /**
     * @param UrlService $service
     * @return Response
     */
    public function index(UrlService $service): Response
    {
        return $this->render('index.html.twig', [
            'formAction' => $this->generateUrl('url'),
            'urls' => $service->getUrlByCookies()
        ]);
    }

    /**
     * @param Request $request
     * @param UrlService $service
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createUrl(Request $request, UrlService $service)
    {
        try {
            $service->createShortUrl(
                $request->get('url_from'),
                $request->get('expiration_date', date('d.m.Y'))
            );
        } catch (\Exception $exception) {
            return new Response($exception->getMessage(), 400);
        }

        return $this->redirectToRoute('index');
    }

    /**
     * @param string $shortCode
     * @param Request $request
     * @param UrlService $urlService
     * @param UrlStatisticsService $statisticsService
     * @return Response
     */
    public function indexRedirect(
        string $shortCode,
        Request $request,
        UrlService $urlService,
        UrlStatisticsService $statisticsService
    ): Response {
        $url = $urlService->getUrlByShortCode($shortCode);

        if (!$url) {
            return $this->redirectToRoute('index');
        }

        $statisticsService->saveStatistics($url, $request->headers->get('user-agent'), $request->getClientIp());

        return $this->redirect($url->getUrlFrom());
    }
}
