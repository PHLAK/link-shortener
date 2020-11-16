<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Link extends Model
{
    use HasFactory, SoftDeletes;

    /** The attributes that are mass assignable. */
    protected $fillable = ['slug', 'title', 'url'];

    /** The "booted" method of the model. */
    protected static function booted(): void
    {
        static::creating(function (Link $link): void {
            $link->slug = $link->slug ?? Str::random(6);
        });
    }

    /** Get the user that owns this link. */
    public function user(): BelongsTo
    {
        return $this->belongsto(User::class);
    }

    /** Increment this link's hit counter by one. */
    public function incrementHits(): void
    {
        ++$this->hits;
        $this->save();
    }
}
