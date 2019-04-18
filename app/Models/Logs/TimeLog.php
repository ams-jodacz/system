<?php
namespace App\Models\Logs;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model{
    
    protected $table = 'time_logs';
    
    public $timestamps = false;
    
    // protected $primaryKey = 'id';

    protected $fillable = array('station_id','id_number','date_time');
    
    // protected $guarded = array('id');

//Joins
    //Member Table
    public function member()
    {
        return $this->belongsTo('App\Models\Members\Member', 'id_number', 'id_number');
    }

    //Guest Table
    public function guest()
    {
        return $this->belongsTo('App\Models\Guests\GuestTag', 'id_number', 'id_number');
    }

    //Station Table
    public function station()
    {
        return $this->belongsTo('App\Models\Stations\Station', 'station_id', 'station_id');
    }
}
