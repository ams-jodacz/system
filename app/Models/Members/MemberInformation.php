<?php
namespace App\Models\Members;
use Illuminate\Database\Eloquent\Model;

class MemberInformation extends Model{
    
    protected $table = 'member_information';
    
    public $timestamps = false;
    
    protected $primaryKey = 'member_info_id';

    protected $fillable = array('member_id','first_name','middle_name','last_name','contact_number','email','image');
    
    protected $guarded = array('member_info_id');

//Joins
    //Classification Group Table
    public function member()
    {
        return $this->belongsTo('App\Models\Members\Member','member_id','member_id');
    }
}
