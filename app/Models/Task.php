<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'done',
    ];

    protected $with=['user'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'done_at' => 'datetime',
        'done' => 'boolean',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
