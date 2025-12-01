<?php

namespace App\Filament\Resources\Forms;

use App\Filament\Resources\Forms\Pages\CreateForm;
use App\Filament\Resources\Forms\Pages\EditForm;
use App\Filament\Resources\Forms\Pages\FormResults;
use App\Filament\Resources\Forms\Pages\ListForms;
use App\Filament\Resources\Forms\Pages\ViewForm;
use App\Filament\Resources\Forms\Schemas\FormInfolist;
use App\Filament\Resources\Forms\Tables\FormsTable;
use App\Models\Form;
use BackedEnum;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class FormResource extends Resource
{
    protected static ?string $model = Form::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (! empty($state)) {
                            $set('slug', Str::slug($state));
                        }
                    }),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->hint('Auto-generated from title, but you can customize it'),

                Toggle::make('published')->label('Published'),

                Builder::make('schema')
                    ->label('Form Layout')
                    ->blocks([
                        Block::make('section')
                            ->schema([
                                TextInput::make('title')->label('Section Title')->required(),
                                Repeater::make('fields')
                                    ->label('Fields')
                                    ->schema([
                                        Select::make('type')
                                            ->label('Field Type')
                                            ->options([
                                                'text' => 'Text',
                                                'number' => 'Number',
                                                'textarea' => 'Long Text',
                                                'dropdown' => 'Dropdown',
                                                'checkbox' => 'Checkbox',
                                                'file' => 'File Upload',
                                                'date' => 'Date',
                                            ])
                                            ->required(),
                                        TextInput::make('label')->required()->label('Field Label'),
                                        TextInput::make('name')->label('Field name (optional)')->reactive()
                                            ->hint('If empty, a slug of label will be generated.'),
                                        TextInput::make('placeholder')->label('Placeholder / Hint'),
                                        Toggle::make('required')->label('Required')->default(false),
                                        Repeater::make('options')
                                            ->label('Options')
                                            ->columns(1)
                                            ->schema([
                                                TextInput::make('value')->label('Option value')->required(),
                                            ])
                                            ->visible(fn ($get) => $get('type') === 'dropdown')
                                            ->minItems(1),
                                    ])
                                    ->collapsible()
                                    ->itemLabel(fn ($state) => $state['label'] ?? 'Field'),
                            ])
                            ->label('Section'),
                    ])
                    ->collapsible()
                    ->columnSpanFull()
                    ->reorderableWithButtons(true),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FormInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FormsTable::configure($table);
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
            'index' => ListForms::route('/'),
            'create' => CreateForm::route('/create'),
            'view' => ViewForm::route('/{record}'),
            'edit' => EditForm::route('/{record}/edit'),
            'results' => FormResults::route('/{record}/results'),
        ];
    }
}
