<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $primaryKey = 'groupId';

    protected $fillable = [
        'groupName'
    ];
}
