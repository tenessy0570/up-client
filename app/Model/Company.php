<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model {
    use HasFactory;
    public $timestamps = false;
    protected $table = 'companies';
}