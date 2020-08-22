<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{

    protected $table = 'form_data';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Get the notes.
     */
    public function notes()
    {
        return $this->hasMany('App\Note');
    }
}
