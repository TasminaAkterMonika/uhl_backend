<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Pre_Existing_Conditon extends Model
{
    protected $table = 'pre_existing_conditon';
    protected $fillable = [
        'id', 'name',
    ]; 
}