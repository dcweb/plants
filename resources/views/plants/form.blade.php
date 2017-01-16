@extends("dcms::template/layout")

@section("content")

    <div class="main-header">
      <h1>Plants</h1>
      <ol class="breadcrumb">
        <li><a href="{!! URL::to('admin/dashboard') !!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{!! URL::to('admin/plants') !!}"><i class="fa fa-tree"></i> Plants</a></li>
        @if(isset($plant))
					 	<li class="active">Edit</li>
        @else
			  		<li class="active">Create</li>
        @endif
      </ol>
    </div>

    <div class="main-content">

    @if(isset($Plant))
        {!! Form::model($Plant, array('route' => array('admin.plants.update', $Plant->id), 'method' => 'PUT')) !!}
    @else
        {!! Form::open(array('url' => 'admin/plants')) !!}
    @endif

    	<div class="row">
				<div class="col-md-12">
    	    <div class="main-content-tab tab-container">
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#data" role="tab" data-toggle="tab">Data</a></li>
                <li class=""><a href="#information" role="tab" data-toggle="tab">Information</a></li>
                <li class=""><a href="#comments" role="tab" data-toggle="tab">Comments</a></li>
                <li class=""><a href="#properties" role="tab" data-toggle="tab">Properties</a></li>
                <li class=""><a href="#image" role="tab" data-toggle="tab">Image</a></li>
            </ul>
            <div class="tab-content">
              <div id="data" class="tab-pane active">
                @if($errors->any())
                <div class="alert alert-danger">{!! Html::ul($errors->all()) !!}</div>
                @endif

                <div class="form-group">
                  {!! Form::label('parent_id', 'Parent plant') !!}
                  {!! $parentplants !!}
                </div>

                <select id='custom-headers' multiple='multiple' class="searchable">
                  <option value='elem_1'>elem 1</option>
                  <option value='elem_2'>elem 2</option>
                  <option value='elem_3'>elem 3</option>
                  <option value='elem_4'>elem 4</option>
                  <option value='elem_100'>elem 100</option>
                  <option value='elem_1'>elem 1</option>
                  <option value='elem_2'>elem 2</option>
                  <option value='elem_3'>elem 3</option>
                  <option value='elem_4'>elem 4</option>
                  <option value='elem_100'>elem 100</option>
                  <option value='elem_1'>elem 1</option>
                  <option value='elem_2'>elem 2</option>
                  <option value='elem_3'>elem 3</option>
                  <option value='elem_4'>elem 4</option>
                  <option value='elem_100'>elem 100</option>
                  <option value='elem_1'>elem 1</option>
                  <option value='elem_2'>elem 2</option>
                  <option value='elem_3'>elem 3</option>
                  <option value='elem_4'>elem 4</option>
                  <option value='elem_100'>elem 100</option>
                  <option value='elem_1'>elem 1</option>
                  <option value='elem_2'>elem 2</option>
                  <option value='elem_3'>elem 3</option>
                  <option value='elem_4'>elem 4</option>
                  <option value='elem_100'>elem 100</option>
                </select>


                <div class="form-group">
                  {!! Form::checkbox('online', '1', (isset($Plant) && $Plant->online===1)?true:false, array('class' => 'form-checkbox','id'=>'online'))  !!}
                  {!! Html::decode(Form::label('online', 'Online', array('class' => (isset($Plant) && $Plant->online==1)?'checkbox active':'checkbox'))) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('family_name', 'Family name') !!}
                  {!! Form::text('family_name', null, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('family_name', 'Genus name') !!}
                  {!! Form::text('family_name', null, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('epithet_name', 'Epithet name') !!}
                  {!! Form::text('epithet_name', null, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('cultivar_name', 'Cultivar name') !!}
                  {!! Form::text('cultivar_name', null, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('height_min', 'Height min (mm)') !!}
                	{!! Form::text('height_min', null, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('height_max', 'Height max (mm)') !!}
                	{!! Form::text('height_max', null, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                  {!! Form::checkbox('evergreen', '1', (isset($Plant) && $Plant->evergreen===1)?true:false, array('class' => 'form-checkbox','id'=>'evergreen'))  !!}
                  {!! Html::decode(Form::label('evergreen', 'Evergreen', array('class' => (isset($Plant) && $Plant->evergreen==1)?'checkbox active':'checkbox'))) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('planting_depth_min', 'Planting Depth min (mm)') !!}
                	{!! Form::text('planting_depth_min', null, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('planting_depth_max', 'Planting Depth max (mm)') !!}
                	{!! Form::text('planting_depth_max', null, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('latitude', 'Latitude') !!}
                	{!! Form::text('latitude', null, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('longitude', 'Longitude') !!}
                	{!! Form::text('longitude', null, array('class' => 'form-control')) !!}
                </div>
              </div>

              <div id="information" class="tab-pane">
                @if(isset($languages))
                <ul class="nav nav-tabs" role="tablist">
                  @foreach($languages as $key => $language)
                  <li class="{!! ($key == 0 ? 'active' : '') !!}"><a href="{!! '#' . $language->language . '-' . $language->country !!}" role="tab" data-toggle="tab"><img src="{!! asset('/packages/dcms/core/images/flag-' . $language->country . '.png') !!}" width="18" height="12" /> {!! $language->language_name !!}</a></li>
                  @endforeach
                </ul>

                <div class="tab-content">
                @foreach($languages as $key => $information)
                  <div id="{!! $information->language . '-' . $information->country !!}" class="tab-pane {!! ($key == 0 ? 'active' : '') !!}">
                  {!!Form::hidden('plant_detail_id[' . $information->language_id . ']', $information->plant_detail_id) !!}
                    <div class="form-group">
                      {!! Form::label('common_name[' . $information->language_id . ']', 'Common name') !!}
                      {!! Form::text('common_name[' . $information->language_id . ']',  isset($information->common_name)?$information->common_name:null, array('class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                      {!! Form::label('description_1[' . $information->language_id . ']', 'Description 1') !!}
                      {!! Form::textarea('description_1[' . $information->language_id . ']',   isset($information->description_1)?$information->description_1:null, array('class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                      {!! Form::label('description_2[' . $information->language_id . ']', 'Description 2') !!}
                      {!! Form::textarea('description_2[' . $information->language_id . ']', isset($information->description_2)?$information->description_2:null, array('class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                      {!! Form::label('origin_1[' . $information->language_id . ']', 'Origin 1') !!}
                      {!! Form::text('origin_1[' . $information->language_id . ']', isset($information->origin_1)?$information->origin_1:null, array('class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                      {!! Form::label('bark[' . $information->language_id . ']', 'Bark') !!}
                      {!! Form::text('bark[' . $information->language_id . ']', isset($information->bark)?$information->bark:null, array('class' => 'form-control')) !!}
                    </div>
                  </div>
                  @endforeach
                </div>
                @endif
              </div>
              <div id="comments" class="tab-pane">
                <div class="form-group">
                  {!! Form::label('description_3', 'Description 3') !!}
                  {!! Form::textarea('description_3', null, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('description_4', 'Description 4') !!}
                  {!! Form::textarea('description_4', null, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('origin_2', 'Origin 2') !!}
                  {!! Form::text('origin_2', null, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('comment_1', 'Comment 1') !!}
                  {!! Form::textarea('comment_1', null, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('comment_2', 'Comment 2') !!}
                  {!! Form::textarea('comment_2', null, array('class' => 'form-control')) !!}
                </div>
              </div>
              <div id="properties" class="tab-pane">

                  <?php
                    // find magicsuggest like it is done on "VraagHetAan"
                    //ref nicolasbize.github.io/magicsuggest/
                    $dropdown = array();
                    foreach($oProperties as $Property)
                    {
                        if(!isset($dropdown[$Property->property_name]['options'])) $dropdown[$Property->property_name]['options'] = array();
                        if(!is_null($Property->property_language)) $dropdown[$Property->property_name]['options'][$Property->id] = $Property->property_language;

                        if(!isset($dropdown[$Property->property_name]['selected'])) $dropdown[$Property->property_name]['selected'] = array();
                        if($Property->selected == 1)$dropdown[$Property->property_name]['selected'][$Property->id] = $Property->id;
                    }
                  ?>

                  @foreach($dropdown as $name => $ddsettings)
                  <div class="form-group">
                        {!! Form::label(str_replace(' ', '', $name), $name) !!}
                        {!! Form::select('multiproperty_id['.$name.'][]', $dropdown[$name]['options'],  $dropdown[$name]['selected'], array('class' => 'form-control ddProperty','multiple')) !!}
                  </div>
                  @endforeach
              </div>

              <div id="image" class="tab-pane">

                <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Label</th>
                        <th>Path</th>
                        <th></th>
                      </tr>
                    </thead>

                    @if(isset($Pricerows)) {!!$Pricerows!!} @endif

                    <tfoot>
                      <tr>
                        <td colspan="5"><a class="btn btn-default pull-right add-table-row" href=""><i class="fa fa-plus"></i></a></td>
                      </tr>
                    </tfoot>
        				</table>


              </div>

          </div>

        </div>
      </div>

    </div>


      <div class="row">
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

	//CKFinder for CKEditor
	CKFinder.setupCKEditor( null, '/ckfinder/' );


	//Browser --) $(this).attr("id")
	$(".browse-server").click(function() {
		var returnid = $(this).attr("id").replace("browse_","") ;
		BrowseServer( 'Images:/', returnid);
	})

	//CKEditor
	$("textarea[id^='description']").ckeditor();
	$("textarea[id^='body']").ckeditor();
	$("textarea[id^='comment']").ckeditor();

	//Bootstrap Tabs
	$(".tab-container .nav-tabs a").click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	})

	//Bootstrap Datepicker
	$(".date").datetimepicker({
		todayHighlight: true,
		autoclose: true,
		pickerPosition: "bottom-left"
	});


	//Add table row
	$.fn.addtablerow = function( options ) {

		$(this).each(function() {

			var table = $( this );

			var rows = table.closest('tbody tr').length;

			table.find('.add-table-row').click(function() {
        language_id = table.attr("class").replace('table table-bordered table-striped languagehelperid-','');
        geturl  = options.source;
        geturl = geturl.replace("{LANGUAGE_ID}",language_id);

				$.get( geturl, function( data ) {
					if (!table.find('tbody').length) table.find('thead').after("<tbody></tbody>");

          data = data.replace(/{INDEX}/g, "extra"+language_id.trim()+"-"+rows);
          table.find('tbody').append( data );
          //$("#attachment-language-id[extra"+rows+"] option[value='"+language_id+"']").attr('selected','selected');
					rows++;
					deltablerow(table.find('.delete-table-row').last());
				});
				return false;
			});

			deltablerow(table.find('.delete-table-row'));
			browsetablerow(table.find('.browse-server-files'));

			function browsetablerow(e) {
				e.click (function() {
					var returnid = $(this).attr("id").replace("browse_","");
					BrowseServer( 'Files:/', returnid);
				});
			}

			function deltablerow(e) {
				e.click (function() {
					$(this).closest("tr").remove();
					if (!table.find('tbody tr').length) table.find('tbody').remove();
					return false;
				});
			}
		});
	};


  	$("body").on("click",".browse-server-images", function(){
  		var returnid = $(this).attr("id").replace("browse_","") ;
  		BrowseServer( 'Images:/', returnid);
  		});


	$("#image table").addtablerow({
		source: "{!! URL::to('admin/plants/api/tablerow?data=image') !!}" //generate the row with the dropdown fields/empty boxes/etc.
	});





});
</script>

@stop
