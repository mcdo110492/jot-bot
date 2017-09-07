<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{

    protected $table = 'itemType';

    protected $primaryKey = 'itemTypeId';
    
    protected $fillable = [
        'itemName'
    ];
}
