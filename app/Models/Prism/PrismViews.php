<?php
namespace App\Models\Prism;
use Illuminate\Database\Eloquent\Model;
use DB;
use PDO;

class PrismViews extends Model{

    public static function getOfficialK12List($term_id){
        $query = "Select (select ISNULL(firstname,'') as firstname from ES_Students where studentno=reg.studentno) as firstname,
            (select middleinitial from ES_Students where studentno=reg.studentno) as middleinitial,
            (select lastname from ES_Students where studentno=reg.studentno) as lastname,
            (select extname from ES_Students where studentno=reg.studentno) as extname,
	    ISNULL(dbo.fn_ProgramName(reg.ProgID),'Unknown') as SectionName,
            dbo.fn_StudentYearLevel_k12(reg.studentno) as GradeLevel,
            reg.studentno as StudentNo
        from ES_registrations as reg
        where termid={$term_id}
		and validationdate is not null
        and iswithdrawal=0";
        
        $data = array();
        try {
            $data = DB::connection('sqlsrv')->select($query);
        } 
        catch (\Exception $e) {}
        // $data = array();
        return $data;
    }

    public static function getTermList(){
        $query = "SELECT top 20 TermID,(AcademicYear+' '+SchoolTerm) as AcadTerm from dbo.ES_AYTerm where SchoolTerm in ('School Year') order by StartofAY desc";

        $data = array();
        try {
            $data = DB::connection('sqlsrv')->select($query);
        } 
        catch (\Exception $e) {}

        return $data;
    }

    public static function getSemList(){
        $query = "SELECT top 20 TermID,(AcademicYear+' '+SchoolTerm) as AcadTerm from dbo.ES_AYTerm where SchoolTerm not in ('School Year') order by StartofAY desc";

        $data = array();
        try {
            $data = DB::connection('sqlsrv')->select($query);
        } 
        catch (\Exception $e) {}
        return $data;
    }
}
