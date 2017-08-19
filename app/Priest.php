<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priest extends Model
{
    protected $table  = 'tblpriests';
    protected $primaryKey = 'priest_id';

    protected $fillable = [
   		'priest_name',
   		'status',
    ];
}
