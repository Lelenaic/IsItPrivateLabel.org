<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Slider;
use Filament\Forms\Components\Slider\Enums\PipsMode;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('company_id')
                    ->relationship('company', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('serial_number')
                    ->default(null)
                    ->maxLength(255),
                Slider::make('rating')
                    ->required()
                    ->range(minValue: 0, maxValue: 10)
                    ->step(1)
                    ->default(5)
                    ->decimalPlaces(0)
                    ->tooltips(RawJs::make('Math.round($value)'))
                    ->pips(PipsMode::Steps),
                Toggle::make('is_active')
                    ->default(true)
                    ->label('Active'),
            ]);
    }
}
