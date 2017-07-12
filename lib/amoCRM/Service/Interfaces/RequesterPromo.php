<?php

namespace amoCRM\Service\Interfaces;

interface RequesterPromo extends Requester
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
