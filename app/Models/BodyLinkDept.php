<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BodyLinkDept extends Model
{
    protected $table = 'body_link_dept';
    protected $fillable = [
        'id', 'bodypart_id', 'dept_id',
    ]; 
}