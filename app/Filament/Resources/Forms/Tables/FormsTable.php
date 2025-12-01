<?php

namespace App\Filament\Resources\Forms\Tables;

use App\Filament\Resources\Forms\FormResource;
use App\Models\Form;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class FormsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->description(fn (Form $record) => 'Form link: '.config('app.url').'/form/'.$record->slug)
                    ->url(fn (Form $record) => config('app.url').'/form/'.$record->slug)
                    ->openUrlInNewTab()  
                    ->sortable()
                    ->searchable(),

                ToggleColumn::make('published')
                    ->label('Published')
                    ->onColor('success')
                    ->offColor('danger'),
                TextColumn::make('tenant.name')
                    ->label('Team')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->toggleable(true)
                    ->dateTime()
                    ->sortable(),

            ])

            ->filters([

            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('results')
                    ->label('Results')
                    ->url(fn (Form $record): string => FormResource::getUrl('results', ['record' => $record])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
