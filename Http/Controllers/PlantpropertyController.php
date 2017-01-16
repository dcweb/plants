<?php

namespace Dcms\Plants\Http\Controllers;

use Dcms\Plants\Models\Plants;
use Dcms\Plants\Models\Plantdetail;
use Dcms\Plants\Models\Plantproperty;
use Dcms\Plants\Models\Plantpropertydetail;

use Dcms\Core\Models\Languages\Language;

use App\Http\Controllers\Controller;

use View;
use Input;
use Session;
use Validator;
use Redirect;
use DB;
use Datatable;
use Auth;
use DateTime;
use Config;

class PlantpropertyController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// load the view
		return View::make('dcms::plantproperty/index');
	}

	public function getDatatable()
	{
		return Datatable::query(DB::connection('project')
																		->table('plants_property')
																		->select(
																							"id",
																							"property_name",
																							(DB::raw('(SELECT property FROM plants_property_language WHERE property_id = plants_property.id LIMIT 1) as value'))
																						)
																		->orderBy('property_name')
																		)
																	->showColumns('id','property_name', 'value')
																	->addColumn('edit',function($model){
																					return '<form method="POST" action="/admin/plants/properties/'.$model->id.'" accept-charset="UTF-8" class="pull-right"> <input name="_token" type="hidden" value="'.csrf_token().'"> <input name="_method" type="hidden" value="DELETE">
																											<a class="btn btn-xs btn-default" href="/admin/plants/properties/'.$model->id.'/edit"><i class="fa fa-pencil"></i></a>
																											<button class="btn btn-xs btn-default" type="submit" value="Delete this plant" onclick="if(!confirm(\'Are you sure to delete this item?\')){return false;};"><i class="fa fa-trash-o"></i></button>
																								</form>';})
																	->searchColumns('property_name')
																	->make();
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$languages = DB::connection("project")
											->table("languages")
											->select((DB::connection("project")
																			->raw("'' as property , '' property_detail_id ")), "id","id as language_id", "language","country","language_name")
											->get();

		// load the create form (app/views/categories/create.blade.php)
		return View::make('dcms::plantproperty/form')
			->with('languages',$languages);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if ($this->validateProperty() === true)
		{
			$Property =	$this->saveProperty();

			// redirect
			Session::flash('message', 'Successfully created Plant!');
			return Redirect::to('admin/plants/properties');
		}else return  $this->validateProperty();
	}

	private function saveProperty($id = null)
	{
		$Property = Plantproperty::find(intval($id));
		if(is_null($Property)) $Property = new Plantproperty;

		$Property->property_name = Input::get('property_name');
		$Property->save();

		foreach(Input::get('property') as $language_id => $value)
		{
			if(empty(trim($value)) && intval(Input::get('property_detail_id.'.$language_id)) > 0 )  Plantpropertydetail::destroy(intval(Input::get('property_detail_id.'.$language_id)));
			if(!empty(trim($value)))
			{
				$Propertydetail = Plantpropertydetail::find(intval(Input::get('property_detail_id.'.$language_id)));
				if(is_null($Propertydetail)) $Propertydetail = new Plantpropertydetail();

				$Propertydetail->language_id = $language_id;
				$Propertydetail->property = trim(Input::get('property.'.$language_id));
				$Propertydetail->property_id = $Property->id;
				$Propertydetail->save();
			}
		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//	get the category
		$Plantproperty = Plantproperty::find($id);

	 	$languages = DB::connection("project")->select('
													SELECT 	language_id,
																	languages.language,
																	languages.country,
																	languages.language_name,
																	plants_property_language.property,
																	plants_property_language.id as property_detail_id
													FROM plants_property_language
													LEFT JOIN languages on languages.id = plants_property_language.language_id
													WHERE  languages.id is not null AND  property_id = ?
													UNION
													SELECT 	languages.id ,
																	language,
																	country,
																	language_name,
																	\'\' ,
																	\'\'
													FROM languages
													WHERE id NOT IN (SELECT language_id FROM plants_property_language WHERE property_id = ?) ORDER BY 1
													', array($id,$id));

		return View::make('dcms::plantproperty/form')
			->with('Plantproperty', $Plantproperty)
			->with('languages',$languages);
	}

	private function validateProperty()
	{
			$rules = array('property_name'=>'required|min:2');

			$validator = Validator::make(Input::all(), $rules);

			// process the validator
			if ($validator->fails()) {
				return Redirect::to('admin/plants/properties/create')
					->withErrors($validator)
					->withInput();
			}
			return true;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if ($this->validateProperty() === true)
		{
			$Property =	$this->saveProperty($id);

			// redirect
			Session::flash('message', 'Successfully updated property!');
			return Redirect::to('admin/plants/properties');
		}else return  $this->validateProperty();
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// delete
		Plantproperty::destroy($id);

		// redirect
		Session::flash('message', 'Successfully deleted the property!');
		return Redirect::to('admin/plants/properties');
	}
}
