<?php

namespace App\Models;

use App\Enums\PurchaseStatus;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    public $timestamps = true;

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'supplier_id',
        'date',
        'purchase_no',
        'status',
        'total_amount',
        'created_by',
        'updated_by',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => PurchaseStatus::class
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    public function scopeSearch($query, $value): void
    {
        $query->where('purchase_no', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%");
    }

    /**
     * Get the user that owns the Category
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
