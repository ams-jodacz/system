<?php
namespace App\Models\SMS;
use Illuminate\Database\Eloquent\Model;

class BlastOccurance extends Model{
    
    protected $table = 'sms_blast_occurance';
    
    public $timestamps = false;
    
    protected $primaryKey = 'sms_blast_occurance_id';

    protected $fillable = array('sms_blast_id','minute','hour','day_of_month','month','day_of_week');
    
    protected $guarded = array('sms_blast_occurance_id');

//Joins
    public function blast()
    {
        return $this->belongsTo('App\Models\SMS\Blast','sms_blast_id','sms_blast_id');
    }

}
