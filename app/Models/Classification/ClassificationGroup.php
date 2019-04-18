<?php
namespace App\Models\Classification;
use Illuminate\Database\Eloquent\Model;

class ClassificationGroup extends Model{
    
    protected $table = 'classification_group';
    
    public $timestamps = false;
    
    protected $primaryKey = 'class_group_id';	

    protected $fillable = array('group_name','class_id');
    
    protected $guarded = array('class_group_id');

//Joins
    //Classification Table
    public function classification()
    {
        return $this->belongsTo('App\Models\Classification\Classification','class_id','class_id');
    }

    //Members Table
    public function member()
    {
        return $this->hasMany('App\Models\Members\Member', 'class_group_id', 'class_group_id');
    }

    //Station Access Table
    public function access()
    {
        return $this->hasMany('App\Models\Access\StationAccess', 'class_group_id', 'class_group_id');
    }
}
