<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class Project extends Model
{
    

    protected $dates = [
        'created_at',
        'updated_at',
    ];


    protected $fillable = [
      
        'name',    
        'domain_type',
        'sub_domain',
        'custom_domain',
        'created_at',
        'updated_at',
    ];
    

    protected $casts = [
        'settings' => 'array',
        'domain_type' => 'boolean',
    ];
 
}
