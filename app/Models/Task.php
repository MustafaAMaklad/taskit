<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'main_task_id',
        'assignee_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => TaskStatus::class,
        ];
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function mainTask(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'main_task_id');
    }

    public function subTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'main_task_id');
    }

    #[Scope]
    protected function fromDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('due_date', '>=', Carbon::parse($date)->toDateString());
    }

    #[Scope]
    protected function toDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('due_date', '<=', Carbon::parse($date)->toDateString());
    }
}
