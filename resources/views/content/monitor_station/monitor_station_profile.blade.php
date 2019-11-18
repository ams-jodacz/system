<!-- BEGIN PORTLET-->
<div class="card">
    <div class="card-body">
        <h2 class="text-center">In Nodes</h2>
        <div class="row">
            @foreach($in_stations as $station)
                <div class="col-md-{{$in_span}} text-center">
                    <h3>{{$station->name}}</h3>
                    <img class="img-responsive center-block" id="station_{{$station->station_id}}" src="{{URL::to('/')}}/images/gender.jpg" width="300 " />
                    
                    <h5 id="station_number_{{$station->station_id}}">
                        <strong>ID Number</strong>
                    </h5>
          
                    <h5 id="station_name_{{$station->station_id}}">
                        <strong>Name</strong>
                    </h5>
                   
                    <h5 id="station_time_{{$station->station_id}}">
                        <strong>Date Time</strong>
                    </h5>
                </div>
            @endforeach
        </div>

        <div class="row">
            <h2 class="text-center">In Nodes</h2>
            @foreach($out_stations as $station)
                <div class="col-md-{{$out_span}} text-center">
                    <h3>{{$station->name}}</h3>

                    <img lass="img-responsive center-block" id="station_{{$station->station_id}}" src="{{URL::to('/')}}/images/gender.jpg" width="300 " />
                    
                    <h5 id="station_number_{{$station->station_id}}">
                        <strong>ID Number</strong>
                    </h5>
                    
                    <h5 id="station_name_{{$station->station_id}}">
                        <strong>Name</strong>
                    </h5>
                
                    <h5 id="station_time_{{$station->station_id}}">
                        <strong>Date Time</strong>
                    </h5>                                   
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- END PORTLET-->
