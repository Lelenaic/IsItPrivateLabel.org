<?php

namespace App\Filament\Resources\Products\RelationManagers;

use App\Models\Language;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProofsRelationManager extends RelationManager
{
    protected static string $relationship = 'proofs';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components($this->getProofFormComponents());
    }

    /**
     * @return array<int, Component>
     */
    private function getProofFormComponents(): array
    {
        return [
            Select::make('type')
                ->options([
                    'text' => 'Text',
                    'link' => 'Link',
                    'image' => 'Image',
                ])
                ->live()
                ->afterStateUpdated(fn (Select $component) => $component
                    ->getContainer()
                    ->getComponent('contentFields')
                    ->getChildSchema()
                    ->fill())
                ->required(),
            Section::make()
                ->key('contentFields')
                ->schema(fn (Get $get): array => match ($get('type')) {
                    'text' => [
                        Textarea::make('content')
                            ->label('Content')
                            ->required()
                            ->columnSpanFull(),
                    ],
                    'link' => [
                        TextInput::make('content')
                            ->label('Content')
                            ->url()
                            ->required()
                            ->columnSpanFull(),
                    ],
                    'image' => [
                        FileUpload::make('content')
                            ->label('Content')
                            ->disk('public')
                            ->directory('proofs')
                            ->image()
                            ->imageEditor()
                            ->required()
                            ->columnSpanFull(),
                    ],
                    default => [],
                }),
            TextInput::make('description')
                ->default(null),
            Toggle::make('show_in_all_languages')
                ->default(true)
                ->live()
                ->afterStateUpdated(function (Toggle $component, Get $get, Set $set): void {
                    if ($get('show_in_all_languages')) {
                        $set('visible_language_ids', []);
                    }
                }),
            CheckboxList::make('visible_language_ids')
                ->relationship('visibleInLanguages', 'name')
                ->label('Visible in Languages')
                ->options(fn () => Language::active()->pluck('name', 'id'))
                ->hidden(fn (Get $get): bool => (bool) $get('show_in_all_languages'))
                ->columnSpanFull(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'text' => 'info',
                        'link' => 'success',
                        'image' => 'warning',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('content')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable(),
                IconColumn::make('show_in_all_languages')
                    ->boolean()
                    ->label('All Languages')
                    ->sortable(),
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
                    ->schema(fn (Schema $schema): Schema => $schema->components(
                        $this->getProofFormComponents(),
                    )),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make()
                    ->schema(fn (Schema $schema): Schema => $schema->components(
                        $this->getProofFormComponents(),
                    )),
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
