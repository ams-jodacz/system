<div class="row">
    <div class="col-md-12">
        <div class="panel-group accordion">
                <div id="module_page_container" class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" href="#sync_module">
                                Sync Semester Member Form
                            </a>
                        </h4>
                    </div>
                    <div id="sync_module" class="panel-collapse collapse">
                        <div class="panel-body form">
                            <!-- BEGIN FORM-->
                            <form method="post" class="horizontal-form" id="sync_member_form" enctype="multipart/form-data">
                                <div class="form-body">
                                        <h3 class="form-section">Sync Semester Member Form</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Academic Term</label>
                                                    <select id="grad_term_id" name="grad_term_id" class="select2 form-control" data-placeholder="Choose a Group" tabindex="1">
                                                        @if (isset($sem_list) && count($sem_list) > 0)
                                                            @foreach($sem_list as $sem)
                                                            <option value="{{$sem->TermID}}">{{$sem->AcadTerm}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Classification</label>
                                                    <select id="dest_upper_class_id" name="dest_upper_class_id" class="select2 form-control" data-placeholder="Choose a Station Group" tabindex="1">
                                                        @foreach(App\Models\Classification\Classification::all() as $classification)
                                                            <option value="{{$classification->class_id}}">{{$classification->classification_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="form-actions right">
                                        <button type="submit" class="btn blue"><i class="fa fa-check"></i>Sync</button>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
