<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $languageId = DB::table('languages')->where('code', 'en')->value('id');

        DB::table('translations')->insert([
            'language_id' => $languageId,
            'group_name' => 'layout',
            'key' => 'nav.api',
            'value' => 'API',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('translations')->where('group_name', 'layout')->where('key', 'nav.api')->delete();
    }
};
