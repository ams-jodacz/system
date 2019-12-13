@extends('main')

@section('title')
    Member
@stop

@section('page_level_styles')
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/bootstrap-datepicker/css/datepicker.css"/>
@stop

@section('breadcrumb')
    
@stop

@section('page_header')
    Add Member  
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <!-- BEGIN FORM-->
            <form method="post" class="horizontal-form" id="member_form">
                <h4 class="card-title">Member Form</h4>
                <div class="row">
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">First Name</label>
                                    {!!
                                        Form::text('first_name',isset($member_data)?$member_data->memberInformation->first_name:null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'first_name',
                                            'placeholder'=>'First Name',
                                        ))
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Middle Name</label>
                                    {!!
                                        Form::text('middle_name',isset($member_data)?$member_data->memberInformation->middle_name:null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'middle_name',
                                            'placeholder'=>'Middle Name',
                                        ))
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Last Name</label>
                                    {!!
                                        Form::text('last_name',isset($member_data)?$member_data->memberInformation->last_name:null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'last_name',
                                            'placeholder'=>'Last Name',
                                        ))
                                    !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">ID Number</label>
                                    <?php
                                        $id_number_control = array(
                                            'class'=>'form-control',
                                            'id'=>'id_number',
                                            'placeholder'=>'ID Number',
                                        );

                                        if (isset($member_data)){
                                            $id_number_control['readonly'] = 'readonly';
                                        }
                                    ?>
                                    {!!
                                        Form::text('id_number',isset($member_data)?$member_data->id_number:null,$id_number_control)
                                    !!}
                                    @if (isset($member_data))
                                        <input type="hidden" id="member_id" value="{{$member_data->member_id}}" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Contact Number</label>
                                    {!!
                                        Form::text('contact_number',isset($member_data)?$member_data->memberInformation->contact_number:null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'contact_number',
                                            'placeholder'=>'Contact Number',
                                        ))
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    {!!
                                        Form::text('email',isset($member_data)?$member_data->memberInformation->email:null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'email',
                                            'placeholder'=>'Email',
                                        ))
                                    !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Classification</label>
                                    <select id="class_id" name="class_id" class="select2 form-control" data-placeholder="Choose a Classification" tabindex="1">
                                        @foreach(App\Models\Classification\Classification::all() as $classification)
                                            @if (isset($member_data) && ($classification->class_id == $member_data->classificationGroup->class_id))
                                            <option selected="selected" value="{{$classification->class_id}}">{{$classification->classification_name}}</option>
                                            @else
                                            <option value="{{$classification->class_id}}">{{$classification->classification_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Classification Group</label>
                                    <select id="class_group_id" name="class_group_id" class="select2 form-control" data-placeholder="Choose a Classification Group" tabindex="1">
                                        <option value=""></option>
                                        @if (isset($member_data))
                                            @foreach(App\Models\Classification\ClassificationGroup::where(array('class_id' => $member_data->classificationGroup->class_id))->get() as $classification_group)
                                                @if (isset($member_data) && ($classification_group->class_group_id == $member_data->class_group_id))
                                                <option selected="selected" value="{{$classification_group->class_group_id}}">{{$classification_group->group_name}}</option>
                                                @else
                                                <option value="{{$classification_group->class_group_id}}">{{$classification_group->group_name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Status</label>
                                    {!!
                                        Form::select('active_status',
                                            array(
                                                true=>'Active',
                                                false=>'Inactive'
                                            ),
                                            isset($member_data)?$member_data->active_status:null,
                                            array(
                                                'class'=>'select2 form-control',
                                                'id'=>'active_status',
                                                'data-placeholder'=>'Choose a Status',
                                                'tabindex' => '1'
                                            )
                                        )
                                    !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

               
                <div class="row">
                    <div class="col-md-9">
                        <h4 class="card-title">Recipients</h4>
                    </div>
                    <div class="col-md-3">
                        <a class=" btn default green btn-xs pull-right" href="{{URL::to('member/view/0?actionType=recipient&id=0')}}" data-target="#recipient_info_ajax" data-toggle="modal">
                            <i class="fa fa-plus"></i>
                            Add
                        </a>
                    </div>
                </div>
               
                @include('content.member.modal.member_recipient_table')

                <div class="form-actions pull-right">
                    <a class=" btn default" href="{{URL::to('member')}}">
                        Back
                    </a>
                    @if (!isset($member_data))
                    <button type="submit" class="btn blue"><i class="fa fa-check"></i>Save</button>
                    @else
                    <button type="submit" class="btn blue"><i class="fa fa-check"></i>Update</button>
                    @endif
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
@stop

@section('page_js_plugins')
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootstrap-markdown/lib/markdown.js"></script>
@stop

@section('page_scripts')
    <script src="{{URL::to('/')}}/assets/page/scripts/member/member_form.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {
            MemberForm.init(
                '<?php echo isset($member_data)?'update':'add'; ?>'
            );
            <?php if (isset($member_data)){ ?>

                MemberForm.initRecipients(<?php echo json_encode($member_data->recipients) ?>)

            <?php } ?>
        });
    </script>
@stop