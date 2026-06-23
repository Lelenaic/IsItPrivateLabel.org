<?php

namespace App\Filament\Resources\Translations\Pages;

use App\Filament\Resources\Translations\TranslationResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListTranslations extends ListRecords
{
    protected static string $resource = TranslationResource::class;

    public function getHeading(): string
    {
        return 'Translations';
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('Add translation')
                ->url(static::$resource::getUrl('create'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
