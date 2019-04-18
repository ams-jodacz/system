<?php
namespace App\Models\Stations;
use Illuminate\Database\Eloquent\Model;

class StationGroup extends Model{
    
    protected $table = 'station_group';
    
    public $timestamps = false;
    
    protected $primaryKey = 'station_group_id';	

    protected $fillable = array('group_name');
    
    protected $guarded = array('station_group_id');

//JOINS
    //Stations Table
    public function station()
    {
        return $this->hasMany('App\Models\Stations\Station', 'station_group_id', 'station_group_id');
    }

    //Station Access
    public function stationAccess(){
        return $this->hasMany('App\Models\Access\StationAccess', 'station_group_id', 'station_group_id');
    }

    //Guest Access
    public function guestAccess(){
        return $this->hasMany('App\Models\Guests\GuestAccess', 'station_group_id', 'station_group_id');
    }
}
