@extends('main2')

@section('title')
    Dashboard
@stop

@section('page_level_styles')
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
@stop

@section('breadcrumb')
    
@stop

@section('page_header')
    Dashboard
@stop

@section('content')
 <div class="card">
     <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                    <h4 class="card-title">DTR records</h4>
                    <p class="card-description">Use this module to view DTR records</p>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-search">
                    <input type="text" class="form-control" placeholder="Search user..">
                    <a href="#" class="btn btn-primary">Search</a>
                </div>       
            </div>
        </div>

        <div class="row">
            <div class="col-md-10">
                <div class="form-group db-form-group">
                    <label class="control-label">Date Start:</label>
                    <input readonly="readonly" id="date_start" type="text" />
                </div>
            
                <div class="form-group db-form-group">
                    <label class="control-label">Date End:</label>
                    <input readonly="readonly" id="date_end" type="text" />
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success pull-right" id="print-dtr">Print record</button>
            </div>
        </div>

        <table class="table db-table">
            <tbody>
                <tr>
                    <td>
                        <i class="icon-calendar"></i> Wed 13 Nov 2019
                    </td>
                    <td>08:05:14 AM</td>
                    <td>
                        <div class="indicator is-in">IN</div>
                        <div class="indicator is-out">OUT</div>
                    </td>
                    <td>
                        <div>Station 1</div>
                        <div>Station 2</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <i class="icon-calendar"></i> Tue 12 Nov 2019
                    </td>
                    <td>
                        08:05:14 AM
                        <br>
                        03:25:19 PM
                    </td>
                    <td>
                        <div class="indicator is-in">IN</div>
                        <div class="indicator is-out">OUT</div>
                    </td>
                    <td>
                        <div>Station 1</div>
                        <div>Station 2</div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="card" id="print">
            <div class="card-body">
                <div class="print-content">
                    <div class="print-logo">
                        <img src="{{URL::to('/')}}/images/sbu.png" alt="school-logo">
                    </div>
                    <div class="text-center">
                        <h3>DAILY TIME RECORD</h3>
                        <h4>Regular</h4>
                    </div>
                    <div class="print-body">
                        <div class="column">
                            <div class="column-row">
                                <div class="column-left">
                                    <span class="column-label">Name:</span>
                                    <span class="column-value">  
                                        <strong>Kim Lauren Branzuela</strong>
                                    </span>
                               </div>

                               <div class="column-right">
                                    <span class="column-label">For the period:</span>
                                    <span class="column-value">  
                                       <strong>07/01/2019-07/15/2019</strong>
                                    </span>
                               </div>
                            </div>

                            <div class="column-row">
                                <div class="column-left">
                                    <span class="column-label">Status:</span>
                                    <span class="column-value">  
                                    <strong>Faculty</strong>
                                    </span>
                                </div>
    
                                <div class="column-right">
                                    <span class="column-label">Schedule:</span>
                                    <span class="column-value">  
                                        <strong>
                                            Mon,Tue,Wed,Thu,Fri,Sat 8:00 AM-12:00 PM
                                            <br/>
                                            Mon,Tue,Wed,Thu,Fri,Sat 1:00 PM-5:00 PM
                                        </strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <table class="table table-dtr">
                            <thead>
                                <tr>
                                    <th colspan="2">DAY</th>
                                    <th colspan="2">AM</th>
                                    <th colspan="2">PM</th>
                                    <th colspan="2">UNDERTIME</th>
                                    <th colspan="2">TOTAL</th>
                                </tr>
                                
                                <tr>
                                    <th colspan="2"></th>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>Hrs.</th>
                                    <th>Mins.</th>
                                    <th>Worked</th>
                                    <th>Span</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>7/1/19</td>
                                    <td>Mon</td>
                                    <td>7:55 AM</td>
                                    <td>12:00 PM</td>
                                    <td>1:00 PM</td>
                                    <td>5:33 PM</td>
                                    <td></td>
                                    <td></td>
                                    <td>8.0</td>
                                    <td>8.6</td>
                                </tr>

                                <tr>
                                    <td colspan="6" class="text-center">TOTAL</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">
                                        I CERTIFY on my honor that the above is a true and correct report of the hours performed, recorded with was made daily at the time of arrival and departure from the office.
                                    </td>
                                    <td colspan="4" class="text-right">VERIFIED as to the prescribed office hours.</td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="faculty">
                            <div class="faculty-signature">
                                Kim Lauren Branzuela
                            </div>

                            <div class="faculty-signature"></div>
                        </div>
                    </div>
               </div>
            </div>

            <div class="card-body">
                <div class="print-content">
                    <div class="print-logo">
                        <img src="{{URL::to('/')}}/images/sbu.png" alt="school-logo">
                    </div>
                    <div class="text-center">
                        <h3>DAILY TIME RECORD</h3>
                        <h4>Regular</h4>
                    </div>
                    <div class="print-body">
                        <div class="column">
                            <div class="column-row">
                                <div class="column-left">
                                    <span class="column-label">Name:</span>
                                    <span class="column-value">  
                                        <strong>Michael Jumoc</strong>
                                    </span>
                                </div>

                                <div class="column-right">
                                    <span class="column-label">For the period:</span>
                                    <span class="column-value">  
                                        <strong>07/01/2019-07/15/2019</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="column-row">
                                <div class="column-left">
                                    <span class="column-label">Status:</span>
                                    <span class="column-value">  
                                    <strong>Student</strong>
                                    </span>
                                </div>
    
                                <div class="column-right">
                                    <span class="column-label">Schedule:</span>
                                    <span class="column-value">  
                                        <strong>
                                            Mon,Tue,Wed,Thu,Fri,Sat 8:00 AM-12:00 PM
                                            <br/>
                                            Mon,Tue,Wed,Thu,Fri,Sat 1:00 PM-5:00 PM
                                        </strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <table class="table table-dtr">
                            <thead>
                                <tr>
                                    <th colspan="2">DAY</th>
                                    <th colspan="2">AM</th>
                                    <th colspan="2">PM</th>
                                    <th colspan="2">TOTAL</th>
                                    <th>GATE</th>
                                </tr>
                                
                                <tr>
                                    <th colspan="2"></th>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>Worked</th>
                                    <th>Span</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>7/1/19</td>
                                    <td>Mon</td>
                                    <td>7:55 AM</td>
                                    <td>12:00 PM</td>
                                    <td>1:00 PM</td>
                                    <td>5:33 PM</td>
                                    <td>8.0</td>
                                    <td>8.6</td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td colspan="6" class="text-center">TOTAL</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">
                                        I CERTIFY on my honor that the above is a true and correct report of the hours performed, recorded with was made daily at the time of arrival and departure from the office.
                                    </td>
                                    <td colspan="3" class="text-right">VERIFIED as to the prescribed office hours.</td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="faculty">
                            <div class="faculty-signature">
                                Kim Lauren Branzuela
                            </div>

                            <div class="faculty-signature"></div>
                        </div>
                    </div>
                </div>
             </div>
        </div>   
    </div>
</div>
@stop

@section('page_js_plugins')
    <script src="{{URL::to('/')}}/assets/admin/layout/scripts/printThis.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
@stop

@section('page_scripts')
    <script src="{{URL::to('/')}}/assets/page/scripts/dashboard.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {       
           Dashboard.init();
        });
    </script>
@stop