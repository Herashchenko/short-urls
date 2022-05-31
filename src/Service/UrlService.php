<?php

namespace App\Service;

use App\Entity\Url;
use App\Helper\CookieHelper;
use App\Helper\Tools;
use App\Helper\UrlHelper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UrlService
{
    private $doctrine;
    private $validator;

    /**
     * UrlService constructor.
     * @param ManagerRegistry $doctrine
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $doctrine, ValidatorInterface $validator)
    {
        $this->doctrine = $doctrine;
        $this->validator = $validator;
    }

    /**
     * @param string $shortCode
     * @return Url
     */
    public function getUrlByShortCode(string $shortCode): ?Url
    {
        return $this->doctrine->getRepository(Url::class)->findOneByShortCodeAndByCurrentDate($shortCode);
    }

    /**
     * @param array $ids
     * @return Url[]
     */
    public function getUrlByByIdsAndByCurrentDate(array $ids): array
    {
        return $this->doctrine->getRepository(Url::class)->findOneByIdsAndByCurrentDate($ids);
    }

    /**
     * @param string $urlFrom
     * @param string $expirationDate
     * @return Url|null
     * @throws \Exception
     */
    public function createShortUrl(string $urlFrom, string $expirationDate): ?Url
    {
        if (!$urlFrom = UrlHelper::getValidUrl($urlFrom)) {
            return null;
        }

        $url = new Url();
        $url->setUrlFrom($urlFrom);
        $url->setExpirationDate(new \DateTime($expirationDate));
        $url->setShortCode(Tools::createGuid());

        $errors = $this->validator->validate($url);
        if (count($errors) > 0) {
            throw new \Exception((string) $errors);
        }

        $this->doctrine->getRepository(Url::class)->add($url, true);

        $this->saveToCookie($url->getId());

        return $url;
    }

    /**
     * @return array
     */
    public function getUrlByCookies(): array
    {
        $cookie = CookieHelper::getCookieValue(CookieHelper::COOKIE_KEY_URL_IDS);
        if ($cookie) {
            $urls = $this->getUrlByByIdsAndByCurrentDate(json_decode($cookie, true));
            $value = [];
            foreach ($urls as $url) {
                $value[] = $url->getId();
            }
            CookieHelper::updateCookieValue(CookieHelper::COOKIE_KEY_URL_IDS, json_encode($value));

            return $urls;
        }

        return [];
    }

    /**
     * @param int $newUrlId
     */
    protected function saveToCookie(int $newUrlId): void
    {
        $cookie = CookieHelper::getCookieValue(CookieHelper::COOKIE_KEY_URL_IDS);
        $value = [$newUrlId];
        if ($cookie) {
            $urls = $this->getUrlByByIdsAndByCurrentDate(json_decode($cookie, true));
            foreach ($urls as $url) {
                $value[] = $url->getId();
            }
        }

        CookieHelper::updateCookieValue(CookieHelper::COOKIE_KEY_URL_IDS, json_encode($value));
    }

    public function removeUrlByExpirationDate()
    {
        $this->doctrine->getRepository(Url::class)->removeByExpirationDate();
    }
}
