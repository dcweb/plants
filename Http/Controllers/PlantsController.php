<?php

namespace Dcms\Plants\Http\Controllers;

use Dcms\Plants\Models\Plants;
use Dcms\Plants\Models\Plantdetail;
use Dcms\Plants\Models\Plantcategory;
use Dcms\Plants\Models\Plantcategorydetail;
use Dcms\Plants\Models\Plantproperty;
use Dcms\Plants\Models\Plantpropertydetail;
use Dcms\Plants\Models\Plantsetting;

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


class PlantsController extends Controller {

	public static function QueryTree()
	{
		$tree = DB::connection('project')
															->table('plants as node')
															->select(
																				(DB::connection("project")->raw("CONCAT( REPEAT( '-', node.depth ), node.family_name) AS category")),
																				"node.id",
																				"node.parent_id",
																				"node.depth"
																				//(DB::connection("project")->raw('Concat("<img src=\'/packages/dcweb/dcms/assets/images/flag-",country,".png\' >") as regio'))
																			)
															->orderBy('node.lft')
															->get();
		return $tree;
	}

	public static function CategoryDropdown($models = null,$selected_id = null, $enableNull = true, $name="parent_id", $key = "id",$value="category")
	{
		$dropdown = "empty set";
		if(!is_null($models) && count($models)>0)
		{
			$dropdown = '<select name="'.$name.'" class="form-control" id="parent_id">'."\r\n";

			if($enableNull == true)	$dropdown .= '<option value="">None</option>'; //epty value will result in NULL database value;

			foreach($models as $model)
			{
				$selected = "";
				if(!is_null($selected_id) && $selected_id == $model->$key) $selected = "selected";

				//altering these tag properties can affect the form (jQuery)
				$dropdown .= '<option '.$selected.' value="'.$model->$key.'" class="'.$name.' parent-'.(is_null($model->parent_id)?0:$model->parent_id).' depth-'.$model->depth.'">'.$model->$value.'</option>'."\r\n";
			}
			$dropdown .= '</select>'."\r\n"."\r\n";
		}
		return $dropdown;
	}

	public function getSettings($plantid = null)
	{
		$Plant->plantsetting()->get();
	}

