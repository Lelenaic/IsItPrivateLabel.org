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

class CreateTranslation extends Page
{
    protected static string $resource = TranslationResource::class;

    public function getHeading(): string
    {
        return 'Create Translation';
    }

    public array $data = [];

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function mount(): void
    {
        $languages = Language::active()->get();

        $values = [];
        foreach ($languages as $lang) {
            $values[$lang->code] = '';
        }

        $this->data = [
            'groupName' => '',
            'key' => '',
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
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. home, layout, product...'),
                        TextInput::make('key')
                            ->label('Key')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. title, subtitle, nav.home...'),
                    ])
                    ->columns(2),
                Section::make('Values')
                    ->schema(
                        $languages->map(
                            fn (Language $lang) => Textarea::make("values.{$lang->code}")
                                ->label("{$lang->name} value ({$lang->code})")
                                ->rows(3)
                                ->placeholder("Translation for {$lang->name}..."),
                        )->toArray(),
                    ),
                Section::make()
                    ->schema([
                        Action::make('create')
                            ->label('Create translation')
                            ->action(fn () => $this->create())
                            ->color('primary'),
                        Action::make('cancel')
                            ->label('Cancel')
                            ->url(fn () => static::$resource::getUrl('index'))
                            ->color('gray'),
                    ]),
            ]);
    }

    public function create(): void
    {
        $this->validate([
            'data.groupName' => ['required', 'string', 'max:255'],
            'data.key' => ['required', 'string', 'max:255'],
        ]);

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

        $this->redirect(static::$resource::getUrl('index'));
    }
}
