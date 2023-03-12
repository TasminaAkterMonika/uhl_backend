<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Publications extends Model
{
    //protected $table = 'publications';
    protected $fillable = [
        'id', 'publications_title', 'publications_desc', 'publications_pic'
    ]; 
}