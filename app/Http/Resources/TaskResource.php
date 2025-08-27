<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * API Resource для форматирования задач
 * 
 * Преобразует модель Task в унифицированный формат JSON для API ответов.
 * Обеспечивает единообразное представление данных задач во всех endpoints.
 * 
 * @package App\Http\Resources
 */
class TaskResource extends JsonResource
{
    /**
     * Преобразовать ресурс в массив для JSON ответа.
     * 
     * Форматирует данные модели Task в унифицированную структуру для API.
     * Даты преобразуются в читаемый формат 'Y-m-d H:i:s'.
     *
     * @param Request $request Входящий HTTP запрос
     * @return array<string, mixed> Массив данных задачи для JSON ответа
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
