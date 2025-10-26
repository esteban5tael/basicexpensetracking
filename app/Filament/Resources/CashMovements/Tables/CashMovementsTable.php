<?php

namespace App\Filament\Resources\CashMovements\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CashMovementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                    TextColumn::make('date')
                    ->dateTime()
                        ->since()
                        ->dateTooltip()
                        ->sortable(),

                TextColumn::make('category.name')
                    ->searchable(),

                TextColumn::make('parent.title')
                    ->searchable(),

                TextColumn::make('type')
                    ->searchable(),

                TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('description')
                    ->searchable(),


                IconColumn::make('is_recurrent')
                    ->boolean(),

                TextColumn::make('recurrent_period')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                        ->since()
                        ->dateTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                        ->since()
                        ->dateTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),

                EditAction::make(),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),

                ]),

            ]);
    }
}