	public function getProperties($plantid = null)
	{
		$oProperties = DB::connection('project')->select("SELECT
																												plants_property.id,
																												plants_property.id as property_id,
																												plants_property.property_name,
																												(SELECT property FROM plants_property_language WHERE property_id = plants_property.id LIMIT 1) as property_language,
																												case when exists(SELECT plant_id FROM plants_to_property WHERE plant_id =  ? AND plant_property_id = plants_property.id) then 1 else 0 end as selected
																											FROM
																												plants_property
																											ORDER BY
																												plants_property.property_name,
																												4",array(intval($plantid))
																								);

			return $oProperties;
	}



	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// load the view
		return View::make('dcms::plants/index');
	}


	public function getDatatable()
	{
		return Datatable::query(DB::connection('project')
																		->table('plants as node')
																		->select(
																							(DB::connection("project")->raw("CONCAT( REPEAT( '-', node.depth ), node.family_name) AS family_name")),
																							"node.id",
																							"plants_language.common_name",
																							(DB::connection("project")->raw('Concat("<img src=\'/packages/dcms/core/images/flag-",lcase(country),".png\' >") as country'))
																						)
																		->leftjoin('plants_language','node.id','=','plants_language.plant_id')
																		->leftjoin('languages','plants_language.language_id','=','languages.id')
																		//->orderBy('node.lft')
																		->orderBy('node.lft')
																		)
																	->showColumns('id','family_name', 'common_name','country')
																	->addColumn('edit',function($model){
																					return '<form method="POST" action="/admin/plants/'.$model->id.'" accept-charset="UTF-8" class="pull-right"> <input name="_token" type="hidden" value="'.csrf_token().'"> <input name="_method" type="hidden" value="DELETE">
																											<a class="btn btn-xs btn-default" href="/admin/plants/'.$model->id.'/edit"><i class="fa fa-pencil"></i></a>
																											<button class="btn btn-xs btn-default" type="submit" value="Delete this plant" onclick="if(!confirm(\'Are you sure to delete this item?\')){return false;};"><i class="fa fa-trash-o"></i></button>
																								</form>';})
																	->searchColumns('family_name','common_name' )
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
												->select((DB::connection("project")->raw("'' as family_name, '' as plant_detail_id,  '' as plant, '' as description, '' as image")), "id","id as language_id", "language","country","language_name")->get();

		// load the create form (app/views/categories/create.blade.php)
		return View::make('dcms::plants/form')
			->with('languages',$languages)
			->with('oProperties',$this->getProperties())
			->with('parentplants',$this->CategoryDropdown($this->QueryTree()));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if ($this->validatePlantForm() === true)
		{
			$Plant =	$this->savePlantProperties();
			$this->savePlantDetail($Plant);
			$this->savePropertyToPlant($Plant,(Input::has('multiproperty_id')?Input::get('multiproperty_id'):array()));
			$this->savePlantSetting($Plant,(Input::has('setting')?Input::get('setting'):array()));

			// redirect
			Session::flash('message', 'Successfully created Plant!');
			return Redirect::to('admin/plants');
		}else return  $this->validatePlantForm();
	}


	private function savePlantProperties($plantid = null)
	{
		$newPlant = true;
		// do check if the given id is existing.
		if(!is_null($plantid) && intval($plantid)>0) $Plant = Plants::find($plantid);

		if(!isset($Plant) || is_null($Plant)) $Plant = new Plants; else $newPlant = false;

		$Plant->family_name 	= Input::get('family_name');
		$Plant->genus_name 		= Input::get('genus_name');
		$Plant->epithet_name 	= Input::get('epithet_name');
		$Plant->cultivar_name = Input::get('cultivar_name');
		$Plant->description_3 = Input::get('description_3');
		$Plant->description_4 = Input::get('description_4');
		$Plant->origin_2 			= Input::get('origin_2');
		$Plant->height_min 		= Input::get('height_min');
		$Plant->height_max 		= Input::get('height_max');
		$Plant->evergreen 		= (Input::has('evergreen') && Input::get('evergreen') == '1')?1:0;
		$Plant->planting_depth_min = Input::get('planting_depth_min');
		$Plant->planting_depth_max = Input::get('planting_depth_max');
		$Plant->latitude 			= Input::get('latitude');
		$Plant->longitude 		= Input::get('longitude');
		$Plant->comment_1 		= Input::get('comment_1');
		$Plant->comment_2 		= Input::get('comment_2');
		$Plant->online 				= (Input::has('online') && Input::get('online') == '1')?1:0;

		$Plant->save();

		$makechild = false;
		$makeroot = false;
		$theParentid = null;

		//moving a parent up a tree is not neccesary we only sort the plants by name not by occurance in a tree $node->moveToLeftOf()
		if(intval(Input::get('parent_id'))>0 && intval(Input::get('parent_id')) <> $Plant->parent_id && intval(Input::get('parent_id')) <> $Plant->id  )
		{
			$makechild = true;
			$theParentid = intval(Input::get('parent_id'));
		}elseif(intval(Input::get('parent_id')) <= 0  &&  Input::get('parent_id') <> $Plant->parent_id && intval(Input::get('parent_id')) <> $Plant->id	)
		{
			$makeroot = true;
		}

		if($makeroot == true) $Plant->makeRoot();
		if($makechild == true) $Plant->makeChildOf($theParentid);

		return $Plant;
	}

	private function savePlantDetail(Plants $Plant, $givenlanguage_id = null)
	{
		$input = Input::get();

		$Plantdetail = null;

		foreach($input["common_name"] as $language_id => $title)
		{
			if ((is_null($givenlanguage_id) || ($language_id == $givenlanguage_id)) &&  (strlen(trim($input['common_name'][$language_id]))>0))
			{
				$Plantdetail = null; // reset when in a loop
				$newDetail = true;

				if(intval($input["plant_detail_id"][$language_id]) > 0 ) $Plantdetail = Plantdetail::find($input["plant_detail_id"][$language_id]);
				if(!isset($Plantdetail) || is_null($Plantdetail)) $Plantdetail = new Plantdetail; else $newDetail = false;

				$Plantdetail->language_id 	= $language_id;
				$Plantdetail->common_name		= $input["common_name"][$language_id];
				$Plantdetail->description_1 = $input["description_1"][$language_id];
				$Plantdetail->description_2 = $input["description_2"][$language_id];
				$Plantdetail->origin_1 			= $input["origin_1"][$language_id];
				$Plantdetail->bark 					= $input["bark"][$language_id];
				$Plantdetail->slug 					= str_slug($Plantdetail->common_name);


				$Plantdetail->save();
				Plants::find($Plant->id)->plantdetail()->save($Plantdetail);
			}
			elseif(isset($input["plant_detail_id"][$language_id]) && intval($input["plant_detail_id"][$language_id])>0)
			{
				$this->destroydetail($input["plant_detail_id"][$language_id]);
			}
		}

		return $Plantdetail;
	}

	private function savePropertyToPlant($Plant,$aProperty = array())
	{

		$Plant->plantproperty()->detach();
		if(count($aProperty)>0)
		{
			foreach($aProperty as $sPropertyName => $aIndexes)
			{
				foreach($aIndexes as $iProperty_id)
				{
					$oProperty = Plantproperty::find($iProperty_id);

					if(is_null($oProperty))
					{
						//create the property
						$oProperty = new Plantproperty();
						$oProperty->property_name = $sPropertyName;
						$oProperty->save();

						//what about the detail
						$oPropertydetail = new Plantpropertydetail();
						$oPropertydetail->language_id = 1;
						$oPropertydetail->property_id = $oProperty->id;
						$oPropertydetail->property = $sPropertyName." dummyvalue";
					}

					//attach the new/existing property to the plant
					$Plant->plantproperty()->attach($oProperty->id);
				}
			}
		}
	}

	public function savePlantSetting($Plant,$aSettingArray = array())
	{
		debug($aSettingArray);
		$keepkeys = array();
		if(count($aSettingArray)>0)
		{

			foreach($aSettingArray as $settingID => $settingvalue)
			{
				if(!empty(trim($settingvalue['value'])))
				{
					$Plantsetting = Plantsetting::find($settingID);
					if(is_null($Plantsetting)) $Plantsetting = new Plantsetting();
					$Plantsetting->plant_id = $Plant->id;
					$Plantsetting->name = "image";
					$Plantsetting->value = trim($settingvalue['value']);
					$Plantsetting->save();
					$keepkeys[] = $Plantsetting->id;
				}
				else
				{
					$keytofind = array_search($settingID,$keepkeys);
					unset( $keytofind,$keepkeys );
				}
			}
		}
		if(count($keepkeys)>0) Plantsetting::where('plant_id','=',$Plant->id)->whereNotIn('id',$keepkeys)->delete();
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
		$Plant = Plants::find($id);

	 	$languages = DB::connection("project")->select('
													SELECT language_id, languages.language, languages.country, languages.language_name, plants.family_name, plants_language.id as plant_detail_id,  plants_language.plant_id,
													plants_language.common_name,  plants_language.description_1, plants_language.description_2, plants_language.origin_1, plants_language.bark,  plants.comment_1, plants.comment_2
													FROM plants_language
													LEFT JOIN plants on plants_language.plant_id = plants.id
													LEFT JOIN languages on languages.id = plants_language.language_id
													WHERE  languages.id is not null AND  plant_id = ?
													UNION
													SELECT languages.id , language, country, language_name, \'\' ,\'\' ,\'\' ,\'\'  ,\'\'  ,\'\' ,\'\',\'\',\'\',\'\'
													FROM languages
													WHERE id NOT IN (SELECT language_id FROM plants_language WHERE plant_id = ?) ORDER BY 1
													', array($id,$id));

		return View::make('dcms::plants/form')
			->with('Plant', $Plant)
			->with('languages',$languages)
			->with('Pricerows', $this->getImageRow($Plant->plantsetting()->get()))
			->with('oProperties',$this->getProperties($id))
			->with('parentplants',$this->CategoryDropdown($this->QueryTree(),$Plant->parent_id));
	}

	private function validatePlantForm()
	{
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
		if ($this->validatePlantForm() === true)
		{
			$Plant =	$this->savePlantProperties($id);
			$this->savePlantDetail($Plant);
			$this->savePropertyToPlant($Plant,(Input::has('multiproperty_id')?Input::get('multiproperty_id'):array()));
			$this->savePlantSetting($Plant,(Input::has('setting')?Input::get('setting'):array()));

			// redirect
			Session::flash('message', 'Successfully updated Plant!');
			return Redirect::to('admin/plants');
		}else return  $this->validatePlantForm();
	}

	public function destroydetail($id)
	{
		Plantdetail::destroy($id);
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
		$Plant = Plants::find($id);
		Plantdetail::where('plant_id','=',$id)->delete();
		$Plant->destroy($id);

		// redirect
		Session::flash('message', 'Successfully deleted the Plant!');
		return Redirect::to('admin/plants');
	}

	public function getTableRow()
	{
		if (Input::get("data") === "image")
		{
			return $this->getImageRow(null, true);
		}
	}


	/**
	 * $mDefaults contains an array of Price-Models
	 *
	 * @return the row to inject prices
	 */
	public static function getImageRow($mDefaults=array(),$forceEmpty = false)
	{
		$rowstring = "";

		$openbody = true;
		$closebody = true;
		if ($forceEmpty === true && empty($mDefaults) === true)
		{
			$openbody = false;
			$closebody = false;
			$mDefaults[] = (object) array();
		}

		foreach($mDefaults as $Setting)
		{
			if ($openbody === true ) $rowstring .= '<tbody >';

			//------------------------------------------------------------------------
			// 							TEMPLATE FOR THE PRICE ROW
			// 		the {INDEX} tag will be replaced in the form.blade, and this script to the attachment database id - or some text to identify its new
			//------------------------------------------------------------------------

			//you can easily add a setting name to an input array
			$rowstring .= ' <tr>
												<td>
													<label for="setting{INDEX}value">'.(isset($Setting->name)?$Setting->name:"image").'</label>
												</td>

												<td>
													<input class="form-control" name="setting[{INDEX}][value]" type="text" value="'.(isset($Setting->value)?$Setting->value:"").'" id="setting{INDEX}value">
													<span class="input-group-btn">
															<button class="btn btn-primary browse-server-images" id="browse_setting{INDEX}value" type="button">Browse Files</button>
														</span>
												</td>

												<td><a class="btn btn-default pull-right delete-table-row" href=""><i class="fa fa-trash-o"></i></a></td>
											</tr>';

			if (isset($Setting->id) && intval($Setting->id)>0) $rowstring = str_replace("{INDEX}",$Setting->id,$rowstring);
			$openbody = false;
		}
		if ($closebody === true) $rowstring .= '</tbody>';

		return $rowstring;
	}
}
