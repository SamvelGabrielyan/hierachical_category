<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed name
 * @property mixed parent_id
 */
class Category extends Model
{
    public function children(){

        return $this->hasMany('App\Category', 'parent_id');

    }
}
