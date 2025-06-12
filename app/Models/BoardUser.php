<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BoardUser extends Pivot
{
    use HasFactory;

    protected $table = 'board_user';

    protected $fillable = [
        'board_id',
        'user_id',
        'role',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'board_id' => 'integer',
            'user_id' => 'integer',
        ];
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role')
            ->using(BoardUser::class);
    }

}
