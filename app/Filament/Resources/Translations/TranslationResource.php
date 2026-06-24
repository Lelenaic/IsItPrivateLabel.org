<?php

namespace App\Filament\Resources\Translations;

use App\Filament\Resources\Translations\Pages\CreateTranslation;
use App\Filament\Resources\Translations\Pages\EditTranslation;
use App\Filament\Resources\Translations\Pages\ListTranslations;
use App\Models\Translation;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class TranslationResource extends Resource
{
    protected static ?string $model = Translation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLanguage;

    protected static string|UnitEnum|null $navigationGroup = 'Translations';

    protected static ?int $navigationSort = 10;

    public static function getRecordTitleAttribute(): string
    {
        return 'key';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group_name')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('key')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('value')
                    ->limit(60)
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('group_name')
            ->recordUrl(fn ($record) => static::getUrl('edit', ['record' => $record->group_name.'|'.$record->key]))
            ->filters([
                SelectFilter::make('group_name')
                    ->label('Group')
                    ->options(fn () => DB::table('translations')->distinct()->pluck('group_name', 'group_name')),
                SelectFilter::make('language_id')
                    ->label('Language')
                    ->relationship('language', 'name'),
            ])
            ->recordActions([
                EditAction::make()
                    ->url(fn ($record) => static::getUrl('edit', ['record' => $record->group_name.'|'.$record->key])),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTranslations::route('/'),
            'create' => CreateTranslation::route('/create'),
            'edit' => EditTranslation::route('/{record}/edit'),
        ];
    }
}
