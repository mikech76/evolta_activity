<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Services\UrlLogService;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

/**
 * Процедура обработки JSON-RPC запросов
 */
class UrlLoggerProcedure extends Procedure {
    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'UrlLogger';

    /**
     * TEST Execute the procedure.
     *
     * @return string
     */
    public function ping(Request $request) {
        /*
            test
            http://127.0.0.1:8081/api/v1/endpoint
            {
                "jsonrpc": "2.0",
                "method": "UrlLogger@ping",
                "params": [],
                "id": 2
            }
         */
        return $request->all();

    }

    /**
     * Сохранитиь в лог
     *
     * @return array
     * @throws \Exception
     */
    public function save(Request $request): array {
        return UrlLogService::make($request)->toArray();
    }

    /**
     * Получить статистику
     *
     * @param Request $request
     *
     * @return array
     */
    public function stats(Request $request): array {
        return UrlLogService::stats($request);
    }
}
