<?php
namespace App\Models\Prism;
use Illuminate\Database\Eloquent\Model;
use DB;
use PDO;

class PrismViews extends Model{

    public static function getOfficialK12List($term_id){
        $query = "Select (select firstname from ES_Students where studentno=reg.studentno) as firstname,
            (select middleinitial from ES_Students where studentno=reg.studentno) as middleinitial,
            (select lastname from ES_Students where studentno=reg.studentno) as lastname,
            (select extname from ES_Students where studentno=reg.studentno) as extname,
			(select SectionName from ES_classsections where SectionID=reg.ClasssectionID) as SectionName,
            dbo.fn_StudentYearLevel_k12(reg.studentno) as GradeLevel,
            reg.studentno as StudentNo
        from ES_registrations as reg
        where termid={$term_id}
		and validationdate is not null
		and iswithdrawal=0";

        $data = DB::connection('sqlsrv')->select($query);
        // $data = array();
        return $data;
    }

    public static function getTermList(){
        $query = "SELECT top 20 TermID,(AcademicYear+' '+SchoolTerm) as AcadTerm from dbo.ES_AYTerm where SchoolTerm in ('School Year') order by StartofAY desc";

        $data = DB::connection('sqlsrv')->select($query);
        // $data = array();
        return $data;
    }

    public static function getSemList(){
        $query = "SELECT top 20 TermID,(AcademicYear+' '+SchoolTerm) as AcadTerm from dbo.ES_AYTerm where SchoolTerm not in ('School Year') order by StartofAY desc";

        $data = DB::connection('sqlsrv')->select($query);
        // $data = array();
        return $data;
    }
}
