<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public const LIST_LIMIT = 10;

    public const LIST_LIMIT_MAX = 150;

    public const STATUS_OK = 200;

    public const STATUS_NO_CONTENT = 204;

    public const STATUS_CREATED = 201;

    public const HEADER_PAGINATION_TOTAL = 'x-pagination-total';

    public const HEADER_PAGINATION_LIMIT = 'x-pagination-limit';

    public const HEADER_PAGINATION_PAGES = 'x-pagination-pages';

    public const HEADER_PAGINATION_PAGE = 'x-pagination-page';

    /**
     * Response with list data
     *
     * @param Collection $data
     * @param int|null   $cnt
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function listResponse(Collection $data, ?int $cnt = null, ?int $limit = null, ?int $offset = null): Response
    {
        $headers = [];
        $limit = $limit ?? self::LIST_LIMIT;
        $qty = $cnt ?? \count($data);
        if ($cnt !== null && $limit > 0) {
            $pageQty = ceil($qty / $limit);
            $headers = [
                self::HEADER_PAGINATION_LIMIT => $limit,
                self::HEADER_PAGINATION_TOTAL => $qty,
                self::HEADER_PAGINATION_PAGES => $pageQty,
                self::HEADER_PAGINATION_PAGE  => floor($offset / max(1, $limit)),
            ];
        }

        return $this->response($data, $headers);
    }

    /**
     * Response
     *
     * @param mixed $data
     * @param int   $status
     * @param array $headers
     *
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function response($data, array $headers = [], int $status = self::STATUS_OK): Response
    {
        return \response()->json($data)->setStatusCode($status)->withHeaders($headers);
    }
}
