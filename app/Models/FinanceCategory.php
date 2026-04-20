<?php

namespace App\Models;

use App\Enums\FinanceCategoryType;
use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinanceCategory extends Model
{
    use HasFactory, BelongsToCompany;

    protected $table = 'finance_categories';

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
    ];

    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
        'type' => FinanceCategoryType::class,
        'description' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(FinanceTransaction::class);
    }
}
