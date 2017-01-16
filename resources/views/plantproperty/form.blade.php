@extends("dcms::template/layout")

@section("content")

    <div class="main-header">
      <h1>Plants</h1>
      <ol class="breadcrumb">
        <li><a href="{!! URL::to('admin/dashboard') !!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{!! URL::to('admin/plants') !!}"><i class="fa fa-tree"></i> Plants</a></li>
        <li><a href="{!! URL::to('admin/plants/properties') !!}"><i class="fa fa-tree"></i> Plants properties</a></li>
        @if(isset($plant))
					 	<li class="active">Edit</li>
        @else
			  		<li class="active">Create</li>
        @endif
      </ol>
    </div>

    <div class="main-content">
    @if(isset($Plantproperty))
      {!! Form::model($Plantproperty, array('route' => array('admin.plants.properties.update', $Plantproperty->id), 'method' => 'PUT')) !!}
    @else
      {!! Form::open(array('url' => 'admin/plants/properties')) !!}
    @endif

    	<div class="row">
				<div class="col-md-12">
    	    <div class="main-content-tab tab-container">
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#information" role="tab" data-toggle="tab">Information</a></li>
            </ul>

            <div class="tab-content">
              <div id="information" class="tab-pane active">
              @if($errors->any())
              <div class="alert alert-danger">{!! Html::ul($errors->all()) !!}</div>
              @endif
              <div class="form-group">
                {!! Form::label('property_name', 'Property name') !!}
                {!! Form::text('property_name', null, array('class' => 'form-control')) !!}
              </div>
              <div class="form-group">
                {!! Form::checkbox('multiple', '1',false, array('class' => 'form-checkbox','id'=>'multiple'))  !!}
                {!! Html::decode(Form::label('multiple', 'Multiselect', array('class' => 'checkbox'))) !!}
              </div>
						  @if(isset($languages))
              <ul class="nav nav-tabs" role="tablist">
                @foreach($languages as $key => $language)
                <li class="{!! ($key == 0 ? 'active' : '') !!}"><a href="{!! '#' . $language->language . '-' . $language->country !!}" role="tab" data-toggle="tab"><img src="{!! asset('/packages/dcms/core/images/flag-' . $language->country . '.png') !!}" width="18" height="12" /> {!! $language->language_name !!}</a></li>
                @endforeach
              </ul>
              <div class="tab-content">
                @foreach($languages as $key => $information)
                  <div id="{!! $information->language . '-' . $information->country !!}" class="tab-pane {!! ($key == 0 ? 'active' : '') !!}">
                    {!!Form::hidden('property_detail_id[' . $information->language_id . ']', $information->property_detail_id) !!}

                    <div class="form-group">
                      {!! Form::label('property[' . $information->language_id . ']', 'Property') !!}
                      {!! Form::text('property[' . $information->language_id . ']', isset($information->property)?$information->property:null , array('class' => 'form-control')) !!}
                    </div>
                  </div>
                @endforeach
              </div>
              @endif
              </div>
            </div>
          </div>
        </div>
      </div>
        <div class="col-md-12">
          <div class="main-content-block">
            {!! Form::submit('Save', array('class' => 'btn btn-primary')) !!}
            <a href="{!! URL::previous() !!}" class="btn btn-default">Cancel</a>
          </div>
        </div>
      </div>
    {!! Form::close() !!}
    </div>
@stop

@section("script")

<script type="text/javascript" src="{!! asset('packages/dcms/core/js/bootstrap.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('packages/dcms/core/js/bootstrap-datetimepicker.min.js') !!}"></script>
<link rel="stylesheet" type="text/css" href="{!! asset('packages/dcms/core/css/bootstrap-datetimepicker.min.css') !!}">

<script type="text/javascript" src="{!! asset('/ckeditor/ckeditor.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/ckeditor/adapters/jquery.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/ckfinder/ckfinder.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/ckfinder/ckbrowser.js') !!}"></script>

<script type="text/javascript">
$(document).ready(function() {

	//Bootstrap Tabs
	$(".tab-container .nav-tabs a").click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	})


});
</script>

@stop
