<?php

namespace App\Services;

use App\Models\UrlLog;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

/**
 * Работа с url логами
 */
class UrlLogService {
    /**
     * Создание лога
     *
     * @param Request $request Запрос
     *
     * @return UrlLog
     * @throws \Exception
     */
    public static function make(Request $request): UrlLog {
        // валидация
        $request->validate([
            'url' => 'required|string|max:2048',
            'created_at' => 'required|date',
        ]);
        $data = array_merge($request->all(), ['urlhash' => md5($request->get('url'))]);

        return UrlLog::create($data);
    }

    /**
     * Статистика лога
     *
     * @param Request $request
     *
     * @return array
     */
    public static function stats(Request $request): array {
        $perPage = (int)$request->get('per_page') ?: 10;
        $page = (int)$request->get('page') ?: 1;

        /** @var Paginator $paginator */
        $paginator = UrlLog::select('url', DB::raw('COUNT(id) as cnt'), DB::raw('MAX(created_at) as last_click'))
            ->groupBy('url', 'urlhash')
            ->orderBy('url')
            ->paginate($perPage, ['*'], 'page', $page);

        return [
            'page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'items' => $paginator->items(),
        ];
    }


}
