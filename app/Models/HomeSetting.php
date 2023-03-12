<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HomeSetting extends Model
{
    protected $table = 'home_setting';
    protected $fillable = [
        'id', 'banner_image', 'banner_text', 'coe_id', 'department_id'
    ]; 
}