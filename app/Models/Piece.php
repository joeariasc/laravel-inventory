<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Piece extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    public $timestamps = true;

    protected $guarded = ['id'];

    public $fillable = [
        'user_id',
        'name',
        'code',
        'description',
        'material',
        'piece_image',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pathAttachment(): string
    {
        return "/images/pieces/" . $this->piece_image;
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
