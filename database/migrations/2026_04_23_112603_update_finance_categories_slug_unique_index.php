<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('finance_categories', function (Blueprint $table) {
            // 1. Drop the old global unique index
            $table->dropUnique('finance_categories_slug_unique');
            
            // 2. Create a new composite unique index (slug + company_id)
            $table->unique(['slug', 'company_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finance_categories', function (Blueprint $table) {
            $table->dropUnique(['slug', 'company_id']);
            $table->unique('slug');
        });
    }
};
