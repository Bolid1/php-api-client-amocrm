<?php

namespace amoCRM\Service;

use amoCRM\Entity;
use GuzzleHttp\ClientInterface;

/**
 * Class Requester
 * Класс для отправки запросов промо-сайту amoCRM
 * Автоматически авторизуется перед первым запросом за сессию.
 * @package amoCRM
 */
final class PromoRequesterService extends BaseRequesterService implements Interfaces\PromoRequesterService
{
    public function __construct(ClientInterface $curl)
    {
        $account = new Entity\Account('www');
        parent::__construct($account, $curl);
    }

    /**
     * @param string $top_level_domain
     */
    public function setTopLevelDomain($top_level_domain)
    {
        $this->account->setTopLevelDomain($top_level_domain);
    }

    /**
     * Check subdomain properties
     *
     * @param array|string $subdomains
     * @return array
     * @throws \amoCRM\Exception\AuthFailed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function domains($subdomains)
    {
        return $this->post('api/accounts/domains/', ['domains' => (array)$subdomains]);
    }
}
