<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Обработка ModelNotFoundException (когда модель не найдена)
        $exceptions->render(function (Illuminate\Database\Eloquent\ModelNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Ресурс не найден',
                    'error' => 'Запрашиваемый объект не существует'
                ], 404);
            }
            
            return null;
        });

        // Обработка NotFoundHttpException (404 ошибки)
        $exceptions->render(function (Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Ресурс не найден',
                    'error' => 'Запрашиваемый объект не существует'
                ], 404);
            }
            
            return null;
        });

        // Обработка ошибок валидации
        $exceptions->render(function (Illuminate\Validation\ValidationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Ошибка валидации данных',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return null;
        });

        // Обработка общих ошибок
        $exceptions->render(function (Throwable $e, $request) {
            if ($request->is('api/*') && !config('app.debug')) {
                return response()->json([
                    'message' => 'Внутренняя ошибка сервера',
                    'error' => 'Что-то пошло не так'
                ], 500);
            }
            
            return null;
        });
    })->create();
