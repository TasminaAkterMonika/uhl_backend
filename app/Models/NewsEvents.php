<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class NewsEvents extends Model
{
    protected $table = 'news_events';
    protected $fillable = [
        'id', 'news_events_title', 'news_events_desc', 'news_events_pic'
    ]; 
}