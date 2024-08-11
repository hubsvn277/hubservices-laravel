<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects';

    public function members(){
    	return $this->belongsToMany('App\User','project_members', 'project_id', 'user_id');
    }

    public function setCustomDomainAttribute($value) {
        if ( empty($value) ) { 
        $this->attributes['custom_domain'] = NULL;
        } else {
            $this->attributes['custom_domain'] = $value;
        }
    }
    
     public function setSubDomainAttribute($value) {
        if ( empty($value) ) { 
        $this->attributes['sub_domain'] = NULL;
        } else {
            $this->attributes['sub_domain'] = $value;
        }
    }
}