<?php

namespace Dcms\Plants\Models;
use Dcms\Core\Models\Languages\Language;

use Dcms\Core\Models\EloquentDefaults;
use \Baum\Node as Node ;


	class Plants extends Node
	{
		protected $connection = 'project';
		protected $table  = "plants";

		public function plantdetail()
		{
			return $this->hasMany('Dcms\Plants\Models\Plantdetail','plant_id','id');
		}

		public function plantsetting()
		{
			return $this->hasMany('Dcms\Plants\Models\Plantsetting','plant_id','id');
		}

		public function plantproperty()
		{
			/*
			The first argument in belongsToMany() is the name of the class Productdata, the second argument is the name of the pivot table, followed by the name of the product_id column, and at last the name of the product_data_id column.
			*/
			return $this->belongsToMany('Dcms\Plants\Models\Plantproperty','plants_to_property','plant_id','plant_property_id');
		}
	}


	class Plantsetting extends EloquentDefaults
	{
		protected $connection = 'project';
	  protected $table  = "plants_setting";

		public function plant()
		{
			return $this->belongsTo('Dcms\Plants\Models\Plants','plant_id','id');
		}
	}


	class Plantdetail extends EloquentDefaults
	{
		protected $connection = 'project';
	  protected $table  = "plants_language";

		public function plant()
		{
			return $this->belongsTo('Dcms\Plants\Models\Plants','plant_id','id');
		}

		public function plantcategory()
		{
			return $this->belongsTo('Dcms\Plants\Models\Plantcategories','category_id','id');
		}

		public function language()
		{
			return $this->belongsTo('Dcms\Core\Models\Languages\Language','language_id','id');
		}
	}

	class Plantproperty extends EloquentDefaults
	{
		protected $connection = 'project';
	  protected $table  = "plants_property";

		public function plantpropertydetail()
		{
			return $this->hasMany('Dcms\Plants\Models\Plantpropertydetail','property_id','id');
		}
	}

	class Plantpropertydetail extends EloquentDefaults
	{
		protected $connection = 'project';
	  protected $table  = "plants_property_language";

		public function Plantproperty()
		{
			return $this->belongsTo('Dcms\Plants\Models\Plantproperty','property_id','id');
		}
	}
/*
	class Plantcategory extends EloquentDefaults
	{
		protected $connection = 'project';
	  protected $table  = "plants_categories";

		public function plantcategorydetail()
		{
			  return $this->belongsTo('Dcms\Plants\Models\Plantcategorydetail','id');
		}

		public function plants()
    {
        return $this->hasMany('Dcms\Plants\Models\Plant', 'category_id', 'id');
    }
	}

	class Plantcategorydetail extends EloquentDefaults
	{
		protected $connection = 'project';
	  protected $table  = "plants_categories_language";

		public function plantcategory()
		{
			return $this->belongsTo('Dcms\Plants\Models\Plantcategory','category_id','id');
		}

		public function language()
		{
			return $this->belongsTo('Dcms\Core\Models\Languages\Language','language_id','id');
		}
	}*/
