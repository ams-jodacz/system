<?php
    $counter = 0;
    $data_limit = 20;
?>
@while(count($logs) > $counter)
<div class="card report_container">
    <div class="card-body">
        <div class="print-content">
            <div class="print-logo">
                <img src="{{URL::to('/')}}/images/logo.png" alt="school-logo">
            </div>
            <div class="text-center">
                <h3>TIME RECORD</h3>
                <!-- <h4>Regular</h4> -->
            </div>
            <br/>
            <div class="print-body">
                <div class="column">
                    <div class="column-row">
                        <div class="column-left">
                            <span class="column-label">Name:</span>
                            <span class="column-value">  
                                <strong>{{$member_info->last_name.', '.$member_info->first_name.' '.$member_info->middle_name}}</strong>
                            </span>
                        </div>

                        <div class="column-right">
                            <span class="column-label">For the period:</span>
                            <span class="column-value">  
                                <strong>{{$start_date->format('M/d/Y')}} - {{$end_date->format('M/d/Y')}}</strong>
                            </span>
                        </div>
                    </div>

                    <!-- <div class="column-row">
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
                    </div> -->
                </div>
                <table class="table table-dtr">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Gate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0;$i < $data_limit && ($i+$counter) < count($logs);$i++)
                        <?php
                            $time_log_date_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$logs[($counter+$i)]->date_time);
                        ?>
                        <tr>
                            <td>
                                {{$time_log_date_time->format('M/d/Y')}}
                            </td>
                            <td>
                                {{$time_log_date_time->format('h:i:s a')}}
                            </td>
                            <td>
                                {{$logs[($counter+$i)]->station->status}}
                            </td>
                            <td>
                                {{$logs[($counter+$i)]->station->stationGroup->group_name.' ('.$logs[($counter+$i)]->station->name.')'}}
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                I CERTIFY on my honor that the above is a true and correct report of the hours performed, recorded with was made daily at the time of arrival and departure from the office.
                            </td>
                            <!-- <td class="text-right">VERIFIED as to the prescribed office hours.</td> -->
                        </tr>
                    </tfoot>
                </table>
                <?php
                    $counter = $counter + $data_limit;
                ?>
                <div class="faculty">
                    <div class="faculty-signature">
                        {{$member_info->last_name.', '.$member_info->first_name.' '.$member_info->middle_name}}
                    </div>

                    <div class="faculty-signature"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<br/>
@endwhile
<!-- BREAK -->