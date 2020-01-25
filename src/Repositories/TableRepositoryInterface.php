<?php

namespace Quickweb\Repositories\Repositories;

interface TableRepositoryInterface
{
    /**
     * @param null $connection
     * @return array
     */
    public function showAvailableTables($connection = NULL): array;
}
