<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['description', 'image_path', 'company_url']);
        });

        Schema::table('product_translations', function (Blueprint $table) {
            $table->string('company_url')->nullable()->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('product_translations', function (Blueprint $table) {
            $table->dropColumn('company_url');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->string('company_url')->nullable();
        });
    }
};
