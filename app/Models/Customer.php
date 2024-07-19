<?php

namespace App\Models;

use App\Enums\ColombianBanks;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
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
        'photo',
        'account_holder',
        'account_number',
        'bank',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'bank' => ColombianBanks::class,
    ];

    public function pathAttachment(): string
    {
        return $this->photo ? "/images/customers/" . $this->photo : "/images/default/default_customer.png";
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function quotations(): HasMany
    {
        return $this->HasMany(Quotation::class);
    }

    public function scopeSearch($query, $value): void
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%")
            ->orWhere('phone', 'like', "%{$value}%");
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
