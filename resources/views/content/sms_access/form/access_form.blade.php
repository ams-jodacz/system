<div class="row">
    <div class="col-md-12">
        <div class="panel-group accordion">
                <div id="module_page_container" class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" href="#module">
                                SMS Access Form
                            </a>
                        </h4>
                    </div>
                    <div id="module" class="panel-collapse collapse">
                        <div class="panel-body form">
                            <!-- BEGIN FORM-->
                            <form method="post" class="horizontal-form" id="access_form">
                                <div class="form-body">
                                        <h3 class="form-section">SMS Access Form</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Server Name</label>
                                                    <select id="sms_server_id" name="sms_server_id" class="select2 form-control" data-placeholder="Choose a Server Name" tabindex="1">
                                                        @foreach(App\Models\SMS\Server::all() as $server)
                                                            <option value="{{$server->sms_server_id}}">{{$server->server_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">SMS Group Name</label>
                                                    <select id="sms_prefix_group_id" name="sms_prefix_group_id" class="select2 form-control" data-placeholder="Choose a SMS Group Name" tabindex="1">
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
