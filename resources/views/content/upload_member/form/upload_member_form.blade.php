<div class="row">
    <div class="col-md-12">
        <div class="panel-group accordion">
                <div id="module_page_container" class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" href="#module">
                                Upload Member Form
                            </a>
                        </h4>
                    </div>
                    <div id="module" class="panel-collapse collapse">
                        <div class="panel-body form">
                            <!-- BEGIN FORM-->
                            <form method="post" class="horizontal-form" id="upload_member_form" enctype="multipart/form-data">
                                <div class="form-body">
                                        <h3 class="form-section">Upload Member Form</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Classification</label>
                                                    <select id="class_id" name="class_id" class="select2 form-control" data-placeholder="Choose a Station Group" tabindex="1">
                                                        @foreach(App\Models\Classification\Classification::all() as $classification)
                                                            <option value="{{$classification->class_id}}">{{$classification->classification_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Classfication Group</label>
                                                    <select id="class_group_id" name="class_group_id" class="select2 form-control" data-placeholder="Choose a Group" tabindex="1">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">File</label>
                                                    <span class="btn green fileinput-button form-control">
                                                        <input type="file" name="uploaded_file" id="uploaded_file">
                                                    </span>
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
