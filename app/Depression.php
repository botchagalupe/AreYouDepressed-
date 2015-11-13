<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depression extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'depressions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['is_depressed', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
