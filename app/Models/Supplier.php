<?php

namespace App\Models;

use App\Enums\ColombianBanks;
use App\Enums\SupplierType;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    public $timestamps = true;

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'shop_name',
        'type',
        'photo',
        'account_holder',
        'account_number',
        'bank',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'type' => SupplierType::class,
        'bank' => ColombianBanks::class,
    ];

    public function pathAttachment(): string
    {
        return $this->photo ? "/images/suppliers/" . $this->photo : "/images/default/default_supplier.png";
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function scopeSearch($query, $value): void
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%")
            ->orWhere('phone', 'like', "%{$value}%")
            ->orWhere('shop_name', 'like', "%{$value}%")
            ->orWhere('type', 'like', "%{$value}%");
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
