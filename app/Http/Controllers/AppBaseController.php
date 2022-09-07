<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="OpenApi Documentation",
 *      description="Документация для микро сервиса",
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Основной API"
 * )

 * @OA\Tag(
 *     name="Cars",
 *     description="Аренда машин"
 * )
 * * @OA\Tag(
 *     name="Users",
 *     description="Арендаторы машин"
 * )
 */

class AppBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return response()->json($this->makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return response()->json($this->makeError($error), $code);
    }

    public function sendSuccess($message)
    {
        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }

    public static function makeResponse(string $message, mixed $data): array
    {
        return [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];
    }

    public static function makeError(string $message, array $data = []): array
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }
}
