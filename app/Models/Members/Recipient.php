<?php
namespace App\Models\Members;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model{
    
    protected $table = 'recipients';
    
    public $timestamps = false;
    
    protected $primaryKey = 'recipient_id';

    protected $fillable = array('member_id','first_name','middle_name','last_name','contact_number','email');
    
    protected $guarded = array('recipient_id');

//Joins
    //Classification Group Table
    public function member()
    {
        return $this->belongsTo('App\Models\Members\Member','member_id','member_id');
    }
}
