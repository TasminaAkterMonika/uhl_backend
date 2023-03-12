<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Errorlogs extends Model
{   
    protected $table = 'errorlog';

    protected $fillable = [
        'error_message', 'line_number', 'file_name', 'browser', 'operating_system', 'loggedin_id', 'ip_address'
    ];

    protected $hidden = [
        
    ]; 

    

}
