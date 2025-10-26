<?php

namespace App\Filament\Resources\CashMovements\Tables;

use App\Filament\Resources\CashMovements\CashMovementResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

class CashMovementsTable
{
    public static function configure(Table $table): Table
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $isAdmin = $user->isAdmin();


        return $table
            ->columns([

                TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchableAndSortable()
                    ->visible($isAdmin),

                TextColumn::make('date')
                    ->label(__('Date'))
                    ->dateTime()
                    ->since()
                    ->dateTooltip()
                    ->searchableAndSortable(),

                TextColumn::make('category.name')
                    ->label(__('Category'))
                    ->searchableAndSortable(),

                TextColumn::make('type')
                    ->label(__('Type'))
                    ->formatStateUsing(fn(string $state): string => __($state))
                    ->searchableAndSortable(),

                TextColumn::make('amount')
                    ->label(__('Amount'))
                    ->money('COP', decimalPlaces: 0)
                    ->searchableAndSortable(),

                TextColumn::make('title')
                    ->label(__('Title'))
                    ->limit(20)
                    ->searchableAndSortable(),

                TextColumn::make('parent.title')
                    ->label(__('Parent'))
                    ->searchableAndSortable()
                    ->searchable(),

                IconColumn::make('is_recurrent')
                    ->label(__('Is Recurrent'))
                    ->searchableAndSortable()
                    ->boolean(),

                TextColumn::make('recurrent_period')
                    ->label(__('Recurrent Period'))
                    ->formatStateUsing(fn(string $state): string => __($state))
                    ->searchableAndSortable(),

                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->since()
                    ->dateTooltip()
                    ->searchableAndSortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->since()
                    ->dateTooltip()
                    ->searchableAndSortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\ActionGroup::make([
                    ViewAction::make()->url(fn($record) => CashMovementResource::getUrl('view', ['record' => $record]))->label(__('View')),
                    EditAction::make()->label(__('Edit')),
                    \Filament\Actions\DeleteAction::make()->label(__('Delete')),
                    \Filament\Actions\RestoreAction::make()->label(__('Restore')),
                    \Filament\Actions\ForceDeleteAction::make()->label(__('Force Delete')),
                ]),
            ], position: \Filament\Tables\Enums\RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                // Acciones masivas agrupadas: eliminar, forzar eliminación,
                // restaurar. Se usan las implementaciones nativas de Filament.
                BulkActionGroup::make([
                    DeleteBulkAction::make(),

                ]),
            ]);
    }
}
