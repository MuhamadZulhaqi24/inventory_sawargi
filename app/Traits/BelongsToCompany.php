<?php

namespace App\Traits;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait BelongsToCompany
{
    protected static function bootBelongsToCompany()
    {
        static::creating(function (Model $model) {
            if (auth()->check() && !auth()->user()->is_super_admin) {
                if (empty($model->company_id)) {
                    $model->company_id = auth()->user()->company_id;
                }
            }
        });

        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check()) {
                if (!auth()->user()->is_super_admin) {
                    $builder->where('company_id', auth()->user()->company_id);
                }
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
