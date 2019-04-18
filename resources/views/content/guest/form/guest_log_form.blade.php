<div class="row">
    <div class="col-md-12">
        <div class="panel-group accordion">
                <div id="module_page_container" class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" href="#module">
                                Add Guest Form
                            </a>
                        </h4>
                    </div>
                    <div id="module" class="panel-collapse collapse">
                        <div class="panel-body form">
                            <!-- BEGIN FORM-->
                            <form method="post" class="horizontal-form" id="guest_form">
                                <div class="form-body">
                                        <h3 class="form-section">Add Guest Form</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Group</label>
                                                    <select id="guest_group_id" name="guest_group_id" class="select2 form-control" data-placeholder="Choose a Guest Group" tabindex="1">
                                                        @foreach(App\Models\Guests\GuestGroup::all() as $guest_group)
                                                            <option value="{{$guest_group->guest_group_id}}">{{$guest_group->group_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Tag Name</label>
                                                    <select id="tag_id" name="tag_id" class="select2 form-control" data-placeholder="Choose a Tag" tabindex="1">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Names</label>
                                                    {!!
                                                        Form::textarea('users','',
                                                        array(
                                                            'class'=>'form-control',
                                                            'id'=>'users',
                                                            'placeholder'=>'Names',
                                                            'rows' => 5,
                                                        ))
                                                    !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Reason</label>
                                                    {!!
                                                        Form::textarea('reason','',
                                                        array(
                                                            'class'=>'form-control',
                                                            'id'=>'reason',
                                                            'placeholder'=>'Reason',
                                                            'rows' => 5,
                                                        ))
                                                    !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Items</label>
                                                    {!!
                                                        Form::textarea('items','',
                                                        array(
                                                            'class'=>'form-control',
                                                            'id'=>'items',
                                                            'placeholder'=>'Items',
                                                            'rows' => 5,
                                                        ))
                                                    !!}
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
