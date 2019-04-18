<div class="row">
    <div class="col-md-12">
        <div class="panel-group accordion">
                <div id="module_page_container" class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" href="#transfer_module">
                                Member Transfer Form
                            </a>
                        </h4>
                    </div>
                    <div id="transfer_module" class="panel-collapse collapse">
                        <div class="panel-body form">
                            <!-- BEGIN FORM-->
                            <form method="post" class="horizontal-form" id="transfer_member_form" enctype="multipart/form-data">
                                <div class="form-body">
                                        <h3 class="form-section">Origin</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Classification</label>
                                                    <select id="from_class_id" name="from_class_id" data-name="from" data-type="class_id" class="select2 transfer_options form-control" data-placeholder="Choose a Station Group" tabindex="1">
                                                        @foreach(App\Models\Classification\Classification::all() as $classification)
                                                            <option value="{{$classification->class_id}}">{{$classification->classification_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Classfication Group</label>
                                                    <select id="from_class_group_id" name="from_class_group_id" data-name="from" data-type="class_group_id" class="select2 transfer_options form-control" data-placeholder="Choose a Group" tabindex="1">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Members</label>
                                                    <select id="from_member_id" multiple="multiple" name="from_member_id" data-name="from" class="select2 transfer_options form-control" data-placeholder="Choose a Member" tabindex="1">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="form-section">Destination</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Classification</label>
                                                    <select id="to_class_id" name="to_class_id" data-name="to" data-type="class_id" class="select2 transfer_options form-control" data-placeholder="Choose a Station Group" tabindex="1">
                                                        @foreach(App\Models\Classification\Classification::all() as $classification)
                                                            <option value="{{$classification->class_id}}">{{$classification->classification_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Classfication Group</label>
                                                    <select id="to_class_group_id" data-name="to" name="to_class_group_id" data-type="class_group_id" class="select2 transfer_options form-control" data-placeholder="Choose a Group" tabindex="1">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="form-actions right">
                                        <button type="submit" class="btn blue"><i class="fa fa-check"></i>Transfer</button>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>