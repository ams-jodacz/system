<?php
namespace App\Models\Guests;
use Illuminate\Database\Eloquent\Model;

class GuestTag extends Model{
    
    protected $table = 'guest_tags';
    
    public $timestamps = false;
    
    protected $primaryKey = 'tag_id';

    protected $fillable = array('guest_group_id','id_number','tag','tag_name');
    
    protected $guarded = array('tag_id');

//Joins
    //Group Group Table
    public function group()
    {
        return $this->belongsTo('App\Models\Guests\GuestGroup','guest_group_id','guest_group_id');
    }

    //Guest Table
    public function guest()
    {
        return $this->hasMany('App\Models\Guests\Guest','tag_id','tag_id');
    }

}
