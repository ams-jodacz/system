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
  </head>
  <body class="body">
    <div id="particles-js"></div>
    <div class="container-fluid px-5 pb-5 pt-4">
      <h1 class="main-title">{{isset($station_group) && isset($station_group->group_name)}}</h1>
      <div class="row">
        @foreach($in_stations as $station)
            <div class="col-md-6 px-5 py-4">
                <figure class="usercard">
                    <img src="./assets/img/final.png" class="usercard__logo img-fluid"/>
                    <div class="h-100 d-flex">
                    <div class="usercard__avatar" style="background-image: url('http://124.83.35.180/public/images/SHS-201900230.jpg')"></div>
                    <figcaption class="usercard__description">
                        <div class="usercard__description-inner">
                        <h1 class="usercard__description-title station_name_{{$station->station_id}}">
                            <span class="text-truncate d-block">
                                Maria Elisa A.
                            </span>
                            <span>
                                Ramos
                            </span>
                        </h1>
                        <h3 class="usercard__description-subtitle">
                            SHS-201900236
                        </h3>
                        <h5 class="usercard__description-label">
                            09-27-19 11:01:38 am
                        </h5>
                        </div>
                        <div class="usercard__footer entrance">
                            {{$station->name}}
                        </div>
                    </figcaption>
                    </div>
                </figure>
                <!-- <div class="form-group">
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
                </div> -->
            </div>
        @endforeach
      </div>

      <div class="row">
        <div class="col-md-6 px-5 pt-4 pb-5">
          <figure class="usercard">
            <img
              src="./assets/img/final.png"
              class="usercard__logo img-fluid"
            />
            <div class="h-100 d-flex">
              <div
                class="usercard__avatar"
                style="background-image: url('http://124.83.35.180/public/images/201930186.jpg')"
              ></div>
              <figcaption class="usercard__description">
                <div class="usercard__description-inner">
                  <h1 class="usercard__description-title">
                    <span class="text-truncate d-block">Jenina Rose C.</span>
                    <span> Turla</span>
                  </h1>
                  <h3 class="usercard__description-subtitle">
                    201930186
                  </h3>

                  <h5 class="usercard__description-label">
                    09-27-19 12:01:22 pm
                  </h5>
                </div>
                <div class="usercard__footer exit">
                  ANNEX EXIT 2
                </div>
              </figcaption>
            </div>
          </figure>
        </div>
        <div class="col-md-6 px-5 pt-4 pb-5">
          <figure class="usercard">
            <img
              src="./assets/img/final.png"
              class="usercard__logo img-fluid"
            />
            <div class="h-100 d-flex">
              <div
                class="usercard__avatar"
                style="background-image: url('http://124.83.35.180/public/images/20190014.jpg')"
              ></div>
              <figcaption class="usercard__description">
                <div class="usercard__description-inner">
                  <h1 class="usercard__description-title">
                    <span class="text-truncate d-block">Pocholo A.</span>
                    <span> Layug</span>
                  </h1>
                  <h3 class="usercard__description-subtitle">
                    20190014
                  </h3>

                  <h5 class="usercard__description-label">
                    09-27-19 12:10:23 pm
                  </h5>
                </div>
                <div class="usercard__footer entrance">
                  ANNEX ENTRY 2
                </div>
              </figcaption>
            </div>
          </figure>
        </div>
      </div>
    </div>

    <script
      src="https://code.jquery.com/jquery-3.4.1.min.js"
      integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
      crossorigin="anonymous"
    ></script>
    <script src="{{URL::to('/')}}/assets/js/particles.min.js"></script>
    <script src="{{URL::to('/')}}/assets/js/jquery.fittext.js"></script>

    <script src="./assets/js/app.js"></script>
  </body>
</html>
