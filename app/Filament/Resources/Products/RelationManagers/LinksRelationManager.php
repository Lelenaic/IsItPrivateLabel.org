<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LinksRelationManager extends RelationManager
{
    protected static string $relationship = 'links';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('url')
                    ->required()
                    ->url()
                    ->maxLength(255),
                Select::make('platform')
                    ->options([
                        'aliexpress' => 'AliExpress',
                        'made-in-china' => 'Made in China',
                        'alibaba' => 'Alibaba',
                        'company' => 'Company Website',
                        'other' => 'Other',
                    ])
                    ->default('other'),
                TextInput::make('label')
                    ->default(null),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('url')
            ->columns([
                TextColumn::make('url')
                    ->url(fn (?string $state): ?string => Str::sanitizeUrl($state))
                    ->openUrlInNewTab()
                    ->searchable(),
                TextColumn::make('platform')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'aliexpress' => 'danger',
                        'made-in-china' => 'warning',
                        'alibaba' => 'success',
                        'company' => 'info',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('label')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->schema(fn (Schema $schema): Schema => $schema->components([
                        TextInput::make('url')
                            ->required()
                            ->url()
                            ->maxLength(255),
                        Select::make('platform')
                            ->options([
                                'aliexpress' => 'AliExpress',
                                'made-in-china' => 'Made in China',
                                'alibaba' => 'Alibaba',
                                'company' => 'Company Website',
                                'other' => 'Other',
                            ])
                            ->default('other'),
                        TextInput::make('label')
                            ->default(null),
                    ])),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make()
                    ->schema(fn (Schema $schema): Schema => $schema->components([
                        TextInput::make('url')
                            ->required()
                            ->url()
                            ->maxLength(255),
                        Select::make('platform')
                            ->options([
                                'aliexpress' => 'AliExpress',
                                'made-in-china' => 'Made in China',
                                'alibaba' => 'Alibaba',
                                'company' => 'Company Website',
                                'other' => 'Other',
                            ])
                            ->default('other'),
                        TextInput::make('label')
                            ->default(null),
                    ])),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
