<?php

namespace App\Filament\Resources\CashMovements\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CashMovementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name'),
                Select::make('category_id')
                    ->relationship('category', 'name'),
                Select::make('parent_id')
                    ->relationship('parent', 'title'),
                TextInput::make('type')
                    ->required()
                    ->default('expense'),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('description'),
                DatePicker::make('date')
                    ->required(),
                Toggle::make('is_recurrent')
                    ->required(),
                TextInput::make('recurrent_period'),
            ]);
    }
}
