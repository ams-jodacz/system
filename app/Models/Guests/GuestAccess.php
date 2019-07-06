<?php
namespace App\Models\Guests;
use Illuminate\Database\Eloquent\Model;

class GuestAccess extends Model{
    
    protected $table = 'guest_station_access';
    
    public $timestamps = false;
    
    protected $primaryKey = 'access_id';

    protected $fillable = array('station_group_id','guest_group_id');
    
    protected $guarded = array('access_id');

//Joins
    //Guest Group Table
    public function guestGroup()
    {
        return $this->belongsTo('App\Models\Guests\GuestGroup','guest_group_id','guest_group_id');
    }

    //Station
    public function station()
    {
        return $this->belongsTo('App\Models\Stations\StationGroup','station_group_id','station_group_id');
    }

}
