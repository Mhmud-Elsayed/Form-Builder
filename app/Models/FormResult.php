<?php

namespace App\Models;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class FormResult extends Model
{
    //
    use Tenantable;

    protected $fillable = [
        'tenant_id',
        'form_id',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
