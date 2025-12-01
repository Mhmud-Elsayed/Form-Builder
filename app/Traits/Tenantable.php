<?php

namespace App\Traits;

use App\Models\Scopes\TenantScope;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait Tenantable
{
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public static function bootTenantable()
    {
        if (Auth::check() && Auth::user()->tenant_id) {
            static::addGlobalScope(new TenantScope);

            static::creating(function (Model $model) {

                $model['tenant_id'] = Auth::user()->tenant_id;

            });
        }
    }
}
