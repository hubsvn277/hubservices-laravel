<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'packages';

    public function company()
    {
        return $this->hasMany('App\Company',"package_id")->orderBy('id','desc');
    }
	
}