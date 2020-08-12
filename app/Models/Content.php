<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'content',
        'version',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'contentable_id',
        'contentable_type',
    ];

    public function contentable()
    {
        return $this->morphTo();
    }
}
