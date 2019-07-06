<?php
namespace App\Models\ACL;
use Illuminate\Database\Eloquent\Model;

class Action extends Model{
    
    protected $table = 'tbl_action';
    
    public $timestamps = false;
    
    public static $View = 1;
    public static $Add = 2;
    public static $Edit = 4;
    public static $Delete = 8;
    public static $Approver = 16;
    public static $Verifier = 32;
    
    protected $primaryKey = 'action_id';	
    
    public static function getMaxAction(){
        return Action::sum('action_value');
    }
    
    public static function getActionList(){
        return array(
            Action::$View => 'View',
            Action::$Add => 'Add',
            Action::$Edit => 'Edit',
            Action::$Delete => 'Delete',
            Action::$Verifier => 'Verifier',
            Action::$Approver => 'Approver',
        );
    }
}
