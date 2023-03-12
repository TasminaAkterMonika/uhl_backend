<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class StaticPages extends Model
{
    protected $table = 'static_pages';
    protected $fillable = [
        'id', 'title','slug','description', 'image', 'status','is_deleted'
    ]; 
}