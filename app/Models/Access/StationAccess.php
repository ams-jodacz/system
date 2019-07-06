<?php
namespace App\Models\Access;
use Illuminate\Database\Eloquent\Model;

class StationAccess extends Model{
    
    protected $table = 'station_access';
    
    public $timestamps = false;

    protected $primaryKey = 'access_id';

    protected $fillable = array('class_group_id','station_group_id');

    protected $guarded = array('access_id');

//JOINS
    //Classification Group Table
    public function classificationGroup()
    {
        return $this->belongsTo('App\Models\Classification\ClassificationGroup','class_group_id','class_group_id');
    }

    //Station Table
    public function station()
    {
        return $this->belongsTo('App\Models\Stations\StationGroup','station_group_id','station_group_id');
    }
}
