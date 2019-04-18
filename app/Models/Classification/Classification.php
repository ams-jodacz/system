<?php
namespace App\Models\Classification;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model{
    
    protected $table = 'classification';
    
    public $timestamps = false;
    
    protected $primaryKey = 'class_id';	

    protected $fillable = array('classification_name');
    
    protected $guarded = array('class_id');

//Joins
    //Classification Group Table
    public function group()
    {
        return $this->hasMany('App\Models\Classification\ClassificationGroup', 'class_id', 'class_id');
    }
}
