<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
use App\Models\Category;
use Filament\Support\Icons\Heroicon;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Post Details')
                    ->description('Fill all the reuired fields')
                    ->icon(Heroicon::DocumentText)
                    ->schema([
                        Group::make([])
                            ->schema([
                                TextInput::make('title')->label('Title')->required()->rules('max:10|min:5' ),
                                TextInput::make('slug')->label('Slug')->required()->rules('max:10|min:5')
                                ->unique(ignoreRecord: true)
                                ->validationMessages([
                                    'slug.unique' => 'The slug must be unique.',
                                    'slug.max' => 'The slug must not exceed 10 characters.',
                                    'slug.min' => 'The slug must be at least 5 characters.',
                                ]),
                                Select::make('category_id')
                                    ->label('Category')
                                    ->options(Category::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->required(),
                                ColorPicker::make('color')->label('Color'),
                            ])->columns(2),

                        MarkdownEditor::make('body')->label('Body'), // or we can use RichEditor
                    ]),

                Group::make([
                    Section::make('Content')
                        ->icon(Heroicon::Camera)
                        ->schema([
                            FileUpload::make('image')
                                ->label('Image')
                                ->disk('public'),
                        ]),

                    Section::make('Meta')
                        ->icon(Heroicon::ChatBubbleBottomCenterText)
                        ->schema([
                            TagsInput::make('tags')->label('Tags'),
                            Checkbox::make('published')->label('Published'),
                            DatePicker::make('published_at')->label('Published At'),
                        ]),
                ])
                    ->columns(1)
                    ->extraAttributes([
                        'class' => 'space-y-6',
                    ])

            ])->columns(2);
    }
}
