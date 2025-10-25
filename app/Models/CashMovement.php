<?php

namespace App\Models;

use App\Enums\CashMovementRecurrentPeriod;
use App\Enums\CashMovementType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashMovement extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'category_id',
        'parent_id',
        'type',
        'amount',
        'title',
        'description',
        'date',
        'is_recurrent',
        'recurrent_period',

    ];

    protected $casts = [
        'type' => 'string',
        'amount' => 'decimal:2',
        'date' => 'date',
        'is_recurrent' => 'boolean',
        'recurrent_period' => 'string',
        'parent_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(CashMovement::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(CashMovement::class, 'parent_id');
    }



    public function scopeIsExpense($query)
    {
        return $query->where('type', CashMovementType::expense->value);
    }

    public function scopeIsIncome($query)
    {
        return $query->where('type', CashMovementType::income->value);
    }

    public function scopeIsRecurrent($query)
    {
        return $query->where('is_recurrent', true);
    }

    public function createRecurringChildren()
    {
        $period = $this->recurrent_period;
        $startDate = $this->date;
        $children = [];

        switch ($period) {
            case CashMovementRecurrentPeriod::daily->value:
                for ($i = 1; $i <= 364; $i++) {
                    $children[] = [
                        'user_id' => $this->user_id,
                        'category_id' => $this->category_id,
                        'type' => $this->type,
                        'amount' => $this->amount,
                        'title' => $this->title,
                        'description' => $this->description,
                        'date' => $startDate->copy()->addDays($i),
                        'is_recurrent' => false,
                        'parent_id' => $this->id,
                    ];
                }
                break;
            case CashMovementRecurrentPeriod::weekly->value:
                for ($i = 1; $i <= 51; $i++) {
                    $children[] = [
                        'user_id' => $this->user_id,
                        'category_id' => $this->category_id,
                        'type' => $this->type,
                        'amount' => $this->amount,
                        'title' => $this->title,
                        'description' => $this->description,
                        'date' => $startDate->copy()->addWeeks($i),
                        'is_recurrent' => false,
                        'parent_id' => $this->id,
                    ];
                }
                break;
            case CashMovementRecurrentPeriod::monthly->value:
                for ($i = 1; $i <= 11; $i++) {
                    $children[] = [
                        'user_id' => $this->user_id,
                        'category_id' => $this->category_id,
                        'type' => $this->type,
                        'amount' => $this->amount,
                        'title' => $this->title,
                        'description' => $this->description,
                        'date' => $startDate->copy()->addMonths($i),
                        'is_recurrent' => false,
                        'parent_id' => $this->id,
                    ];
                }
                break;
            case CashMovementRecurrentPeriod::yearly->value:
                for ($i = 1; $i <= 4; $i++) {
                    $children[] = [
                        'user_id' => $this->user_id,
                        'category_id' => $this->category_id,
                        'type' => $this->type,
                        'amount' => $this->amount,
                        'title' => $this->title,
                        'description' => $this->description,
                        'date' => $startDate->copy()->addYears($i),
                        'is_recurrent' => false,
                        'parent_id' => $this->id,
                    ];
                }
                break;
        }

        CashMovement::insert($children);
    }
}
