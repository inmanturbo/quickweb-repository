<?php

namespace Quickweb\Repositories\Repositories;

interface FieldRepositoryInterface
{
    /**
     * @param array  $request
     * @param $table
     * @param null $connection
     * @return array
     */
    public function getValidFields(array $request, $table, $connection = NULL): array;
}
