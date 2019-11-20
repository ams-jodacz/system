<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
  <!--<![endif]-->
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{$school}}</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="{{URL::to('/')}}/assets/global/css/public.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap" rel="stylesheet">
  </head>
  <body class="body">
    <div id="particles-js"></div>
    <div class="container-fluid px-5 pb-5 pt-4">
        <h1 class="main-title">{{(isset($station_group) && isset($station_group->group_name))?$station_group->group_name:''}}</h1>
        <input type="hidden" id="station_group_id" value="{{(isset($station_group) && isset($station_group->station_group_id))?$station_group->station_group_id:0}}" />
      <div class="row">
          @foreach($out_stations as $station)
          <div class="col-md-12 px-5 py-4">
              <figure class="usercard">
                  <img src="{{URL::to('/')}}/images/sbu.png" class="usercard__logo img-fluid"/>
                  <div class="h-100 d-flex">
                  <div class="usercard__avatar station_{{$station->station_id}}" style="background-image: url('{{URL::to('/')}}/images/gender.jpg')"></div>
                  <figcaption class="usercard__description">
                      <div class="usercard__description-inner">
                      <h1 class="usercard__description-title">
                          <span class="text d-block station_name_{{$station->station_id}}">
                          </span>
                      </h1>
                      <h3 class="usercard__description-subtitle station_number_{{$station->station_id}}">
                      </h3>
                      <h5 class="usercard__description-label station_time_{{$station->station_id}}">
                      </h5>
                      </div>
                      <div class="usercard__footer exit">
                          {{$station->name}}
                      </div>
                  </figcaption>
                  </div>
              </figure>
          </div>
          @endforeach
      </div>
      <div class="row">
          @foreach($in_stations as $station)
              <div class="col-md-12 px-5 py-4">
                  <figure class="usercard">
                      <img src="{{URL::to('/')}}/images/sbu.png" class="usercard__logo img-fluid"/>
                      <div class="h-100 d-flex">
                      <div class="usercard__avatar station_{{$station->station_id}}" style="background-image: url('{{URL::to('/')}}/images/gender.jpg')"></div>
                      <figcaption class="usercard__description">
                          <div class="usercard__description-inner">
                          <h1 class="usercard__description-title">
                              <span class="text d-block station_name_{{$station->station_id}}">
                                  <!-- Maria Elisa A. Ramos -->
                              </span>
                          </h1>
                          <h3 class="usercard__description-subtitle station_number_{{$station->station_id}}">
                              <!-- SHS-201900236 -->
                          </h3>
                          <h5 class="usercard__description-label station_time_{{$station->station_id}}">
                              <!-- 09-27-19 11:01:38 am -->
                          </h5>
                          </div>
                          <div class="usercard__footer entrance">
                              {{$station->name}}
                          </div>
                      </figcaption>
                      </div>
                  </figure>
              </div>
          @endforeach
      </div>

        <div class="row">
            <div class="col-md-3 pl-5 pr-4 py-4">
              <figure class="usercard usercard-responsive">
                <img
                  src="{{URL::to('/')}}/images/sbu.png"
                  class="usercard__logo img-fluid"
                />
                <div class="h-100 d-flex">
                  <div
                    class="usercard__avatar"
                    style="background-image: url('{{URL::to('/')}}/images/gender.jpg')"
                  ></div>
                  <div class="usercard__footer exit">
                    ANNEX EXIT 1
                  </div>
                  <figcaption class="usercard__description">
                    <div class="usercard__description-inner">
                      <h1 class="usercard__description-title">
                        <span class="text-truncate d-block">Maria Elisa A.</span>
                        <span> Ramos</span>
                      </h1>
                      <h3 class="usercard__description-subtitle">
                        SHS-201900236
                      </h3>
    
                      <h5 class="usercard__description-label">
                        09-27-19 11:01:38 am
                      </h5>
                    </div>
                    <div class="usercard__footer exit">
                      ANNEX EXIT 1
                    </div>
                  </figcaption>
                </div>
              </figure>
            </div>
            <div class="col-md-3 px-4 py-4">
              <figure class="usercard usercard-responsive">
                <img
                  src="{{URL::to('/')}}/images/sbu.png"
                  class="usercard__logo img-fluid"
                />
                <div class="h-100 d-flex">
                  <div
                    class="usercard__avatar"
                    style="background-image: url('{{URL::to('/')}}/images/gender.jpg')"
                  ></div>
                  <div class="usercard__footer exit">
                    ANNEX EXIT 1
                  </div>
                  <figcaption class="usercard__description">
                    <div class="usercard__description-inner">
                      <h1 class="usercard__description-title">
                        <span class="text-truncate d-block">JON JOSHUA M</span>
                        <span>PATDU</span>
                      </h1>
                      <h3 class="usercard__description-subtitle">
                        201500092
                      </h3>
    
                      <h5 class="usercard__description-label">
                        09-27-19 12:08:25 pm
                      </h5>
                    </div>
                    <div class="usercard__footer exit">
                      ANNEX EXIT 1
                    </div>
                  </figcaption>
                </div>
              </figure>
            </div>
            <div class="col-md-3 px-4 py-4">
              <figure class="usercard usercard-responsive">
                <img
                  src="{{URL::to('/')}}/images/sbu.png"
                  class="usercard__logo img-fluid"
                />
                <div class="h-100 d-flex">
                  <div
                    class="usercard__avatar"
                    style="background-image: url('{{URL::to('/')}}/images/gender.jpg')"
                  ></div>
                  <div class="usercard__footer exit">
                    ANNEX EXIT 1
                  </div>
                  <figcaption class="usercard__description">
                    <div class="usercard__description-inner">
                      <h1 class="usercard__description-title">
                        <span class="text-truncate d-block">Maria Elisa A.</span>
                        <span> Ramos</span>
                      </h1>
                      <h3 class="usercard__description-subtitle">
                        SHS-201900236
                      </h3>
    
                      <h5 class="usercard__description-label">
                        09-27-19 11:01:38 am
                      </h5>
                    </div>
                    <div class="usercard__footer exit">
                      ANNEX EXIT 1
                    </div>
                  </figcaption>
                </div>
              </figure>
            </div>
            <div class="col-md-3 pl-4 pr-5 py-4">
              <figure class="usercard usercard-responsive">
                <img
                  src="{{URL::to('/')}}/images/sbu.png"
                  class="usercard__logo img-fluid"
                />
                <div class="h-100 d-flex">
                  <div
                    class="usercard__avatar"
                    style="background-image: url('{{URL::to('/')}}/images/gender.jpg')"
                  ></div>
                  <div class="usercard__footer exit">
                    ANNEX EXIT 1
                  </div>
                  <figcaption class="usercard__description">
                    <div class="usercard__description-inner">
                      <h1 class="usercard__description-title">
                        <span class="text-truncate d-block">JON JOSHUA M</span>
                        <span>PATDU</span>
                      </h1>
                      <h3 class="usercard__description-subtitle">
                        201500092
                      </h3>
    
                      <h5 class="usercard__description-label">
                        09-27-19 12:08:25 pm
                      </h5>
                    </div>
                    <div class="usercard__footer exit">
                      ANNEX EXIT 1
                    </div>
                  </figcaption>
                </div>
              </figure>
            </div>
        </div>
    </div>

    <script>
      var BASE_URL = "{{URL::to('/')}}"
    </script>
    <script src="{{URL::to('/')}}/assets/global/scripts/jquery-3.4.1.min.js"></script>
    <script src="{{URL::to('/')}}/assets/global/scripts/particles.min.js"></script>
    <script src="{{URL::to('/')}}/assets/global/scripts/jquery.fittext.js"></script>
    <script src="{{URL::to('/')}}/assets/page/scripts/monitor/monitor_public.js"></script>

    <script>
        jQuery(document).ready(function() {
            MonitorPublic.setStationsIDs("{{implode(',',$station_ids)}}");
            MonitorPublic.setPort({{$port}});
            MonitorPublic.setHost('{{$host}}');
            MonitorPublic.init();
        });
    </script>
  </body>
</html>
