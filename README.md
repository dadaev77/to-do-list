# 📋 To-Do List API

REST API для управления задачами на Laravel 11.

## 🚀 Описание

API для управления списком задач с использованием современных практик Laravel разработки.

## ✨ Возможности

-   ✅ CRUD операции для задач
-   🔐 Валидация с кастомными сообщениями
-   🎯 Обработка ошибок
-   📊 API Resources для форматирования
-   📚 Подробные аннотации кода

## 🛠️ Технологии

-   PHP 8+ / Laravel 11
-   SQLite база данных
-   FormRequest, API Resources
-   Типизация и аннотации

## 📁 Структура

```
app/
├── Http/
│   ├── Controllers/Api/
│   │   └── TaskController.php      # API контроллер
│   ├── Requests/
│   │   ├── StoreTaskRequest.php    # Валидация создания
│   │   └── UpdateTaskRequest.php   # Валидация обновления
│   └── Resources/
│       └── TaskResource.php        # Форматирование ответов
└── Models/
    └── Task.php                    # Модель задачи

bootstrap/app.php                   # Обработка исключений
routes/api.php                      # API маршруты
database/migrations/                # Миграции БД
```

## 🌐 API Endpoints

| Метод    | URL               | Описание        |
| -------- | ----------------- | --------------- |
| `GET`    | `/api/tasks`      | Список задач    |
| `POST`   | `/api/tasks`      | Создать задачу  |
| `GET`    | `/api/tasks/{id}` | Получить задачу |
| `PUT`    | `/api/tasks/{id}` | Обновить задачу |
| `DELETE` | `/api/tasks/{id}` | Удалить задачу  |

## 📋 Установка

```bash
# 1. Установить зависимости
composer install

# 2. Выполнить миграции
php artisan migrate

# 3. Запустить сервер
php artisan serve
```

API доступно по адресу: `http://127.0.0.1:8000`

## 🧪 Тестирование

### Примеры с curl:

**Создать задачу:**

```bash
curl -X POST http://127.0.0.1:8000/api/tasks \
  -H "Content-Type: application/json" \
  -d '{"title":"Моя задача","status":"pending"}'
```

**Получить все задачи:**

```bash
curl -X GET http://127.0.0.1:8000/api/tasks
```

### Postman коллекция:

Импортируйте `postman_collection.json` с настройкой `base_url = http://127.0.0.1:8000`

## 📖 Документация

-   **API_DOCUMENTATION.md** - Подробная документация API
-   **ANNOTATIONS_GUIDE.md** - Руководство по аннотациям
-   **postman_collection.json** - Готовая коллекция Postman

## 🎯 Особенности

### Модель Task:

```php
// Поля: id, title, description, status, created_at, updated_at
// Статусы: pending, in_progress, completed
```

### Валидация:

-   `title` - обязательное, макс. 255 символов
-   `description` - необязательное, макс. 1000 символов
-   `status` - один из допустимых статусов

### Ответы API:

```json
// Успех
{"data": {"id": 1, "title": "Задача", "status": "pending"}}

// Ошибка валидации
{"message": "Ошибка валидации", "errors": {...}}

// 404 ошибка
{"message": "Ресурс не найден", "error": "Объект не существует"}
```

## 💡 Архитектурные решения

-   **FormRequest** классы для валидации
-   **API Resources** для форматирования
-   **Model Binding** для поиска моделей
-   **Кастомная обработка исключений**
-   **Типизация методов** PHP 8+
-   **Подробные аннотации** для документации

## 📸 Скриншоты работы API

### 1. Создание задачи (POST /api/tasks)

![Создать задачу](images/1.%20Создать%20задачу.png)

### 2. Получение одной задачи (GET /api/tasks/{id})

![Получить задачу](images/2.%20Получить%20задачу.png)

### 3. Список всех задач (GET /api/tasks)

![Список задач](images/3.%20Список%20задач.png)

### 4. Обновление задачи (PUT /api/tasks/{id})

![Обновить задачу](images/4.%20Обновить%20задачу.png)

### 5. Удаление задачи (DELETE /api/tasks/{id})

![Удалить задачу](images/5.%20Удалить%20задачу.png)

### 6. Ошибка валидации данных

![Ошибка валидации](images/6.%20Ошибка%20валидации%20данных%20при%20создании%20задачи.png)

### 7. Ошибка 404 - ресурс не найден

![Ресурс не найден](images/7.%20Ресурс%20не%20найден.png)

---


