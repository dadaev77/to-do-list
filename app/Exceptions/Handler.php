<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    // ...existing code...

    /**
     * Зарегистрированные для логирования исключения и т.д. Оставлено по умолчанию.
     */
    protected $dontReport = [
        //
    ];

    /**
     * Зарегистрированные исключения, чьи всплывающие сообщения не будут показаны.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        // Можно оставить пустым или добавить колбэки reportable/renderable
    }

    /**
     * Преобразование исключения в HTTP-ответ.
     */
    public function render($request, Throwable $e)
    {
        // Для API-запросов возвращаем структурированный JSON
        if ($request->is('api/*') || $request->wantsJson()) {
            // Validation errors
            if ($e instanceof ValidationException) {
                return response()->json([
                    'message' => 'Ошибка валидации данных',
                    'errors' => $e->errors(),
                ], 422);
            }

            // Not found model
            if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
                return response()->json([
                    'message' => 'Ресурс не найден',
                    'error' => 'Запрашиваемый объект не существует',
                ], 404);
            }

            // Authentication
            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'message' => 'Неавторизованный доступ'
                ], 401);
            }

            // HttpException с собственным кодом
            if ($e instanceof HttpExceptionInterface) {
                $status = $e->getStatusCode();

                return response()->json([
                    'message' => $e->getMessage() ?: 'Ошибка HTTP',
                ], $status);
            }

            // Для всех остальных ошибок возвращаем 500
            return response()->json([
                'message' => 'Внутренняя ошибка сервера'
            ], 500);
        }

        // Для обычных (web) запросов используем стандартную обработку
        return parent::render($request, $e);
    }
}

