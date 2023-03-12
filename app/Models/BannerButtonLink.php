<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BannerButtonLink extends Model
{
    protected $table = 'banner_button_link';
    protected $fillable = [
        'id', 'banner_button_icon_1', 'banner_button_icon_2', 'banner_button_icon_3', 'banner_button_icon_4', 'banner_button_icon_5', 'banner_button_icon_6', 'banner_button_icon_7', 'banner_button_icon_8', 'banner_button_text_1', 'banner_button_text_2', 'banner_button_text_3', 'banner_button_text_4', 'banner_button_text_5', 'banner_button_text_6', 'banner_button_text_7', 'banner_button_text_8', 'banner_button_link_1', 'banner_button_link_2', 'banner_button_link_3', 'banner_button_link_4', 'banner_button_link_5', 'banner_button_link_6', 'banner_button_link_7', 'banner_button_link_8'
    ]; 
}