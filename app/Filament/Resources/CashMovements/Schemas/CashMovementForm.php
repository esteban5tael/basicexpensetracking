<?php

namespace App\Filament\Resources\CashMovements\Schemas;

use App\Enums\CashMovementRecurrentPeriod;
use App\Enums\CashMovementType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class CashMovementForm
{
    public static function configure(Schema $schema): Schema
    {
        $userId = Auth::id();
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default($userId),

                Grid::make()
                    ->columns(2)
                    ->columnSpanFull()

                    ->schema([

                        Section::make()
                            ->heading(__('Category and Type'))
                            ->icon(Heroicon::OutlinedTag)
                            ->schema([
                                Select::make('category_id')
                                    ->label(__('Category'))
                                    ->preload()->searchable()
                                    ->relationship('category', 'name'),

                                ToggleButtons::make('type')

                                    ->options(
                                        array_combine(
                                            CashMovementType::values(),
                                            array_map(fn($value) => __($value), CashMovementType::values())
                                        )
                                    )
                                    ->required()
                                    ->grouped()
                                    ->label(__('Movement Type')),

                            ]),

                        Section::make()
                            ->heading(__('Financial Details'))
                            ->icon(Heroicon::OutlinedCurrencyDollar)
                            ->schema([

                                TextInput::make('amount')
                                    ->label(__('Amount'))
                                    ->required()
                                    ->numeric(),

                                TextInput::make('title')
                                    ->label(__('Title'))
                                    ->required(),
                            ]),

                    ])->columnSpanFull(),
                Grid::make()
                    ->columns(2)
                    ->columnSpanFull()

                    ->schema([
                        Section::make()
                            ->heading(__('Additional Information'))
                            ->icon(Heroicon::OutlinedDocumentText)
                            ->schema([


                                Textarea::make('description')
                                    ->label(__('Description')),

                                DatePicker::make('date')
                                    ->label(__('Date'))
                                    ->required(),

                            ]),

                        Section::make()
                            ->heading(__('Recurrence Settings'))
                            ->icon(Heroicon::OutlinedClock)
                            ->schema([


                                Toggle::make('is_recurrent')
                                    ->label(__('Is Recurrent'))
                                    ->live()
                                    ->required(),


                                Select::make('recurrent_period')
                                    ->preload()->searchable()
                                    ->options(
                                        array_combine(
                                            CashMovementRecurrentPeriod::values(),
                                            array_map(fn($value) => __($value), CashMovementRecurrentPeriod::values())
                                        )
                                    )
                                    ->nullable()
                                    ->visible(fn(Get $get) => $get('is_recurrent'))
                                    ->label(__('Recurrent Period')),
                            ])->columns(1),

                    ])->columnSpanFull(),
            ]);
    }
}
