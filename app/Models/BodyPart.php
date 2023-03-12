<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BodyPart extends Model
{
    protected $table = 'body_part';
    protected $fillable = [
        'id', 'bodypart_name', 'gender', 'status',
    ]; 
}