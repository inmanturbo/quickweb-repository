<?php


namespace Quickweb\Repositories\Repositories;

use Illuminate\Support\Str;
use Illuminate\Database\ConnectionResolverInterface as Base;
use Illuminate\Http\Request;

class Repository implements TableRepositoryInterface, FieldRepositoryInterface
{
    protected $base;

    public function __construct(Base $base)
    {
        $this->base = $base;
    }

    /**
     * @param array $request
     * @param $table
     * @param null $connection
     * @return array
     */
    public function getValidFields(array $request, $table, $connection = NULL): array
    {

        $fields = $this->getConnection($connection)
            ->getSchemaBuilder()
            ->getColumnListing($table);

        if (config('quickwebrepository.resolvemismatchedfields')) {
            return $this->mapFields($request, $fields);
        }
        $request = new Request($request);
        return $request->only($fields);
    }

    protected function mapFields(array $request, array $fields): array
    {

        $array = [];
        foreach ($request as $k => $v) {
            if (!in_array($k, $fields)) {
                if (in_array($k = Str::fromCamelCase($k), $fields)) {
                    $array[$k] = $v;
                }
            } else {

                $array[$k] = $v;
            }
        }
        return $array;
    }


    /**
     * @param null $connection
     * @return array
     */
    public function showAvailableTables($connection = NULL): array
    {

        return $this->getTables(

            $this->getConnection($connection)
        );
    }


    /**
     * @param $connection
     * @return \Illuminate\Config\Repository|mixed
     */
    private function getConnection($connection = null)
    {
        return $this->base->connection($connection ?? config('database.default'));
    }

    /**
     * @param $connection
     * @return array
     */
    private function getTables($connection): array
    {
        return array_map('current', $this->getConnection($connection)
            ->select('SHOW TABLES'));
    }
}
