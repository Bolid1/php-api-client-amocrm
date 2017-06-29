<?php

namespace amoCRM\Entities\Filters\Interfaces;

/**
 * Interface SearchFilter
 * Base search interface for elements/list requests
 * @package amoCRM\Entities\Filters\Interfaces
 */
interface SearchFilter
{
    /**
     * Return array representation of filter
     * @return array
     */
    public function toArray();
}
