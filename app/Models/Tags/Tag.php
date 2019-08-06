<?php
namespace App\Models\Tags;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model{
    
    protected $table = 'tags';
    
    public $timestamps = false;
    
    protected $primaryKey = 'id';

    protected $fillable = array('id_number','tag');
    
    protected $guarded = array('id');

//Joins
    //Member Table
    public function member()
    {
        return $this->hasOne('App\Models\Members\Member', 'id_number', 'id_number');
    }
}
