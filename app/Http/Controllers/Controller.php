<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response as HttpResponse;

abstract class Controller
{
    /**
     * Удобный метод для отправки успешного JSON-ответа с произвольными данными.
     */
    protected function success($data, int $status = HttpResponse::HTTP_OK)
    {
        return response($data, $status)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Отправка API Resource (или другого объекта, который корректно сериализуется) с заголовком и кодом.
     */
    protected function resource($resource, int $status = HttpResponse::HTTP_OK)
    {
        // Для API Resource возвращаем объект ресурса напрямую — Laravel сам сериализует его в HTTP-ответ.
        // Если нужен кастомный HTTP-код, ресурс можно вручную превратить в ответ через ->response()->setStatusCode(...).
        if (method_exists($resource, 'response')) {
            $response = $resource->response();
            if ($status !== HttpResponse::HTTP_OK) {
                $response->setStatusCode($status);
            }
            return $response;
        }

        return $resource;
    }

    /**
     * Отправка простого сообщения.
     */
    protected function message(string $message, int $status = HttpResponse::HTTP_OK)
    {
        return response()->json(['message' => $message], $status);
    }

    /**
     * Отправка ошибки.
     */
    protected function error(string $message, int $status = HttpResponse::HTTP_INTERNAL_SERVER_ERROR)
    {
        return response()->json(['message' => $message], $status);
    }
}
