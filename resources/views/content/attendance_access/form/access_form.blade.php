<div class="panel-group accordion">
    <div id="module_page_container" class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" href="#module">
                    Attendance Station Access Form
                </a>
            </h4>
        </div>
        <div id="module" class="panel-collapse collapse">
            <div class="panel-body form">
                <!-- BEGIN FORM-->
                <form method="post" class="horizontal-form" id="access_form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Attendance Station Group</label>
                                    <select id="attendance_group_id" name="attendance_group_id" class="select2 form-control" data-placeholder="Choose a Station Group" tabindex="1">
                                        <option value=""></option>
                                        @foreach(App\Models\Attendance\AttendanceGroup::all() as $attendance_group)
                                            <option value="{{$attendance_group->attendance_group_id}}">{{$attendance_group->group_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Classification</label>
                                    <select id="class_id" name="class_id" class="select2 form-control" data-placeholder="Choose a Group" tabindex="1">
                                        <option value=""></option>
                                        @foreach(App\Models\Classification\Classification::all() as $classification)
                                            <option value="{{$classification->class_id}}">{{$classification->classification_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Group Name</label>
                                    <select id="class_group_id" name="class_group_id" class="select2 form-control" data-placeholder="Choose a Group" tabindex="1">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions right">
                        <button type="submit" class="btn blue"><i class="fa fa-check"></i>Add</button>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>
