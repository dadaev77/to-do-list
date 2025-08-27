<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Запрос для валидации создания новой задачи
 * 
 * Содержит правила валидации и кастомные сообщения об ошибках
 * для создания новых задач через API.
 * 
 * @package App\Http\Requests
 */
class StoreTaskRequest extends FormRequest
{
    /**
     * Определяет, авторизован ли пользователь для выполнения этого запроса.
     * 
     * @return bool Всегда возвращает true, так как авторизация не требуется
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Получить правила валидации для запроса создания задачи.
     * 
     * Правила валидации:
     * - title: обязательное поле, строка, максимум 255 символов
     * - description: необязательное поле, строка, максимум 1000 символов  
     * - status: необязательное поле, одно из допустимых значений статуса
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['sometimes', Rule::in(Task::STATUS_OPTIONS)],
        ];
    }

    /**
     * Получить кастомные сообщения об ошибках валидации.
     * 
     * Все сообщения локализованы на русский язык для удобства пользователей.
     *
     * @return array<string, string> Массив сообщений об ошибках
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Название задачи обязательно для заполнения.',
            'title.max' => 'Название задачи не должно превышать 255 символов.',
            'description.max' => 'Описание задачи не должно превышать 1000 символов.',
            'status.in' => 'Недопустимый статус задачи. Доступные значения: ' . implode(', ', Task::STATUS_OPTIONS),
        ];
    }
}
