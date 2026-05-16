<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Staff extends Model
{
    protected $table = 'staff';
    protected $fillable = ['nip', 'name', 'gender', 'alamat', 'email', 'foto'];
}   