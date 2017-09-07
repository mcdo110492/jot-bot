<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemTypePrice extends Model
{
    protected $table = 'itemPrice';

    protected $primaryKey = 'itemPriceId';

    protected $fillable = [
        'itemTypeId',
        'itemPrice'
    ];
}
