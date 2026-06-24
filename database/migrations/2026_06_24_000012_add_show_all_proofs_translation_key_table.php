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
            'group_name' => 'product',
            'key' => 'show_all_proofs',
            'value' => 'Show all proofs in all languages',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('translations')->where('key', 'show_all_proofs')->delete();
    }
};
