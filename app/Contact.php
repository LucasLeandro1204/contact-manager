<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        //
    ];

    /**
     * Contact notes.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
