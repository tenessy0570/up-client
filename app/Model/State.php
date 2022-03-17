<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'states';
    protected $fillable = [
        'name',
        'division'
    ];
}