<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet box blue" style="margin-bottom:0px">
            <div class="portlet-title">
                <div class="caption">
                    Holiday Information
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>
                                <b>Name</b>
                            </td>
                            <td>
                                {{$holiday->name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Date</b>
                            </td>
                            <td>
                                {{Carbon\Carbon::createFromFormat('Y-m-d',$holiday->date)->format('M d')}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Description</b>
                            </td>
                            <td>
                                {{$holiday->description}} &nbsp;
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
