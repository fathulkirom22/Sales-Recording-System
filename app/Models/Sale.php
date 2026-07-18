<?php

namespace App\Models;

use App\Enums\SaleStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'user_id',
        'status',
        'total_amount',
        'sale_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'status' => SaleStatus::class,
            'total_amount' => 'decimal:2',
            'sale_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function getPaidAmountAttribute(): string
    {
        return (string) $this->payments()->sum('amount');
    }

    public function getRemainingAmountAttribute(): string
    {
        return bcsub((string) $this->total_amount, $this->paid_amount, 2);
    }

    public function isEditable(): bool
    {
        return $this->status->isEditable();
    }

    public function recalculateStatus(): void
    {
        $paid = $this->paid_amount;
        $total = (string) $this->total_amount;

        if (bccomp($paid, '0', 2) === 0) {
            $this->status = SaleStatus::Unpaid;
        } elseif (bccomp($paid, $total, 2) >= 0) {
            $this->status = SaleStatus::Paid;
        } else {
            $this->status = SaleStatus::PartiallyPaid;
        }

        $this->save();
    }
}
