<?php
namespace App\Models\SMS;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model{
    
    protected $table = 'holiday';
    
    public $timestamps = false;
    
    protected $primaryKey = 'holiday_id';

    protected $fillable = array('name','description','date');
    
    protected $guarded = array('holiday_id');
    
}
