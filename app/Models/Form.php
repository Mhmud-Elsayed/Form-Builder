<?php

namespace App\Models;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Form extends Model
{
    //
    use Tenantable;

    protected $fillable = [
        'tenant_id',
        'title',
        'slug',
        'schema',
        'published',
    ];

    protected $casts = [
        'schema' => 'array',
        'published' => 'boolean',
    ];

    public function results()
    {
        return $this->hasMany(FormResult::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ensure slug is set when creating
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });

        static::updating(function ($model) {
            // Update slug if title changed and slug is empty
            if ($model->isDirty('title') && empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });
    }
}
