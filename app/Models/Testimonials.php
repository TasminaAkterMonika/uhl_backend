<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Testimonials extends Model
{
    protected $table = 'testimonials';
    protected $fillable = [
        'id', 'departmant_id', 'testimonial_name', 'testimonial_desc', 'author_name', 'author_profile_pic', 'rating'
    ]; 
}