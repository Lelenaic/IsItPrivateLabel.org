<?php

namespace App\Filament\Resources\Translations\Pages;

use App\Filament\Resources\Translations\TranslationResource;
use App\Models\Language;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class EditTranslation extends Page
{
    protected static string $resource = TranslationResource::class;

    public function getHeading(): string
    {
        return 'Edit Translation';
    }

    public array $data = [];

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function mount(string $record): void
    {
        $languages = Language::active()->get();

        $parts = explode('|', $record, 2);
        $groupName = $parts[0] ?? '';
        $key = $parts[1] ?? '';

        $translation = DB::table('translations')
            ->where('group_name', $groupName)
            ->where('key', $key)
            ->first();

        if (! $translation) {
            abort(404);
        }

        $values = [];
        foreach ($languages as $lang) {
            $existing = DB::table('translations')
                ->where('group_name', $translation->group_name)
                ->where('key', $translation->key)
                ->where('language_id', $lang->id)
                ->first();

            $values[$lang->code] = $existing?->value ?? '';
        }

        $this->data = [
            'groupName' => $translation->group_name,
            'key' => $translation->key,
            'values' => $values,
        ];
    }

    public function content(Schema $schema): Schema
    {
        $languages = Language::active()->get();

        return $schema
            ->statePath('data')
            ->components([
                Section::make('Translation Key')
                    ->schema([
                        TextInput::make('groupName')
                            ->label('Group')
                            ->disabled(),
                        TextInput::make('key')
                            ->label('Key')
                            ->disabled(),
                    ])
                    ->columns(2),
                Section::make('Values')
                    ->schema(
                        $languages->map(
                            fn (Language $lang) => Textarea::make("values.{$lang->code}")
                                ->label("{$lang->name} value ({$lang->code})")
                                ->rows(3),
                        )->toArray(),
                    ),
                Section::make()
                    ->schema([
                        Action::make('save')
                            ->label('Save changes')
                            ->action(fn () => $this->save())
                            ->color('primary'),
                        Action::make('cancel')
                            ->label('Cancel')
                            ->url(fn () => static::$resource::getUrl('index'))
                            ->color('gray'),
                    ]),
            ]);
    }

    public function save(): void
    {
        $languages = Language::active()->get();
        $groupName = $this->data['groupName'];
        $key = $this->data['key'];

        foreach ($languages as $lang) {
            $value = $this->data['values'][$lang->code] ?? '';

            DB::table('translations')->updateOrInsert(
                [
                    'language_id' => $lang->id,
                    'group_name' => $groupName,
                    'key' => $key,
                ],
                [
                    'value' => $value,
                    'updated_at' => now(),
                    'created_at' => now(),
                ],
            );

            Cache::forget("translations.{$lang->code}");
        }

        $this->dispatch('saved');
    }
}
