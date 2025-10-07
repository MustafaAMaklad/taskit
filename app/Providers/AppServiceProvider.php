<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Services\Task\TaskService::class, \App\Services\Task\TaskServiceEloquent::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('success', function (?string $message = null, mixed $data = null, int $statusCode = 200) {
            /** @var Response $this */
            return $this->json(array_filter([
                'message' => $message,
                'data' => $data,
            ]), $statusCode);
        });

        Response::macro('error', function (array|string $errors, int $statusCode = 400) {
            /** @var Response $this */
            return $this->json([
                'message' => array_first(is_array($errors) ? $errors : [$errors]),
                'errors' => $errors,
            ], $statusCode);
        });
    }
}
