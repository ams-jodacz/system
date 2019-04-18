<?php
namespace App\Models\Guests;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model{
    
    protected $table = 'guest_logs';
    
    public $timestamps = false;
    
    protected $primaryKey = 'id';

    protected $fillable = array('tag_id','users','contact_number','reason','items','borrow_date_time','return_date_time');
    
    protected $guarded = array('id');

//Joins
    //Classification Group Table
    public function tag()
    {
        return $this->belongsTo('App\Models\Guests\GuestTag','tag_id','tag_id');
    }

}
