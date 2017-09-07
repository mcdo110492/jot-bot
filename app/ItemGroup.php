<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemGroup extends Model
{
    protected $table = 'itemGroup';

    protected $primaryKey = 'itemGroupId';

    protected $fillable = [
        'itemPriceId',
        'groupId'
    ];
}
