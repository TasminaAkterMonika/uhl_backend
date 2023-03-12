<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Doctors extends Model
{
    protected $table = 'doctors';
    protected $fillable = [
        'id', 'doctor_id', 'doctor_name', 'degree', 'uhl_id', 'bmdc_id', 'dept_id'
    ]; 
}