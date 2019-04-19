<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet box blue-hoki" style="margin-bottom:0px">
            <div class="portlet-title">
                <div class="caption">
                    Station List
                </div>
            </div>
            <div class="portlet-body">
                <h3 class="form-section">In Nodes</h3>
                <div class="row">
                    @foreach($in_stations as $station)
                        <div class="col-md-{{$in_span}}">
                            <div class="form-group">
                                <center>
                                    <h4><label class="control-label">{{$station->name}}</label></h4>
                                    <img id="station_{{$station->station_id}}" src="{{URL::to('/')}}/images/avatar.png" height="200" width="200"/>
                                    <br/>
                                    <label id="station_number_{{$station->station_id}}">ID Number</label>
                                    <br/>
                                    <label id="station_name_{{$station->station_id}}">Name</label>
                                    <br/>
                                    <label id="station_time_{{$station->station_id}}">Date Time</label>
                                </center>
                            </div>
                        </div>
                    @endforeach
                </div>
                <h3 class="form-section">Out Nodes</h3>
                <div class="row">
                    @foreach($out_stations as $station)
                        <div class="col-md-{{$out_span}}">
                            <div class="form-group">
                                <center>
                                    <h4><label class="control-label">{{$station->name}}</label></h4>
                                    <img id="station_{{$station->station_id}}" src="{{URL::to('/')}}/images/avatar.png" height="200" width="200"/>
                                    <br/>
                                    <label id="station_number_{{$station->station_id}}">ID Number</label>
                                    <br/>
                                    <label id="station_name_{{$station->station_id}}">Name</label>
                                    <br/>
                                    <label id="station_time_{{$station->station_id}}">Date Time</label>
                                </center>                                    
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
