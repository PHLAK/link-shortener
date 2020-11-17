<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Redirect extends Model
{
    use HasFactory;

    /** The attributes that are mass assignable. */
    protected $fillable = ['ip_address', 'user_agent'];

    /** Get the link the redirect belongs to. */
    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }
}
