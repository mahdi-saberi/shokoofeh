<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'model_name',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /**
     * User relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the model that was affected
     */
    public function model()
    {
        return $this->morphTo(__FUNCTION__, 'model_type', 'model_id');
    }

    /**
     * Get action display name
     */
    public function getActionDisplayAttribute(): string
    {
        return match($this->action) {
            'create' => 'ایجاد',
            'update' => 'ویرایش',
            'delete' => 'حذف',
            'login' => 'ورود',
            'logout' => 'خروج',
            default => $this->action
        };
    }

    /**
     * Get model display name
     */
    public function getModelDisplayAttribute(): string
    {
        return match($this->model_type) {
            'App\Models\Product' => 'محصول',
            'App\Models\User' => 'کاربر',
            'App\Models\AgeGroup' => 'گروه سنی',
            'App\Models\GameType' => 'نوع بازی',
            'App\Models\Category' => 'دسته‌بندی',
            default => class_basename($this->model_type)
        };
    }

    /**
     * Create activity log
     */
    public static function createLog(string $action, Model $model, $oldValues = null, $newValues = null): void
    {
        if (!Auth::check()) {
            return;
        }

        $modelName = $model->title ?? $model->name ?? $model->email ?? "#{$model->id}";

        self::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'model_name' => $modelName,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
