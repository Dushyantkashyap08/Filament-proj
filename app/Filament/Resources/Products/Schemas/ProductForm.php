<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Group;
use Filament\Actions\Action;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Product Info')
                        ->schema([
                            Group::make()
                                ->schema([
                                    TextInput::make('name')->label('Name')->required(),
                                    TextInput::make('sku')->label('SKU')->required(),
                                ])->columns(2),
                            MarkdownEditor::make('description')->label('Description'),
                        ]),
                    Step::make('Pricing and Stock')
                        ->schema([
                            TextInput::make('price')->label('Price')->numeric()->required(),
                            TextInput::make('stock')->label('Stock Quantity')->integer()->required(),
                        ]),
                    Step::make('Media and Status')
                        ->schema([
                            FileUpload::make('image')
                                ->disk('public')
                                ->directory('products')
                                ->label('Product Image'),
                            Toggle::make('is_active')->label('Active'),
                            Toggle::make('is_featured')->label('Featured'),
                        ]),
                ])->columnSpanFull()
                ->submitAction(
                    Action::make('Save Product')
                    ->label('Save Product')
                    ->button()
                    ->color('primary')
                    ->submit('save')
                )
            ]);
    }
}
