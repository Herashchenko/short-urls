<?php

namespace App\Service;

use App\Entity\Url;
use App\Entity\UrlStatistics;
use App\Helper\CookieHelper;
use App\Helper\Tools;
use App\Helper\UserAgentHelper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UrlStatisticsService
{
    private $doctrine;

    /**
     * UrlStatisticsService constructor.
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param Url $url
     * @param string $userAgent
     * @param string $ip
     * @return UrlStatistics
     */
    public function saveStatistics(Url $url, string $userAgent, string $ip): UrlStatistics
    {
        $statistics = new UrlStatistics();
        $statistics->setDate(new \DateTime());
        $statistics->setUserAgent($userAgent);
        $statistics->setIp($ip);
        $statistics->setUrl($url);

        $this->doctrine->getRepository(UrlStatistics::class)->add($statistics, true);

        return $statistics;
    }

    /**
     * @param Url $url
     * @return array
     */
    public function prepareStatisticsForChart(Url $url): array
    {
        $statistics = $url->getStatistics()->toArray();
        $byDate = [];
        $byBrowser = [];
        $byPlatform = [];
        /** @var UrlStatistics[] $statistics */
        foreach ($statistics as $statistic) {
            if (!isset($byDate[$statistic->getDate()->format('d.m.Y')])) {
                $byDate[$statistic->getDate()->format('d.m.Y')] = 0;
            }
            $byDate[$statistic->getDate()->format('d.m.Y')] += 1;

            $browser = UserAgentHelper::getBrowser($statistic->getUserAgent());
            if (!isset($byBrowser[$browser])) {
                $byBrowser[$browser] = 0;
            }
            $byBrowser[$browser] += 1;

            $platform = UserAgentHelper::getPlatform($statistic->getUserAgent());
            if (!isset($byPlatform[$platform])) {
                $byPlatform[$platform] = 0;
            }
            $byPlatform[$platform] += 1;
        }

        return [
            'byDate' => $byDate,
            'byBrowser' => $byBrowser,
            'byPlatform' => $byPlatform
        ];
    }
}
