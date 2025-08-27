<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель задачи (Task)
 * 
 * Представляет задачу в системе управления задачами.
 * Содержит основную информацию о задаче: название, описание и статус.
 * 
 * @property int $id Уникальный идентификатор задачи
 * @property string $title Название задачи
 * @property string|null $description Описание задачи (необязательно)
 * @property string $status Статус задачи (pending|in_progress|completed)
 * @property \Carbon\Carbon $created_at Дата и время создания
 * @property \Carbon\Carbon $updated_at Дата и время последнего обновления
 * 
 * @package App\Models
 */
class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * The available status options.
     *
     * @var array<string>
     */
    public const STATUS_OPTIONS = [
        'pending',
        'in_progress',
        'completed',
    ];
}
