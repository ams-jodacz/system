<?php
namespace App\Models\Stations;
use Illuminate\Database\Eloquent\Model;

class Station extends Model{
    
    protected $table = 'stations';
    
    public $timestamps = false;
    
    protected $primaryKey = 'station_id';	

    protected $fillable = array('ip','name','description','status','station_group_id','enable_status','station_status','restart_status');
    
    protected $guarded = array('station_id');

//JOINS
    //Station Group Table
    public function stationGroup()
    {
        return $this->belongsTo('App\Models\Stations\StationGroup','station_group_id','station_group_id');
    }

    //Time Logs Table
    public function timeLogs()
    {
        return $this->hasMany('App\Models\Logs\TimeLog', 'station_id', 'station_id');
    }

    // //Station Access Table
    // public function access()
    // {
    //     return $this->hasMany('App\Models\Access\StationAccess', 'station_id', 'station_id');
    // }

    // //Guest Access Table
    // public function guestAccess()
    // {
    //     return $this->hasMany('App\Models\Guests\GuestAccess', 'station_id', 'station_id');
    // }
}
