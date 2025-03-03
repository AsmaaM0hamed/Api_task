<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'assigned_to',
        'parent_id',
        'created_by'
    ];


    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }


    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function subtasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function scopeFilterTasks($query, $request)
    {
        return $query->when($request->has('status'), function ($q) use ($request) {
                return $q->where('status', $request->status);
            })
            ->when($request->has('date_from') && $request->has('date_to'), function ($q) use ($request) {
                return $q->whereBetween('due_date', [$request->date_from, $request->date_to]);
            })
            ->when($request->has('date_from') && !$request->has('date_to'), function ($q) use ($request) {
                return $q->where('due_date', '>=', $request->date_from);
            })
            ->when(!$request->has('date_from') && $request->has('date_to'), function ($q) use ($request) {
                return $q->where('due_date', '<=', $request->date_to);
            })
            ->when($request->has('assigned_to'), function ($q) use ($request) {
                return $q->where('assigned_to', $request->assigned_to);
            });
    }
}
