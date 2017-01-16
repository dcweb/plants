<?php



Route::group(['middleware' => ['web']], function () {

	Route::group( array("prefix" => "admin"), function() {

    	Route::group(['middleware' => 'auth:dcms'], function() {

    		//plants
    		Route::group( array("prefix" => "plants"), function() {
    			Route::any('api/table', array('as'=>'admin/plants/api/table', 'uses' => 'PlantsController@getDatatable'));
					Route::any('api/tablerow', array('as'=>'admin/plants/api/tablerow', 'uses' => 'PlantsController@getTableRow'));

	    		Route::group( array("prefix" => "properties"), function() {
	    			Route::any('api/table', array('as'=>'admin/plants/properties/api/table', 'uses' => 'PlantpropertyController@getDatatable'));
					});
	    		Route::resource('properties','PlantpropertyController');
    		});
    		Route::resource('plants','PlantsController');
    });
  });
});



 ?>
