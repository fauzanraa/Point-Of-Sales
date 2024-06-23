<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberModel extends Model
{
    use HasFactory;

    protected $table = 'm_member';
    protected $primaryKey = 'member_id';

    protected $fillable = [
        'nama', 
        'ttl', 
        'alamat'
    ];
}
