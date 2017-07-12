<?php

namespace amoCRM\Filter\Interfaces;

/**
 * Interface SearchFilter
 * Base search interface for elements/list requests
 * @package amoCRM\Filter\Interfaces
 */
interface SearchFilter
{
    /**
     * Return array representation of filter
     * @return array
     */
    public function toArray();
}
