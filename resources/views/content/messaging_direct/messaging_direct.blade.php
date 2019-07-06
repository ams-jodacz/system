@extends('main2')

@section('title')
    Messaging | Direct
@stop

@section('page_level_styles')
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
@stop

@section('breadcrumb')
    
@stop

@section('page_header')
    Direct Messaging
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        Direct Messaging
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form method="post" class="horizontal-form" id="direct_message_form">
                        <div class="form-body">
                                <h3 class="form-section">Direct Messaging Form</h3>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>
                                                {!!
                                                    Form::checkbox('all',1,true,
                                                    array(
                                                        'id' => 'all',
                                                        'class'=>'modules_btn icheck',
                                                        'data-checkbox' => 'icheckbox_square-grey'
                                                    ));
                                                !!}
                                                Send To All
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Classification</label>
                                            <select id="class_id" name="class_id" class="select2 form-control" data-placeholder="Choose a Station Group" tabindex="1">
                                                @foreach(App\Models\Classification\Classification::all() as $classification)
                                                    <option value="{{$classification->class_id}}">{{$classification->classification_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Classfication Group</label>
                                            <select id="class_group_id" name="class_group_id" class="select2 form-control" data-placeholder="Choose a Group" tabindex="1">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Members</label>
                                            <select id="member_id" name="member_id" class="select2 form-control" data-placeholder="Choose a Member" tabindex="1">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Message</label>
                                            {!!
                                                Form::textarea('message','',
                                                array(
                                                    'class'=>'form-control',
                                                    'id'=>'message',
                                                    'placeholder'=>'Message',
                                                    'rows' => 5,
                                                    'maxlength' => '255',
                                                ))
                                            !!}
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="form-actions right">
                                <button type="submit" class="btn blue"><i class="fa fa-check"></i>Send</button>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
    <!--Modal Start-->
    <div class="modal fade bs-modal-lg" id="info_ajax" role="basic" aria-hidden="true">
        <div class="page-loading page-loading-boxed">
            <img src="{{URL::to('/')}}/assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
            <span>
                &nbsp;&nbsp;Loading...
            </span>
        </div>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
    <!--Modal End-->
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
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
@stop

@section('page_scripts')
    <script src="{{URL::to('/')}}/assets/page/scripts/messaging_direct/direct.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {       
            Direct.init();
        });
    </script>
@stop