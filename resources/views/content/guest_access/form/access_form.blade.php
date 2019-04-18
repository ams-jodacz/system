<div class="row">
    <div class="col-md-12">
        <div class="panel-group accordion">
                <div id="module_page_container" class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" href="#module">
                                Guest Access Form
                            </a>
                        </h4>
                    </div>
                    <div id="module" class="panel-collapse collapse">
                        <div class="panel-body form">
                            <!-- BEGIN FORM-->
                            <form method="post" class="horizontal-form" id="guest_access_form">
                                <div class="form-body">
                                        <h3 class="form-section">Guest Access Form</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Station Group</label>
                                                    <select id="station_group_id" name="station_group_id" class="select2 form-control" data-placeholder="Choose a Station Group" tabindex="1">
                                                        @foreach(App\Models\Stations\StationGroup::all() as $station_group)
                                                            <option value="{{$station_group->station_group_id}}">{{$station_group->group_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Guest Group Name</label>
                                                    <select id="guest_group_id" name="guest_group_id" class="select2 form-control" data-placeholder="Choose a Group" tabindex="1">
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
    </div>
</div>
