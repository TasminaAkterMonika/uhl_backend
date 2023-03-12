<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Packages extends Model
{
    protected $table = 'packages';
    protected $fillable = [
        'id', 'name', 'description', 'image', 'amount', 'dept_id', 'gender','age','pre_existing_conditon','allergies','status'
    ]; 
}