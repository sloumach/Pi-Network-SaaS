<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverLetter extends Model
{
    use HasFactory;
    protected $table='coverletters';
    protected $fillable = [
        'user_id',
        'letter',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
