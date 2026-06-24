<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $languageId = DB::table('languages')->where('code', 'en')->value('id');

        $translations = [
            ['group_name' => 'product_card', 'key' => 'translation_unavailable', 'value' => 'Not available in your language'],
            ['group_name' => 'product', 'key' => 'translation_unavailable_notice', 'value' => 'This product is not available in your language. Showing content in :language.'],
            ['group_name' => 'product', 'key' => 'translation_showing_default', 'value' => 'Showing default language content'],
            ['group_name' => 'pricing', 'key' => 'resale_price', 'value' => 'Resale Price'],
            ['group_name' => 'pricing', 'key' => 'source_price', 'value' => 'Source Price'],
            ['group_name' => 'pricing', 'key' => 'comment', 'value' => 'Comment'],
        ];

        foreach ($translations as &$translation) {
            $translation['language_id'] = $languageId;
            $translation['created_at'] = now();
            $translation['updated_at'] = now();
        }

        DB::table('translations')->insert($translations);
    }

    public function down(): void
    {
        DB::table('translations')->whereIn('key', [
            'translation_unavailable',
            'translation_unavailable_notice',
            'translation_showing_default',
            'resale_price',
            'source_price',
            'comment',
        ])->delete();
    }
};
