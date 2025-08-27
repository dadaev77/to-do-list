<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * API контроллер для управления задачами
 * 
 * Предоставляет REST API endpoints для CRUD операций с задачами.
 * Все методы возвращают данные в формате JSON с использованием API Resources.
 * 
 * @package App\Http\Controllers\Api
 */
class TaskController extends Controller
{
    /**
     * Получить список всех задач
     * 
     * Возвращает коллекцию всех задач, отсортированных по дате создания (новые первыми).
     * 
     * @group Задачи
     * 
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "title": "Название задачи",
     *       "description": "Описание задачи",
     *       "status": "pending",
     *       "created_at": "2025-08-27 10:47:12",
     *       "updated_at": "2025-08-27 10:47:12"
     *     }
     *   ]
     * }
     * 
     * @return AnonymousResourceCollection Коллекция задач в формате TaskResource
     */
    public function index(): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|AnonymousResourceCollection
    {
        $tasks = Task::latest()->get();

        return $this->resource(TaskResource::collection($tasks));
    }

    /**
     * Создать новую задачу
     * 
     * Создает новую задачу с указанными параметрами.
     * Все данные проходят валидацию через StoreTaskRequest.
     * 
     * @group Задачи
     * 
     * @bodyParam title string required Название задачи (обязательно, максимум 255 символов) Example: Моя новая задача
     * @bodyParam description string Описание задачи (необязательно, максимум 1000 символов) Example: Подробное описание задачи
     * @bodyParam status string Статус задачи (необязательно, по умолчанию "pending") Example: pending
     * 
     * @response 201 {
     *   "data": {
     *     "id": 1,
     *     "title": "Моя новая задача",
     *     "description": "Подробное описание задачи",
     *     "status": "pending",
     *     "created_at": "2025-08-27 10:47:12",
     *     "updated_at": "2025-08-27 10:47:12"
     *   }
     * }
     * 
     * @response 400 {
     *   "message": "Ошибка валидации данных",
     *   "errors": {
     *     "title": ["Название задачи обязательно для заполнения."]
     *   }
     * }
     * 
     * @param StoreTaskRequest $request Валидированный запрос с данными для создания задачи
     * @return TaskResource Созданная задача в формате TaskResource
     */
    public function store(StoreTaskRequest $request): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\App\Http\Resources\TaskResource
    {
        $task = Task::create($request->validated());

        return $this->resource(new TaskResource($task), 201);
    }

    /**
     * Получить конкретную задачу
     * 
     * Возвращает данные одной задачи по её ID.
     * Использует Model Binding Laravel для автоматического поиска модели.
     * 
     * @group Задачи
     * 
     * @urlParam id integer required ID задачи Example: 1
     * 
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "title": "Название задачи",
     *     "description": "Описание задачи",
     *     "status": "pending",
     *     "created_at": "2025-08-27 10:47:12",
     *     "updated_at": "2025-08-27 10:47:12"
     *   }
     * }
     * 
     * @response 404 {
     *   "message": "Ресурс не найден",
     *   "error": "Запрашиваемый объект не существует"
     * }
     * 
     * @param Task $task Модель задачи (автоматически найдена по ID из URL)
     * @return TaskResource Задача в формате TaskResource
     */
    public function show(Task $task): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\App\Http\Resources\TaskResource
    {
        return $this->resource(new TaskResource($task));
    }

    /**
     * Обновить существующую задачу
     * 
     * Обновляет данные существующей задачи. Можно передать только те поля, которые нужно изменить.
     * Все данные проходят валидацию через UpdateTaskRequest.
     * 
     * @group Задачи
     * 
     * @urlParam id integer required ID задачи Example: 1
     * @bodyParam title string Новое название задачи (необязательно, если передается - то обязательно, максимум 255 символов) Example: Обновленное название
     * @bodyParam description string Новое описание задачи (необязательно, максимум 1000 символов) Example: Обновленное описание
     * @bodyParam status string Новый статус задачи (необязательно, pending|in_progress|completed) Example: completed
     * 
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "title": "Обновленное название",
     *     "description": "Обновленное описание",
     *     "status": "completed",
     *     "created_at": "2025-08-27 10:47:12",
     *     "updated_at": "2025-08-27 10:51:12"
     *   }
     * }
     * 
     * @response 404 {
     *   "message": "Ресурс не найден",
     *   "error": "Запрашиваемый объект не существует"
     * }
     * 
     * @response 422 {
     *   "message": "Ошибка валидации данных",
     *   "errors": {
     *     "status": ["Недопустимый статус задачи. Доступные значения: pending, in_progress, completed"]
     *   }
     * }
     * 
     * @param UpdateTaskRequest $request Валидированный запрос с данными для обновления
     * @param Task $task Модель задачи для обновления (автоматически найдена по ID из URL)
     * @return TaskResource Обновленная задача в формате TaskResource
     */
    public function update(UpdateTaskRequest $request, Task $task): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\App\Http\Resources\TaskResource
    {
        $task->update($request->validated());

        return $this->resource(new TaskResource($task));
    }

    /**
     * Удалить задачу
     * 
     * Удаляет указанную задачу из базы данных.
     * После успешного удаления возвращает сообщение об успехе.
     * 
     * @group Задачи
     * 
     * @urlParam id integer required ID задачи для удаления Example: 1
     * 
     * @response 200 {
     *   "message": "Задача успешно удалена"
     * }
     * 
     * @response 404 {
     *   "message": "Ресурс не найден",
     *   "error": "Запрашиваемый объект не существует"
     * }
     * 
     * @param Task $task Модель задачи для удаления (автоматически найдена по ID из URL)
     * @return JsonResponse JSON ответ с сообщением об успешном удалении
     */
    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return $this->message('Задача успешно удалена', 200);
    }
}
