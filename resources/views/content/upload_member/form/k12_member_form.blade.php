<div class="row">
    <div class="col-md-12">
        <div class="panel-group accordion">
                <div id="module_page_container" class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" href="#k12_sync_module">
                                Sync School Year Member Form
                            </a>
                        </h4>
                    </div>
                    <div id="k12_sync_module" class="panel-collapse collapse">
                        <div class="panel-body form">
                            <!-- BEGIN FORM-->
                            <form method="post" class="horizontal-form" id="k12_sync_member_form" enctype="multipart/form-data">
                                <div class="form-body">
                                    <h3 class="form-section">Sync School Year Member Form</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Academic Term</label>
                                                <select id="k12_term_id" name="k12_term_id" class="select2 form-control" data-placeholder="Choose a Group" tabindex="1">
                                                    @if (isset($term_list) && count($term_list) > 0)
                                                        @foreach($term_list as $term)
                                                        <option value="{{$term->TermID}}">{{$term->AcadTerm}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Classification</label>
                                                <select id="dest_k12_class_id" name="dest_k12_class_id" class="select2 form-control" data-placeholder="Choose a Station Group" tabindex="1">
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
