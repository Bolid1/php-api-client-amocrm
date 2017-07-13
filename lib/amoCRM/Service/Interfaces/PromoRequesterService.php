<?php

namespace amoCRM\Service\Interfaces;

interface PromoRequesterService extends RequesterService
{
    /**
     * @param string $top_level_domain
     */
    public function setTopLevelDomain($top_level_domain);

    /**
     * Check subdomain properties
     *
     * @param array|string $subdomains
     * @return array
     */
    public function domains($subdomains);
}
