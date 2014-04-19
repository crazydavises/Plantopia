<?php
/*
Plugin Name: Plantopia 
Plugin URI: 
Description: A Wiki Database of plants
Version: 0.1
Author: Heidi Beckwith 
Author URI: http://backyardpermaculture.com
*/  

/* global to the website variables */

global $plantopia_db_version;
$plantopia_db_version = 1.0;
/*******************************************************************************************/
/*******************************************************************************************/
class Plantopia
{		
	/* global to the program variables */
	var $dbInit = false;
		
	function __construct()
	{
		/* actions happen automatically */
		add_action( 'init', array( $this, 'InitDB' ) ); 		
        /* shortcodes are things that can be called from a particular page or post, without action by the user */
		add_shortcode( 'LoadSearch', array( $this, 'LoadSearchPage' ) );
	}
/*******************************************************************************************/
	function InitDB()
	{
		 /* General tip: put anything you want to display into a string called $output, and return that */
		$output = '';
		/* you probably want to create a database user that can only select and insert (and maybe modify) and use that */
		$this->plantDB = new wpdb('heibec', 'truelovewaits', 'plant_characteristics', 'mysql.almost-utopia.com');
	    $this->plantDB->show_errors();
		
		$dbInit = true;
		/* we don't need to display anything from InitDB */
		return $output;
	}
/*******************************************************************************************/
	function AddGeneral($common_name, $latin_name, $family, $resources_for_more_info, $alternate_name_language, $alternate_names, $variety_name, $tips )
	{

		$this->plantDB->insert( 'General', 
		array( 'common_name' => $common_name, 
		'latin_name'=>$latin_name, 
		'family' => $family, 
		'resources_for_more_info' => $resources_for_more_info),
		array('%s', '%s', '%s', '%s') ); 

	$this->plantDB->insert( 'alternate_names', 
		array( 'PlantID' => $plantID,  
		'alternate_name_language' => $alternate_name_language, 
		'alternate_names'=>$alternate_names),
		array('%s', '%s') );

		$this->plantDB->insert( 'varieties', 
		array( 'PlantID' => $plantID,  
		'variety_name' => $variety_name),
		array('%s') );


	$this->plantDB->insert( 'tips', 
		array( 'PlantID' => $plantID,  
		'Tips' => $Tips),
		array('%s'));


		
		$plantID = $this->plantDB->insert_id; 
		
		return $plantID;

	}
/*******************************************************************************************/
	function AddRegionalCharacteristics( $plantID, $hardy_min, $hardy_max, $sunset_zone, $chill_min, $chill_max, $heat_min, $heat_max, $frost_free_days, $sunlight_hours, $Koppen_climate_code)
	{

		$this->plantDB->insert( 'regional_characteristics', 
		array( 'PlantID' => $plantID,  
		'hardiness_zone_min'=>$hardy_min, 
		'hardiness_zone_max' => $hardy_max,
		'Sunset_zones' => $sunset_zone,
		'chill_hours_min' => $chill_min,
		'chill_hours_max' => $chill_max,
		'heat_zone_min' => $heat_min, 
		'heat_zone_max' => $heat_max,
		'frost_free_days_needed' => $frost_free_days,
		'sunlight_hours_for_fruiting' => $sunlight_hours ),
		array('%d', '%d', '%s', '%d', '%d', '%d', '%d', '%d', '%d') );
	
		$this->plantDB->insert( 'koppen_climate_code', 
		array( 'PlantID' => $plantID,  
		'Koppen_climate_code' => $Koppen_climate_code),
		array('%s') );

	}
/*******************************************************************************************/
function AddHarvesting( $maximum_bearing_lbs, $harvest_time_days_after_last_frost_min, $harvest_time_days_after_last_frost_max, $seedless_fruits, $years_until_first_bearing, $years_until_full_bearing, $storageability, $ease_of_harvest, $fruiting_frequency_other, $fruiting_frequency, $fruit_color, $fruit_type )
	{

		$this->plantDB->insert( 'harvesting', 
		array( 'PlantID' => $plantID,  
		'maximum_bearing_lbs' => $maximum_bearing_lbs, 
		'harvest_time_days_after_last_frost_min' => $harvest_time_days_after_last_frost_min, 
		'harvest_time_days_after_last_frost_max' => $harvest_time_days_after_last_frost_max, 
		'seedless_fruits' => $seedless_fruits, 
		'years_until_first_bearing' => $years_until_first_bearing, 
		'years_until_full_bearing' => $years_until_full_bearing, 
		'storageability' => $storageability, 
		'ease_of_harvest' => $ease_of_harvest), 
	array('%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d') );

$this->plantDB->insert( 'fruit_color', 
		array( 'PlantID' => $plantID,  
		'fruit_color' => $fruit_color),
		array('%s') );

$this->plantDB->insert( 'fruit_type', 
		array( 'PlantID' => $plantID,  
		'fruit_type' => $fruit_type),
		array('%s') );

$this->plantDB->insert( 'fruiting_frequency', 
		array( 'PlantID' => $plantID,  
		'fruiting_frequency' => $fruiting_frequency,
'fruiting_frequency_other' => $fruiting_frequency_other),
		array('%s','%s') );

	
	}
/*******************************************************************************************/
	function AddPhysicalCharacteristics($plantID, $Alleopathic, $Thorns, $epiphyte_attractive, $percentage_shade_underneath, $growth_speed, $branch_strength, $branch_strength, $fire_resistance, $after_harvest_regrowth_rate_inches_per_month, $mature_size_max, $blocks_alleopathy, $mature_size_min, $life_span_minimum, $life_span_maximum, $life_span_classifications, $flower_color, $root_characteristics, $plant_shape, $leaf_color, $fall_leaf_color, $leaf_drop, $toxicity, $other_problems)
	{

$this->plantDB->insert( 'leaf_characteristics', 
		array( 'PlantID' => $plantID,  
		'leaf_drop' => $leaf_drop,
		'fall_leaf_color' => $fall_leaf_color,
		'leaf_color' => $leaf_color), 
		array('%s', '%s', '%s') );

$this->plantDB->insert( 'plant_shape', 
		array( 'PlantID' => $plantID,  
		'plant_shape' => $plant_shape), 
		array('%s') ); 

$this->plantDB->insert( 'root_characteristics', 
		array( 'PlantID' => $plantID,  
		'root_characteristics' => $root_characteristics),
		array('%s') );

$this->plantDB->insert( 'flower_color', 
		array( 'PlantID' => $plantID,  
		'flower_color' => $flower_color),
		array('%s') );

		$this->plantDB->insert( 'physical_characteristics', 
		array( 'PlantID' => $plantID,  
		'Alleopathic' => $Alleopathic, 
		'Thorns' => $_POST["Thorns"], 
		'epiphyte_attractive' => $epiphyte_attractive, 
		'percentage_shade_underneath' => $_POST["percentage_shade_underneath"], 
		'growth_speed' => $growth_speed, 
		'branch_strength' => $branch_strength, 
		'fire_resistance' => $fire_resistance, 
		'after_harvest_regrowth_rate_inches_per_month' => $_POST["after_harvest_regrowth_rate_inches_per_month"], 
		'mature_size_max' => $mature_size_max, 
		'blocks_alleopathy' => $blocks_alleopathy, 
		'mature_size_min' => $mature_size_min), 
	array('%s', '%s', '%s', '%d', '%s', '%s', '%s', '%d', '%d','%s','%d') );


$this->plantDB->insert( 'life_span', 
		array( 'PlantID' => $plantID,  
		'life_span_minimum' => $life_span_minimum,
		'life_span_maximum' => $life_span_maximum), 
		array('%d','%d') );


$this->plantDB->insert( 'life_span_classifications', 
		array( 'PlantID' => $plantID,  
		'life_span_classifications' => $life_span_classifications), 
		array('%s') );


$this->plantDB->insert( 'problems', 
		array( 'PlantID' => $plantID,  
		'toxicity' => $toxicity,
'other_problems' => $other_problems),
		array('%s','%s') );


	}
/*******************************************************************************************/


					
function AddConsumption( $plantID, $other_edible_for, $edible_for, $human_edibility, $other_edible_uses, $edible_uses)
	{


$this->plantDB->insert( 'Human_Consumption', 
		array( 'PlantID' => $plantID,  
			'edible_uses' => $edible_uses,
			'other_edible_uses' => $other_edible_uses,
			'human_edibility' => $human_edibility),
		array('%s','%s','%s') );


$this->plantDB->insert( 'livestock_edibility', 
		array( 'PlantID' => $plantID,  
			'edible_for' => $edible_for,
			'other_edible_for' => $other_edible_for),
		array('%s','%s') );

		
	}	

/*******************************************************************************************/
 


					
function AddProcessing( $plantID, $other_vegetable_processes, $vegetable_processes, $other_fruit_processing, $fruit_processing, $alcohol_processes_resources, $description_alcohol_processes_tools, $alcohol_processes, $alcohol_processes_resources)
	{



$this->plantDB->insert( 'alcohol_making', 
		array( 'PlantID' => $plantID,  
		'alcohol_processes' => $alcohol_processes,
'description_alcohol_processes_tools' => $description_alcohol_processes_tools,
'alcohol_processes_resources' => $alcohol_processes_resources),
		array('%s','%s','%s') );

$this->plantDB->insert( 'fruit_processing', 
		array( 'PlantID' => $plantID,  
		'fruit_processing' => $fruit_processing,
'other_fruit_processing' => $other_fruit_processing),
		array('%s','%s') );


$this->plantDB->insert( 'vegetable_processing', 
		array( 'PlantID' => $plantID,  
		'vegetable_processes' => $vegetable_processes,
		'other_vegetable_processes' => $other_vegetable_processes),
		array('%s','%s') );

		
	}	

/*******************************************************************************************/
 

					
function AddMedicinals( $plantID, $medicinal_uses, $other_medicinal_uses, $medicinaluseskey, $medicine_processes_resources, $medicine_processes_other, $medicine_processes)
	{


$this->plantDB->insert( 'medicine_processes', 
		array( 'PlantID' => $plantID,  
			'medicine_processes' => $medicine_processes,
			'medicine_processes_other' => $medicine_processes_other,
			'medicine_processes_resources' => $medicine_processes_resources),
		array('%s','%s','%s') );


$this->plantDB->insert( 'medicinal_uses', 
		array( 'PlantID' => $plantID,  
			'other_medicinal_uses' => $other_medicinal_uses,
'medicinaluseskey' => $medicinaluseskey),
		array('%s','%d') );


$this->plantDB->insert( 'medicinal_uses_description', 
		array( 'PlantID' => $plantID,  
			'medicinal_uses' => $medicinal_uses),
		array('%s') );



	}	

/*******************************************************************************************/
 
					
function AddIncomeStreams( $plantID, $market_resource_website, $zipcode_of_current_market, $country_of_current_market, $marketing_strategies, $other_marketing_strategies)
	{


$this->plantDB->insert( 'profitability_of_crops', 
		array( 'PlantID' => $plantID,  
		'market_resource_website' => $market_resource_website,
'zipcode_of_current_market' => $zipcode_of_current_market,
'country_of_current_market' => $country_of_current_market),
		array('%s','%s','%s') );
	

$this->plantDB->insert( 'marketing_strategies', 
		array( 'PlantID' => $plantID,  
		'marketing_strategies' => $marketing_strategies,
'other_marketing_strategies' => $other_marketing_strategies),
		array('%s','%s') );

	}	

/*******************************************************************************************/


function AddPropagation( $plantID, $other_grafting_method, $grafting_methods, $seeds_per_pound, $country, $seedling_vigor, $seed_size_in_mm, $seed_color, $seed_shape, $light_requirements_hours_per_day, $time_to_germination, $time_to_germination, $percentage_germination, $transplantability, $seed_resources, $seeding_instructions, $plant_propagation_method, $plant_propagation_tips)
	{


$this->plantDB->insert( 'seeds', 
		array( 'PlantID' => $plantID,  
		'seeds_per_pound' => $seeds_per_pound, 
		'country' => $country, 
		'seedling_vigor' => $seedling_vigor, 
		'seed_size_in_mm' => $seed_size_in_mm, 
		'seed_color' => $seed_color, 
		'seed_shape' => $seed_shape, 
		'light_requirements_hours_per_day' => $light_requirements_hours_per_day, 
		'time_to_germination' => $time_to_germination, 
		'percentage_germination' => $percentage_germination, 
		'transplantability' => $transplantability, 
		'seed_resources' => $seed_resources,
		'seeding_instructions' => $seeding_instructions), 
	array('%d', '%s', '%s', '%d', '%s', '%s', '%d', '%d', '%d','%s','%s','%s') );


$this->plantDB->insert( 'Plant_propagations_methods', 
		array( 'PlantID' => $plantID,  
		'plant_propagation_method' => $plant_propagation_method),
		array('%s') );

$this->plantDB->insert( 'plant_propagation_tips', 
		array( 'PlantID' => $plantID,  
		'plant_propagation_tips' => $plant_propagation_tips),
		array('%s') );


$this->plantDB->insert( 'grafting_methods', 
		array( 'PlantID' => $plantID,  
		'grafting_methods' => $grafting_methods,
'other_grafting_method' => $other_grafting_method),
		array('%s','%s') );


	}	

/*******************************************************************************************/


function AddPlantFunctions( $plantID, $non_food_use_other, $nonfoodusekey, $Non_food_Use, $nutrient_fixing, $CN_ratio_dried_plant, $CN_ratio_fresh_plant, $biodynamic_accumulator_mulch_plant, $lumber_usage, $mushroom_substrate, $mushroom_substrate_species, $beauty_products, $other_beauty_products, $pollutant_cleaning_capabilities, $sap_use, $other_sap_use)
	{

$this->plantDB->insert( 'nonfood_use', 
		array( 'PlantID' => $plantID,  
			'non_food_use_other' => $non_food_use_other,
'nonfoodusekey' => $nonfoodusekey),
		array('%s','%d') );

$this->plantDB->insert( 'nonfood_use_description', 
		array( 'PlantID' => $plantID,  
			'Non_food_Use' => $Non_food_Use),
		array('%s') );

$this->plantDB->insert( 'nutrient_fixing', 
		array( 'PlantID' => $plantID,  
			'nutrient_fixing' => $nutrient_fixing),
		array('%s') );

$this->plantDB->insert( 'compost', 
		array( 'PlantID' => $plantID,  
			'CN_ratio_dried_plant' => $CN_ratio_dried_plant,
			'CN_ratio_fresh_plant' => $CN_ratio_fresh_plant,
			'biodynamic_accumulator_mulch_plant' => $biodynamic_accumulator_mulch_plant),
		array('%s','%s','%s') );


$this->plantDB->insert( 'lumber_useage', 
		array( 'PlantID' => $plantID,  
			'lumber_usage' => $lumber_usaage,
			'other_lumber_use' => $other_lumber_use),
		array('%s','%s') );

$this->plantDB->insert( 'mushroom_substrate', 
		array( 'PlantID' => $plantID,  
			'mushroom_substrate' => $mushroom_substrate,
			'mushroom_substrate_species' => $mushroom_substrate_species),
		array('%s','%s') );


$this->plantDB->insert( 'beauty_products', 
		array( 'PlantID' => $plantID,  
			'beauty_products' => $beauty_products,
			'other_beauty_products' => $other_beauty_products),
		array('%s','%s') );

$this->plantDB->insert( 'pollutant_cleaning', 
		array( 'PlantID' => $plantID,  
			'pollutant_cleaning_capabilities' => $pollutant_cleaning_capabilities),
		array('%s') );

$this->plantDB->insert( 'sap_use', 
		array( 'PlantID' => $plantID,  
			'sap_use' => $sap_use,
			'other_sap_use' => $other_sap_use),
		array('%s','%s') );




	}	

/*******************************************************************************************/





function AddHabitatandCommunity($plantID, $plant_functions_in_environment, $layers_plant_type, $other_plant_guilds, $plantguildskey, $plant_guilds, $landscape_application, $other_landscape_application, $soil_content_preferences, $other_content_preferences, $tolerates_drought, $erosion_control_use, $juglone_tolerant, $pollution_tolerant, $storm_water_retention, $soil_salinity_tolerant, $sun_tolerance_hrs, $altitude_preference_min, $rooftop_garden, $container_plant, $altitude_preference_max, $terrarium, $tolerates_flooding, $hedge_wind_control, $compact_soil_breaker, $coppiceable_poulardable, $native_habitat, $nativehabitatkey)

{ 
$this->plantDB->insert( 'plant_functions_in_environment_descriptions', 
		array( 'PlantID' => $plantID,  
			'plant_functions_in_environment' => $plant_functions_in_environment),
		array('%s'));

$this->plantDB->insert( 'layers_plant_type', 
		array( 'PlantID' => $plantID,  
			'layers_plant_type' => $layers_plant_type),
		array('%s') );


$this->plantDB->insert( 'plant_guilds', 
		array( 'PlantID' => $plantID,  
			'other_plant_guilds' => $other_plant_guilds,
'plantguildskey' => $plantguildskey),
		array('%s','%d') );



$this->plantDB->insert( 'plant_guilds_descriptions', 
		array( 'PlantID' => $plantID,  
			'plant_guilds' => $plant_guilds),
		array('%s') );


$this->plantDB->insert( 'landscape_application', 
		array( 'PlantID' => $plantID,  
			'landscape_application' => $landscape_application,
			'other_landscape_application' => $other_landscape_application),
		array('%s','%s') );

	
$this->plantDB->insert( 'soil_content_preferences', 
		array( 'PlantID' => $plantID,  
		'soil_content_preferences' => $soil_content_preferences,
		'other_content_preferences' => $other_content_preferences),
		array('%s','%s') );


$this->plantDB->insert( 'habitat_preferences', 
		array( 'PlantID' => $plantID,  
	'tolerates_drought' => $tolerates_drought,
	'erosion_control_use' => $erosion_control_use,
	'juglone_tolerant' => $juglone_tolerant,
	'pollution_tolerant' => $pollution_tolerant,
	'storm_water_retention' => $storm_water_retention,
	'soil_salinity_tolerant' => $soil_salinity_tolerant,
	'sun_tolerance_hrs' => $sun_tolerance_hrs,
	'shade_tolerance_hrs' => $shade_tolerance_hrs,
	'altitude_preference_min' => $altitude_preference_min,
	'rooftop_garden' => $rooftop_garden,
	'container_plant' => $container_plant,
	'altitude_preference_max' => $altitude_preference_max,
	'terrarium' => $terrarium,
	'tolerates_flooding' => $tolerates_flooding,
	'hedge_wind_control' => $hedge_wind_control,
	'compact_soil_breaker' => $compact_soil_breaker,
	'coppiceable_poulardable' => $coppiceable_poulardable,
	'indication_of' => $indication_of ),
	array('%s','%s','%s','%s','%s','%s','%d','%d','%d','%s','%s','%d','%s','%s','%s','%s','%s','%s') );

$this->plantDB->insert( 'plant_native_habitat_descriptions', 
		array( 'PlantID' => $plantID,  
			'native_habitat' => $native_habitat),
		array('%s') );


$this->plantDB->insert( 'plant_native_habitat', 
		array( 'PlantID' => $plantID,  
			'nativehabitatkey' => $nativehabitatkey),
		array('%d') );
		}	

/*******************************************************************************************/




function AddDiseases($plantID, $plant_diseases_other, $plant_diseaseskey, $plant_diseaseskey, $disease_treatments_description, $disease_treatments_resources)
{
	
$this->plantDB->insert( 'plant_diseases', 
		array( 'PlantID' => $plantID,  
		'plant_diseases_other' => $plant_diseases_other,
		'plant_diseaseskey' => $plant_diseaseskey),
		array('%s','%d') );

$this->plantDB->insert( 'plant_diseases_description', 
		array( 'PlantID' => $plantID,  
		'plant_diseases' => $plant_diseases),
		array('%s') );


$this->plantDB->insert( 'disease_treatments', 
		array( 'PlantID' => $plantID,  
		'disease_treatments_description' => $disease_treatments_description,
'disease_treatments_resources' => $disease_treatments_resources),
		array('%s','%s') );
}


/*******************************************************************************************/


function AddMaintenance($plantID, $fruiting_habit, $other_fruiting_habit, $litter_type, $other_litter_type, $propagation_control_methods, $other_propagation_control_methods, $growth_season, $extra_watering_needed, $extra_observation_needed, $vegetable_season) 


{
$this->plantDB->insert( 'fruiting_habit', 
		array( 'PlantID' => $plantID,  
		'fruiting_habit' => $fruiting_habit,
'other_fruiting_habit' => $other_fruiting_habit),
		array('%s','%s') );

$this->plantDB->insert( 'litter_type', 
		array( 'PlantID' => $plantID,  
		'litter_type' => $litter_type,
'other_litter_type' => $other_litter_type),
		array('%s','%s') );

$this->plantDB->insert( 'propagation_control_methods', 
		array( 'PlantID' => $plantID,  
		'propagation_control_methods' => $propagation_control_methods,
		'other_propagation_control_methods' => $other_propagation_control_methods ),
		array('%s','%s') );

$this->plantDB->insert( 'seasonal_growth_and_watering', 
		array( 'PlantID' => $plantID,  
		'growth_season' => $growth_season,
		'extra_watering_needed' => $extra_watering_needed,
	'extra_observation_needed' => $extra_observation_needed,
'first_sap' => $first_sap,
'first_leaf' => $first_leaf),
		array('%s','%s','%s','%s','%s') );

$this->plantDB->insert( 'vegetable_season', 
		array( 'PlantID' => $plantID,  
		'vegetable_season' => $vegetable_season),
		array('%s') );

}


/*******************************************************************************************/


function AddAttractionandrepulsion($plantID, $Deterrence_characteristics, $other_deterrence, $flowering_time_min, $flowering_time_max, $beneficial_insect_laying, $beneficial_insect_nectar_or_food, $beneficial_insect_shelter, $predators_scientificname, $predators_commonname, $pests_scientificname, $pests_commonname )

{
$this->plantDB->insert( 'Deterrence', 
		array( 'PlantID' => $plantID,  
		'Deterrence_characteristics' => $Deterrence_characteristics,
		'other_deterrence' => $other_deterrence),
		array('%s','%s') );

$this->plantDB->insert( 'Attraction', 
		array( 'PlantID' => $plantID,  
		'flowering_time_min' => $flowering_time_min,
'flowering_time_max' => $flowering_time_max,
		'beneficial_insect_laying' => $beneficial_insect_laying,
'beneficial_insect_nectar_or_food' => $beneficial_insect_nectar_or_food,
'beneficial_insect_shelter' => $beneficial_insect_shelter),
		array('%s','%s','%s','%s') );


$this->plantDB->insert( 'predators', 
		array( 'PlantID' => $plantID,  
		'predators_scientificname' => $predators_scientificname,
		'predators_commonname' => $predators_commonname ),
		array('%s','%s') );

$this->plantDB->insert( 'pests', 
		array( 'PlantID' => $plantID,  
		'pests_scientificname' => $pests_scientificname,
		'pests_commonname' => $pests_commonname),
		array('%s','%s') );

	
}


/*******************************************************************************************/

	function getNumericOptions( $minNumber, $maxNumber, $label )
	{
		$options = '';
		for( $ii = $minNumber; $ii <= $maxNumber; $ii++ )
		{
			$options .= '<option value=' . $ii . '>'. $label . ' ' . $ii . '</option>';
		}
		return $options;
	}
/*******************************************************************************************/	
function enumDropdown($table_name, $column_name, $echo = false)
{
   $selectDropdown = "<select name=\"$column_name\">";
   $result = mysql_query("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
       WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'")
   or die (mysql_error());

    $row = mysql_fetch_array($result);
    $enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));

    foreach($enumList as $value)
         $selectDropdown .= "<option value=\"$value\">$value</option>";

    $selectDropdown .= "</select>";

	if ($echo)
        echo $selectDropdown;

    return $selectDropdown;
}
/*******************************************************************************************/
	function LoadSearchPage()  // we may or may not use the $atts variable - it's there if we need parameters for our Search Page
	{
		
		$output = '';
		if ( isset ($_POST["common_name"]) )
		{
		/* I have not yet found a way, in a wordpress plugin, to get around processing the */
		/* form in the same function that you create it */
		/* this is the portion that processes the form */
		
		$plantID = $this->AddGeneral( $_POST["common_name"], $_POST["latin_name"] , $_POST["family"], $_POST["resources_for_more_info"]);
		
		$this->AddRegionalCharacteristics( $plantID, $_POST["hardiness_zone_max"], $_POST["hardiness_zone_min"], $_POST["Sunset_zones"], $_POST["chill_hours_min"], $_POST["chill_hours_max"], $_POST["heat_zone_min"], $_POST["heat_zone_max"], $_POST["frost_free_days_needed"], $_POST["sunlight_hours_for_fruiting"], $_POST["tips"]); 
 
		$this->AddHarvesting( $plantID,  $_POST["maximum_bearing_lbs"],  $_POST["harvest_time_days_after_last_frost_min"],  $_POST["harvest_time_days_after_last_frost_max"],  $_POST["seedless_fruits"],  $_POST["years_until_first_bearing"],  $_POST["years_until_full_bearing"],  $_POST["storageability"],  $_POST["ease_of_harvest"], $_POST["fruiting_frequency_other"], $_POST["fruiting_frequency"], $_POST["fruit_color"], $_POST["fruit_type"] );

		$this->AddPhysicalCharacteristics( $plantID,  $_POST["Alleopathic"], $_POST["Thorns"], $_POST["epiphyte_attractive"], $_POST["percentage_shade_underneath"], $_POST["growth_speed"], $_POST["branch_strength"], $_POST["branch_strength"], $_POST["fire_resistance"], $_POST["after_harvest_regrowth_rate_inches_per_month"], $_POST["mature_size_max"], $_POST["blocks_alleopathy"], $_POST["mature_size_min"], $_POST["life_span_minimum"], $_POST["life_span_maximum"], $_POST["life_span_classifications"], $_POST["flower_color"], $_POST["root_characteristics"], $_POST["plant_shape, leaf_color"], $_POST["fall_leaf_color"], $_POST["leaf_drop"], $_POST["toxicity"], $_POST["other_problems"]);


		$this->AddConsumption( $plantID, $_POST["other_edible_for"], $_POST["edible_for"], $_POST["human_edibility"], $_POST["other_edible_uses"], $_POST["edible_uses"] );


		$this->AddProcessing( $plantID, $_POST["other_vegetable_processes"], $_POST["vegetable_processes"], $_POST["other_fruit_processing"], $_POST["fruit_processing"], $_POST["alcohol_processes_resources"], $_POST["description_alcohol_processes_tools"], $_POST["alcohol_processes"], $_POST["alcohol_processes_resources"]);

		$this->AddMedicinals( $plantID, $_POST["medicinal_uses"], $_POST["other_medicinal_uses"], $_POST["medicinaluseskey"], $_POST["medicine_processes_resources"], $_POST["medicine_processes_other"], $_POST["medicine_processes"]);

		$this->AddIncomeStreams( $plantID, $_POST["market_resource_website"], $_POST["zipcode_of_current_market"], $_POST["country_of_current_market"], $_POST["marketing_strategies"], $_POST["other_marketing_strategies"]);
	

		$this->AddPropagation($plantID, $_POST["other_grafting_method"], $_POST["grafting_methods"], $_POST["seeds_per_pound"], $_POST["country"], $_POST["seedling_vigor"], $_POST["seed_size_in_mm"], $_POST["seed_color"], $_POST["seed_shape"], $_POST["light_requirements_hours_per_day"], $_POST["time_to_germination"], $_POST["time_to_germination"], $_POST["percentage_germination"], $_POST["transplantability"], $_POST["seed_resources"], $_POST["seeding_instructions"], $_POST["plant_propagation_method"], $_POST["plant_propagation_tips"]);


		$this->AddPlantFunctions( $plantID, $_POST["non_food_use_other"], $_POST["nonfoodusekey"], $_POST["Non_food_Use"], $_POST["nutrient_fixing"], $_POST["CN_ratio_dried_plant"], $_POST["CN_ratio_fresh_plant"], $_POST["biodynamic_accumulator_mulch_plant"], $_POST["lumber_usage"], $_POST["mushroom_substrate"], $_POST["mushroom_substrate_species"], $_POST["beauty_products"], $_POST["other_beauty_products"], $_POST["pollutant_cleaning_capabilities"], $_POST["sap_use"], $_POST["other_sap_use"]);


		$this->AddHabitatandCommunity($plantID, $_POST["plant_functions_in_environment"], $_POST["layers_plant_type"], $_POST["other_plant_guilds"], $_POST["plantguildskey"], $_POST["plant_guilds"], $_POST["landscape_application"], $_POST["other_landscape_application"], $_POST["soil_content_preferences"], $_POST["other_content_preferences"], $_POST["tolerates_drought"], $_POST["erosion_control_use"], $_POST["juglone_tolerant"], $_POST["pollution_tolerant"], $_POST["storm_water_retention"], $_POST["soil_salinity_tolerant"], $_POST["sun_tolerance_hrs"], $_POST["altitude_preference_min"], $_POST["rooftop_garden"], $_POST["container_plant"], $_POST["altitude_preference_max"], $_POST["terrarium"], $_POST["tolerates_flooding"], $_POST["hedge_wind_control"], $_POST["compact_soil_breaker"], $_POST["coppiceable_poulardable"], $_POST["native_habitat"], $_POST["nativehabitatkey"], $_POST["indication_of"]);

		$this->AddDiseases($plantID, $_POST["plant_diseases_other"], $_POST["plant_diseaseskey"], $_POST["plant_diseaseskey"], $_POST["disease_treatments_description"], $_POST["disease_treatments_resources"]);


		$this->AddMaintenance($plantID, $_POST["fruiting_habit"], $_POST["other_fruiting_habit"], $_POST["litter_type"], $_POST["other_litter_type"], $_POST["propagation_control_methods"], $_POST["other_propagation_control_methods"], $_POST["growth_season"], $_POST["extra_watering_needed"], $_POST["extra_observation_needed"], $_POST["vegetable_season"]); 


		$this->AddAttractionandrepulsion($plantID, $_POST["Deterrence_characteristics"], $_POST["other_deterrence"], $_POST["flowering_time_min"], $_POST["flowering_time_max"], $_POST["beneficial_insect_laying"], $_POST["beneficial_insect_nectar_or_food"], $_POST["beneficial_insect_shelter"], $_POST["predators_scientificname"], $_POST["predators_commonname"], $_POST["pests_scientificname"], $_POST["pests_commonname"]);




if (isset($_POST['native_habitat'])) {
    $nativehabitat= implode(" ", $_POST['native_habitat']);// converts $_POST interests into a string
    $nativehabitat_array = explode(" ", $nativehabitat);// converts the string to an array which you can easily manipulate
}

for ($i = 0; $i < count($nativehabitat_array); $i++)
;

if (isset($_POST['Deterrence_characteristics'])) {
    $deterrencecharacteristics= implode(" ", $_POST['Deterrence_characteristics']);// converts $_POST interests into a string
    $deterrencecharacteristics_array = explode(" ", $deterrencecharacteristics);// converts the string to an array which you can easily manipulate
}

for ($i = 0; $i < count($deterrencecharacteristics_array); $i++)
;

for ($i = 0; $i < count($nativehabitat_array); $i++)
;

if (isset($_POST['extra_observation_needed'])) {
    $extraobservationneeded= implode(" ", $_POST['extra_observation_needed']);// converts $_POST interests into a string
    $extraobservationneeded_array = explode(" ", $extraobservationneeded);// converts the string to an array which you can easily manipulate
}

for ($i = 0; $i < count($extraobservationneeded_array); $i++)
;


if (isset($_POST['extra_watering_needed'])) {
    $extrawateringneeded= implode(" ", $_POST['extra_watering_needed']);// converts $_POST interests into a string
    $extrawateringneeded_array = explode(" ", $extrawateringneeded);// converts the string to an array which you can easily manipulate
}

for ($i = 0; $i < count($extrawateringneeded_array); $i++)
;


if (isset($_POST['plant_diseases'])) {
    $plantdiseasesstring= implode(" ", $_POST['plant_diseases']);// converts $_POST interests into a string
    $plantdiseases_array = explode(" ", $plantdiseasesstring);// converts the string to an array which you can easily manipulate
}

for ($i = 0; $i < count($plantdiseases_array ); $i++)
;


if (isset($_POST['nutrient_fixing'])) {
    $nutrientfixingstring= implode(" ", $_POST['nutrient_fixing']);// converts $_POST interests into a string
    $nutrientfixing_array = explode(" ", $nutrientfixingstring);// converts the string to an array which you can easily manipulate
}

for ($i = 0; $i < count($nutrientfixing_array); $i++)
;

if (isset($_POST['Non_food_Use'])) {
    $nonfoodusestring= implode(" ", $_POST['Non_food_Use']);// converts $_POST interests into a string
    $nonfooduse_array = explode(" ", $nonfoodusestring);// converts the string to an array which you can easily manipulate
}

for ($i = 0; $i < count($nonfooduse_array); $i++)
;


if (isset($_POST['medicine_processes'])) {
    $medicinalprocessesstring= implode(" ", $_POST['medicine_processes']);// converts $_POST interests into a string
    $medicinalprocesses_array = explode(" ", $medicinalprocessesstring);// converts the string to an array which you can easily manipulate
}

for ($i = 0; $i < count($medicinalprocesses_array); $i++)
;


if (isset($_POST['medicinal_uses'])) {
    $medicinalusesstring= implode(" ", $_POST['medicinal_uses']);// converts $_POST interests into a string
    $medicinaluses_array = explode(" ", $medicinalusesstring);// converts the string to an array which you can easily manipulate
}

for ($i = 0; $i < count($medicinaluses_array); $i++)
;






if (isset($_POST['edible_for'])) {
    $edibleforstring= implode(" ", $_POST['edible_for']);// converts $_POST interests into a string
    $ediblefor_array = explode(" ", $edibleforstring);// converts the string to an array which you can easily manipulate
}

for ($i = 0; $i < count($ediblefor_array); $i++)
;



if (isset($_POST['growth_season'])) {
    $growthseasonstring= implode(" ", $_POST['growth_season']);// converts $_POST interests into a string
    $growthseason_array = explode(" ", $growthseasonstring);// converts the string to an array which you can easily manipulate
}

for ($i = 0; $i < count($growthseason_array); $i++)
;
/* you can take each chunk of these and add it to a function. */


/*image upload script*/


$allowedExts = array("GIF", "JPEG", "JPG", "PNG");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = strtoupper( end( $temp ) );

if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/jpg")
	|| ($_FILES["file"]["type"] == "image/pjpeg")
	|| ($_FILES["file"]["type"] == "image/x-png")
	|| ($_FILES["file"]["type"] == "image/png"))
	&& ($_FILES["file"]["size"] < 20000)
	&& in_array($extension, $allowedExts))
{
	if ($_FILES["file"]["error"] > 0)
    {
		$output .= "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
	else
    {
		if (file_exists("images/" . $_FILES["file"]["name"]))
		{
			$output .= $_FILES["file"]["name"] . " already exists. ";
		}
		else
		{
			$output .= "Got the file!<br>";
			move_uploaded_file($_FILES["file"]["tmp_name"], "images/" . $_FILES["file"]["name"]);
		}
    }
}
else
{
	$output .= "Invalid Image File: " . $extension;
	$output .= "Type? " . $_FILES["file"]["type"];
	$output .= "Size? " . $_FILES["file"]["size"];
}


	$output .= 

"<b>Added to:</b> <br>  Common Name: " . $_POST["common_name"] .  
"<br> Scientific Name: " . $_POST["latin_name"] .
"<br> Family: " . $_POST["family"] . 
"<br> Resources for more information: " . $_POST["resources_for_more_info"] . 
".   <br> Information for the following variety: " . $_POST["variety_name"] . 
"<br>". $_POST["alternate_names"] . "as an alternate name in: ". $_POST["alternate_name_language"] . " Uploaded: " . $_FILES["file"]["name"] . "<br>";
  "Type: " . $_FILES["file"]["type"] . "<br>";
  "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
  "Stored in: " . $_FILES["file"]["tmp_name"];




"<br>In Tips: " . $_POST["Tips"] . 

"<p> In Zone Information the following was added to the database:  
<br> Hardiness Zone range: " . $_POST["hardiness_zone_min"] .  
"  to  ". $_POST["hardiness_zone_max"] . 
" <br>Sunset Zones: " . $_POST["Sunset_zones"] . 
" <br>Heat Zone range: " . $_POST["heat_zone_min"] . 
" to " . $_POST["heat_zone_max"] .  
" <br>Koppen Climate Code: " . $_POST["Koppen_climate_code"] . 

"<p><b>In Physical Characteristics the following information was added: </b><br>
Mature size in feet:  " . $_POST["mature_size_min"] . "  to " . $_POST["mature_size_max"] . 
"<br> Growth Speed: " . $_POST["growth_speed"] .  
"<br> Branch strength: ". $_POST["branch_strength"] . 
"<br> Fire resistance:  " . $_POST["fire_resistance"] . 
" <br> Life span classifications: ". $_POST["life_span_classifications"] . 
"<br> Perennial plant expected life span: ". $_POST["life_span_minimum"] .  " to " . $_POST["life_span_maximum"] .   
" <br> Alleopathic: " . $_POST["Alleopathic"] . 
" <br> Blocks Alleopathy: " . $_POST["blocks_alleopathy"] .
"<br> Thorns: " . $_POST["Thorns"] .
"<br> Epiphyte Attractive: " . $_POST["epiphyte_attractive"] .
"<br> Percentage of shade underneath plant: " . $_POST["percentage_shade_underneath"] .
"<br> After coppice/cut/mow regrowth rate in inches per month:  " . $_POST["after_harvest_regrowth_rate_inches_per_month"] .
"<br> Leaf Characteristics: Leaf Drop: ". $_POST["leaf_drop"] . " <br> 
Leaf Color: " . $_POST["leaf_color"] . "<br> Fall Leaf Color: "  . $_POST["fall_leaf_color"] .
"<br> Plant Shape:  " . $_POST["plant_shape"] .
" Toxicity:" . $_POST["toxicity"] .  "   Other Problems:  ". $_POST["other_problems"] .
"<br> Root Characteristics: ". $_POST["root_characteristics"] . " Flower Color: " . $_POST["flower_color"] .  


" <p><b>In Harvesting the following information was added:</b> <br> Frost free days needed for harvesting: " . $_POST["frost_free_days_needed"] . 
" <br>Sunlight hours needed for fruiting: " . $_POST["sunlight_hours_for_fruiting"] . 
", <br>Maximum Bearing: " . $_POST["maximum_bearing_lbs"] . 
", <br>Harvest time Range in days after last frost: "  . $_POST["harvest_time_days_after_last_frost_min"] .  
" to "  . $_POST["harvest_time_days_after_last_frost_max"] . 
"Ease of harvest " . $_POST["ease_of_harvest"] . 

". <br>Seedless Fruits: " . $_POST["seedless_fruits"] . 

 ". <br>Years until First Bearing: " . $_POST["years_until_first_bearing"] . 
"Years until full bearing: " . $_POST["years_until_full_bearing"] . 
". <br>Storageability: " . $_POST["storageability"] . 
"<br>Fruiting frequency: " . $_POST["fruiting_frequency"] . 
", Other fruiting frequency: " . $_POST["fruiting_frequency_other"] .  "<br>fruit type: " . $_POST["fruit_type"] . " <br>and fruit color: " . $_POST["fruit_color"] .
". 


 <b><br>Added to Consumption:</b>
<br>Edibility:
Humans: "  . $_POST["human_edibility"] . "<br>  Edible Uses: "  . $_POST["edible_uses"] .  " Other Edible Uses:  " . $_POST["other_edible_uses"] . "
<br>Livestock:  " . $edibleforstring . " Other Livestock: " . $_POST["other_edible_for"] . "
<br>Processing: 
<br> Alcohol Processing: Possible processes: "  . $_POST["alcohol_processes"] .
"<br> Description of Process: " . $_POST["description_alcohol_processes_tools"] .
"<br> Resources for more information: " . $_POST["alcohol_processes_resources"] .
"<br> Fruit processing: Processes: ". $_POST["fruit_processing"] .
"<br> Other Description: "	. $_POST["other_fruit_processing"] .
"<br><b> Vegetable Processing: </b>Processes: " . $_POST["vegetable_processes"] .
"<br> Other Description: ". $_POST["other_vegetable_processes"] .  ". 

<p><b> Added to Medicinal Information:</b><br>
Medicinal Uses: " . $medicinalusesstring . 
"<br> Medicinal Uses Other: ". $_POST["other_medicinal_uses"] . 
"<br> Medicinal Processes: ". $medicinalprocessesstring. 
"<br> Medicinal Processes Other: ". $_POST["medicine_processes_other"] . 
"<br> Medicinal Processes Resources: ". $_POST["medicine_processes_resources"] . 

"<P> <b>Added to Income Profitability</b> 
<br>Profitability of Crops - Resources: " . $_POST["market_resource_website"] .

"<br>Zipcode of current market: " . $_POST["zipcode_of_current_market"] .
"<br>Country of current market: " . $_POST["country_of_current_market"] .
"<br>Marketing Stratieges: " . $_POST["marketing_strategies"] .
"<br> Other Marketing Description: " . $_POST["other_marketing_strategies"] . 
". <p> 
<b>Added to Propagation: </b>
<br> 
Seeds per pound:    ". $_POST["seeds_per_pound"] . 
  "Seed size:   ". $_POST["seed_size_in_mm"] . 
" Seed color:   "  . $_POST["seed_color"] . 
"<br> Seed shape:  " . $_POST["seed_shape"] . 
 "   Seedling Vigor:    "  . $_POST["seedling_vigor"] . 
 " Time to Germination in days:   "  . $_POST["time_to_germination"] . 
"<br> Percentage Germination:       "       . $_POST["percentage_germination"] . 
"%     Transplantability:   "  . $_POST["transplantability"] . 
"<br> Light requirements in hours per day: "  . $_POST["light_requirements_hours_per_day"] . 
 "      Seeding instructions:  "  . $_POST["seeding_instructions"] . 
" <br> Plant propagation methods: " . $_POST["plant_propagation_method"] . 
"<br>  Tips for selected plant propagation method:  "  . $_POST["plant_propagation_tips"] . 
"<br> Resources for seeds/Commercial availability:  "  . $_POST["seed_resources"] . 
 "  Country of resources:   "  . $_POST["country"] . 
"<br> Grafting methods:    "  . $_POST["grafting_methods"] . 
 " Other Grafting Methods: "  . $_POST["other_grafting_method"] . 



"<p><b>Added to Plant Function information: </b>
<br> Plant Functions:  " . $nonfoodusestring . 
" Other: " . $_POST["non_food_use_other"] .
"<br> Mushroom Substrate: " . $_POST["mushroom_substrate"] . 
"<br> Mushroom Species for each Substrate: " . $_POST["mushroom_substrate_species"] . 
"<br> Lumber Useage:  ". $_POST["lumber_usage"] . 
"<br> Other lumber usage: " . $_POST["other_lumber_use"] . 
"<br> Nutrient Fixing: " . $nutrientfixingstring . 

"<br> Compost: C:N ratio of dried plant:  " . $_POST["CN_ratio_dried_plant"] . 
"<br> C:N ratio of live plant:  " . $_POST["CN_ratio_fresh_plant"] . 
"<br> Biodynamic accumulator mulch plant: " 
. $_POST["biodynamic_accumulator_mulch_plant"] . 
"<br> Sap Use:   " . $_POST["sap_use"] . 
" Other sap use:  " . $_POST["other_sap_use"] . 
"<br> Pollutant Cleaning: " . $_POST["pollutant_cleaning_capabilities"] . 
"<br> Beauty Products:   " . $_POST["beauty_products"] . 
"<br> Other: " . $_POST["other_beauty_products"] . 






"<p><b>Added to Plant Community Information </b>
<br> Habitat: Native Habitat (WWF): "   . $nativehabitat .
"<br> Preferred Habitat Conditions: 
<br> Tolerates Drought:   " . $_POST["tolerates_drought"] .
"<br> Tolerates Flooding:   " . $_POST["tolerates_flooding"] .
"<br> Erosion Control Use:   " . $_POST["erosion_control_use"] .
"<br> Juglone Tolerant:   " . $_POST["juglone_tolerant"] .
"<br> Pollution Tolerance:  "  . $_POST["pollution_tolerant"] .
"<br> Storm Water Retention:  "  . $_POST["storm_water_retention"] .
"<br> Soil Salinity Tolerance:  "  . $_POST["soil_salinity_tolerant"] .
"<br> Sun Tolerance in hours:   " . $_POST["sun_tolerance_hrs"] .
"<br> Shade Tolerance in hours:   " . $_POST["shade_tolerance_hrs"] .
"<br> Altitude Preference Range:   "  . $_POST["altitude_preference_min"] .  " to "   . $_POST["altitude_preference_max"] .
"<br> Suitable for:
<br> Rooftop Garden:   "  . $_POST["rooftop_garden"] .
"<br> Containers:   " . $_POST["container_plant"] .
"<br> Terrariums:    " . $_POST["terrarium"] .
"<br> Soil Content Preferences:    " . $_POST["soil_content_preferences"] .
"<br> Other Soil Content preferences: " . $_POST["other_content_preferences"] .
"<br> Wind Break Hedge:   " . $_POST["hedge_wind_control"] .
"<br> Breaks up Compact Soil:  "  . $_POST["compact_soil_breaker"] .
"<br> Coppicable/Poulardable:   " . $_POST["coppiceable_poulardable"] .
"<br> Plant Function Type:   " . $_POST["plant_functions_in_environment"] .
"<br> Plant Layer in Forest Garden:     " . $_POST["layers_plant_type"] .
"<br> Plant Guilds:    " . $_POST["plant_guilds"] .
"<br> Other Plant Guilds:  "  . $_POST["other_plant_guilds"] .
"<br> Landscape Application:  "   . $_POST["landscape_application"] .
"<br> Other Landscape application:  "  . $_POST["other_landscape_application"] .
"<br> Plant is an indication of: " . $_POST["indication_of"] .


"<p> <b>Added to Diseases: </b> <br>
Plant Diseases: " . $plantdiseasesstring .
"<br> Other plant diseases: " . $_POST["plant_diseases_other"] .
"<br> Plant varieties resistant to diseases: FINISH THIS

<br> Plant Disease Treatments: ". $_POST["disease_treatments_description"] .
"<br> Disease resources: ". $_POST["disease_treatments_resources"] .


"<p> <b> Added to Growth and Maintenance: </b> 
<br>Vegetable season: " . $_POST["vegetable_season"] .
"<br>Fruiting habit:	" . $_POST["fruiting_habit"] .
"<br>  Other fruiting habit: "   . $_POST["other_fruiting_habit"] .
"<br>  Litter type:  " . $_POST["litter_type"] .
"<br>  Other litter type: "   . $_POST["other_litter_type"] .
"<br>  Propagation control: " . $_POST["propagation_control_methods"] .
"<br>  Other propagation controls:  " . $_POST["other_propagation_control_methods"] .
"<br> Seasonal growth and watering : Main season of growth: "  . $growthseasonstring .
"<br> Extra watering needed: " . $extrawateringneeded .
"<br>Extra observation needed: " . $extraobservationneeded .

"<br> First Sap Flow Average Date " .$first_sap .

"<br> First Leafing Out Average Date  " .$first_leaf .

"<p> <b>Added to Deterrence and attraction: </b>
<br> Flowering time: " . $_POST["flowering_time_min"] . "to"  . $_POST["flowering_time_max"] .
"<br> Attractive to beneficial insects for laying:   ". $_POST["beneficial_insect_laying"] .
"<br>Attractive to beneficial insects for food:	  " . $_POST["beneficial_insect_nectar_or_food"] .
"<br>Attractive to Beneficial Insects for shelter:	   ". $_POST["beneficial_insect_shelter"] .
"<br>Pests Scientific name:  ". $_POST["pests_scientificname"] .
"<br> Common Name  ". $_POST["pests_commonname"] .
"<br>Predators of pests scientific name: ". $_POST["predators_scientificname"] .
" <br> Common Name:    ". $_POST["predators_commonname"] .
"<br> Characteristics of deterrence: ". $deterrencecharacteristics .
"<br> Other Deterrence: ". $_POST["other_deterrence"] .
".";





return $output;
		}
		else
		{
			
			/* this is where you actually put your html for your page */
			/* Start with a simple welcome message */
			
			/* single or double quotes around strings are both fine */
			
			$output = '';

			
			
			
$output .= '<head>' . PHP_EOL;

/* scripts */
$output .= '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>' . PHP_EOL;
$output .= '<script type="text/javascript" src="http://www.sanwebe.com/wp-content/themes/sanwebe/js/jquery-1.10.2.min.js"></script>' . PHP_EOL;
$output .= '<script type="text/javascript" src="http://www.sanwebe.com/wp-content/themes/sanwebe/js/bodyscript.min.js"></script>' . PHP_EOL;


$output .= '<script type="text/javascript">' . PHP_EOL;
$output .= 'jQuery(document).ready(function() {' . PHP_EOL;
$output .= '  jQuery(".content").hide();' . PHP_EOL;
$output .= '  //toggle the component with class msg_body' . PHP_EOL;
$output .= '  jQuery(".heading").click(function()' . PHP_EOL;
$output .= '  {' . PHP_EOL;
$output .= '    jQuery(this).next(".content").slideToggle(500);' . PHP_EOL;
$output .= '  });' . PHP_EOL;
$output .= '});' . PHP_EOL;
$output .= '</script>' . PHP_EOL;

/* style */

$output .= '
<style type="text/css"> 
body {
	margin: 10px auto;
	font: 12px Verdana,Arial, Helvetica, sans-serif;
}
.layers {
margin: 0;
padding: 0;
}

.heading {
margin: 0px;
color: #000000;
padding: 3px 5px;
cursor: pointer;
position: relative;
font-size: 14px;
background-color:#AEFFA3;
}
.content {
padding: 3px 5px;
background-color:#ffffff;
}
p { padding: 0px 0; }

</style>' . PHP_EOL;

/* html body */

$output .= '
</head>

<body>
<form  method="post" enctype="multipart/form-data"  action="">

<br><div class="layers">
<p class="heading">Click to add General Information</p> 
<div class="content">
Scientific Name:<input type="text" name="latin_name">
<br>Common Name: <input type="text" name="common_name">
	
	<br>Family: <input type="text" name="family">
	<br>Resources for more information:  <input type="text" name="resources_for_more_info"> 
	<br>Alternate Names:   <input type="text" name="alternate_names"> <br>Language of name: <input type="text" name="alternate_name_language">  
	<br>Variety: <input type="text" name="variety_name">
	<br> Tips: <textarea cols="30" rows="3" input type="text" name="Tips"></textarea>';
$output .= '<br>Add up to three images, all files must be under 20 kb in size and must have image file extensions. <label for="file">Filename:</label>
<input type="file" name="file" id="file">

</p>
ADD ZIP CODE LINK
</div> 
';  /* end General Information */


	$output .= '<p class="heading">Click to add Zone Information</p>
		<div class="content">
		Hardiness Zone Minimum: 
		<select name="hardiness_zone_min">';
	$output .= '<option value=14>Not Known</option>'; 
	$output .= $this->getNumericOptions( 1, 13, "Zone" );
	$output .= '</select>';


	$output .= '<br>Hardiness Zone Maximum: 
		<select name="hardiness_zone_max">
		<option value=14>Not Known</option>'; 
	$output .= $this->getNumericOptions( 1, 13, "Zone" );
	$output .= '</select>';


$output .= '
<br>
Sunset Zones divided by commas: <input type="text" name="Sunset_zones">  <br> Koppen Climate Code divided by commas:
<input name="Koppen_climate_code" type="text">
<br>'; 


$output .= 'Heat Zone Minimum:  <select name="heat_zone_min">
<option value=14>Not Known</option>'; 
	$output .= $this->getNumericOptions( 1, 12, "Zone" );
	$output .=  '</select> ';


	$output .= 'Heat Zone Maximum: 
		<select name="heat_zone_max">
		<option value=14>Not Known</option>'; 
	$output .= $this->getNumericOptions( 1, 12, "Zone" );
	$output .= ' </select>';


$output .= '
	<br>
	Chill Hours Min: <input type="text" name="chill_hours_max"> 
	Chill Hours Max: <input type="text" name="chill_hours_min"> </div>
</div> 
<br><input type="submit">
</form>

<p class="heading">Click to add Physical Characteristics Information</p>
<div class="content">Mature size in feet <input type"text" name="mature_size_min">" to <input type"text" name="mature_size_max">"
<br>
Growth Speed:  ';

$output .= $this->enumDropdown(physical_characteristics, growth_speed);
 

$output .= ' 

Branch strength: ';

$output .= $this->enumDropdown(physical_characteristics, branch_strength);
 

$output .= ' 

Fire resistance: ';

$output .= $this->enumDropdown(physical_characteristics, fire_resistance);
 

$output .= ' 
<br>Life span classifications: ';

$output .= $this->enumDropdown(life_span_classifications, life_span_classifications);
 

$output .= '  

Perennial plant expected life span:  
<input type="text" name="life_span_minimum"> to <input type="text" name="life_span_maximum">

<br>Alleopathic: 
<input type="radio" name="Alleopathic" value="not_known" checked="checked">Not known		
<input type="radio" name="Alleopathic" value="Yes">Yes 
<input type="radio" name="Alleopathic" value="No">No 

<br>Blocks Alleopathy: 
<input type="radio" name="blocks_alleopathy" value="not_known" checked="checked">Not known		
<input type="radio" name="blocks_alleopathy" value="Yes">Yes 
<input type="radio" name="blocks_alleopathy" value="No">No 
<br>
Thorns 
<input type="radio" name="Thorns" value="yes">Yes 
<input type="radio" name="Thorns" value="no">No 
<input type="radio" name="Thorns" value="not_known" checked="checked">Not known	
<br>
 Epiphyte Attractive: 
<input type="radio" name="epiphyte_attractive" value="yes">Yes 
<input type="radio" name="epiphyte_attractive" value="no">No
 <input type="radio" name="epiphyte_attractive" value="not_known" checked="checked">Not known 

<br> Percentage of shade underneath plant: 
<input type="text" name="percentage_shade_underneath">

<br> After coppice/cut/mow regrowth rate in inches per month: <input type="text" name="after_harvest_regrowth_rate_inches_per_month">

<br>Leaf Characteristics:  Leaf color: ';

$output .= $this->enumDropdown(leaf_characteristics, leaf_color);
 

$output .= ' Fall Leaf Color: ';

$output .= $this->enumDropdown(leaf_characteristics, fall_leaf_color);
 
$output .= ' Leaf Drop: ';

$output .= $this->enumDropdown(leaf_characteristics, leaf_drop);
$output .= '<br>Plant Shape: ';
$output .= $this->enumDropdown(plant_shape, plant_shape);
$output .= ' <br> Toxicity: ';
$output .= $this->enumDropdown(problems, toxicity);
$output .= '

Other Problems: <textarea rows="1" cols="20" input type="text" name="other_problems">	</textarea>
<br> Root Characteristics:   ';

$output .= $this->enumDropdown(root_characteristics, root_characteristics);
 

$output .= ' Flower Color: ';

$output .= $this->enumDropdown(flower_color, flower_color);
 

$output .= '</div> <p class="heading">Click to add Harvesting Information</p>

<div class="content">
<script type="text/javascript"> 
Plant Part for harvest: <br>
Total sunlight hours needed for fruiting: 
<input type="text" name="sunlight_hours_for_fruiting">



Frost free days needed for harvest: 
<input type="text" name="frost_free_days_needed">
<br>Ease of harvest: ';
$output .= $this->enumDropdown(harvesting, ease_of_harvest);
$output .= '<br>
Maximum bearing in lbs. <input type="text" name="maximum_bearing_lbs"> 
<br>Harvest time after last frost minimum: <input type="text" name="harvest_time_days_after_last_frost_min"> 
Harvest time after last frost maximum: <input type="text" name="harvest_time_days_after_last_frost_max"> 
<br>Seedless fruits:  <input type="radio" name="seedless_fruits" value="not_known" checked="checked">Not known
<input type="radio" name="seedless_fruits" value="yes">Yes 
<input type="radio" name="seedless_fruits" value="no">No 
<br>Years until first bearing: <input type="text" Name="years_until_first_bearing"> Years until full bearing: <input type="text" name="years_until_full_bearing">
<br>Storageability: ';
$output .= $this->enumDropdown(harvesting, storageability);
 $output .= 'Fruit Color: ';
$output .= $this->enumDropdown(fruit_color, fruit_color);
 $output .= 'Fruit Type: ';
$output .= $this->enumDropdown(fruit_type, fruit_type);
 $output .= '
<br>Fruiting Frequency: ';
$output .= $this->enumDropdown(fruiting_frequency, fruiting_frequency);
$output .= '
Other: <input name="fruiting_frequency_other" type="text"> 





</div>



<p class="heading">Click to add Consumption information </p>
<div class="content">Edibility: <br>
Humans:  ';

$output .= $this->enumDropdown(Human_Consumption, human_edibility);

$output .= '

Edible Uses: ';

$output .= $this->enumDropdown(Human_Consumption, edible_uses);

$output .= '
Other Edible Uses: <input type="text" name="other_edible_uses">
<br>
Livestock: <input name="edible_for" type=checkbox value="not_known"> Not Known
<input name="edible_for" type=checkbox value="chicken"> Chicken
<input  name="edible_for" type=checkbox value="sheep"> Sheep
<input name="edible_for" type=checkbox value="goats"> Goats
<input name="edible_for" type=checkbox value="quail"> Quail
<input name="edible_for" type=checkbox value="cattle"> Cattle
<input name="edible_for" type=checkbox value="ducks"> Ducks
<input name="edible_for" type=checkbox value="rabbits"> Rabbits 
<input name="edible_for" type=checkbox value="pigs"> Pigs
<input name="edible_for" type=checkbox value="horses"> Horses 
<input name="edible_for" type=checkbox value="other"> Other
<br>

Other Livestock: <input type="text" name="other_edible_for"></div>
<p class="heading"> Click to add Food Processing Information</p><div class="content"> Alcohol Processes:   ';

$output .= $this->enumDropdown(alcohol_making, alcohol_processes);

$output .= '

<br>Description of Process: <textarea rows="2" cols="20" input type="text" border="0" name="description_alcohol_processes_tools"></textarea>
Resources for more information: <textarea rows="2" cols="20" border="0"  input type="text"  name="alcohol_processes_resources"></textarea><br>Fruit processes:';

$output .= $this->enumDropdown(fruit_processing, fruit_processing);

$output .= '
<br>Other Description: <textarea rows="1" cols="20" input type="text" name="other_fruit_processing">	</textarea>
<br>
Vegetable Processes:  ';

$output .= $this->enumDropdown(vegetable_processing, vegetable_processes);

$output .= '
<br>Other Description: <textarea rows="1" cols="20" input type="text" name="other_vegetable_processes"></textarea></div>

<p class="heading">Click to add Medicinal Information</p>
<div class="content">Medicinal uses: 
<input type="checkbox" name="medicinal_uses[]" value="not_known">Not Known<br> 
<input type="checkbox" name="medicinal_uses[]" value="pain">Pain
<input type="checkbox" name="medicinal_uses[]" value="cold">Cold
<input type="checkbox" name="medicinal_uses[]" value="cough">Cough<br>
<input type="checkbox" name="medicinal_uses[]" value="anti_inflammatory">Anti-inflammatory
<input type="checkbox" name="medicinal_uses[]" value="warts">Warts
<input type="checkbox" name="medicinal_uses[]" value="laxative">Laxative<br>
<input type="checkbox" name="medicinal_uses[]" value="menstrual_cycle">Menstrual cycle
<input type="checkbox" name="medicinal_uses[]" value="immune_resilience">Immune system resilience
<input type="checkbox" name="medicinal_uses[]" value="vitamins">vitamins<br>
<input type="checkbox" name="medicinal_uses[]" value="digestion">Digestion
<input type="checkbox" name="medicinal_uses[]" value="blood_sugar_levels">Blood sugar levels
<input type="checkbox" name="medicinal_uses[]" value="burns">Burns<br>
<input type="checkbox" name="medicinal_uses[]" value="diuretic">Diuretic
<input type="checkbox" name="medicinal_uses[]" value="antifungal">Antifungal
<input type="checkbox" name="medicinal_uses[]" value="antiseptic">Antiseptic<br>
<input type="checkbox" name="medicinal_uses[]" value="antibacterial">Antibacterial
<input type="checkbox" name="medicinal_uses[]" value="heart_protection">Heart protection
<input type="checkbox" name="medicinal_uses[]" value="hormone_stabilization">Hormone stabilization<br>
<input type="checkbox" name="medicinal_uses[]" value="increase_mental_capacity">Increase mental capacity
<input type="checkbox" name="medicinal_uses[]" value="parasites">Parasites
<input type="checkbox" name="medicinal_uses[]" value="other">Other<br>
<br> 
Other: <input type="text" name="other_medicinal_uses">
<br>
Medicinal processing:

<input type="checkbox" name="medicine_processes[]" value="fresh_plant_tincture"> Fresh plant tincture
<input type="checkbox" name="medicine_processes[]" value="dry_plant_tincture"> Dry plant tincture
<input type="checkbox" name="medicine_processes[]" value="tea">Tea 
<input type="checkbox" name="medicine_processes[]" value="syrup">Syrup
<input type="checkbox" name="medicine_processes[]" value="salve">Salve 
<input type="checkbox" name="medicine_processes[]" value="decoction"> Decoction
<input type="checkbox" name="medicine_processes[]" value="other">Other
<br>Other: <input type="text" name="medicine_processes_other">
<br>Resources: <textarea rows="1" columns="20" input type="text" name="medicine_processes_resources"></textarea></div>
<p class="heading">Click to add Income Streams information</p><div class="content">Profitability of Crops Resources: <textarea rows="1" cols="20" input type=text name="market_resource_website"> </textarea>
<br>Zipcode of current market: <input type=text name="zipcode_of_current_market"> </input>


Marketing Strategies: ';

$output .= $this->enumDropdown(marketing_strategies, marketing_strategies);
 

$output .= '
<br>
Other Description: <textarea rows="1" cols="20" input type="text" name="other_marketing_strategies"></textarea>
<br>Country of current market: <input type=text name="country_of_current_market"></input> </div>
<p class="heading">Click to add Propagation of Plants information</p>
	<div class="content">Seeds per pound: <input type="text" name="seeds_per_pound">
Seed size <input type="text" name="seed_size_in_mm">

Seed color: ';

$output .= $this->enumDropdown(seeds, seed_color);
 

$output .= '

<br>Seed shape: ';

$output .= $this->enumDropdown(seeds, seed_shape);
 

$output .= '

Seedling Vigor:   ';

$output .= $this->enumDropdown(seeds, seedling_vigor);
 

$output .= '

	Time to Germination in days: <input type="text" name="time_to_germination"> 
	<br>Percentage Germination:  <input type="text" name="percentage_germination">  %   &nbsp; &nbsp; &nbsp; &nbsp;
	Transplantability: ';

$output .= $this->enumDropdown(seeds, transplantability);
 

$output .= '


<br>Light requirements:  <input type="text" name="light_requirements_hours_per_day"> in hours per day. 
	
	 &nbsp; &nbsp; &nbsp; &nbsp;Seeding instructions <textarea rows="1" cols="20" input type="text" name="seeding_instructions">	</textarea><br>
	
Best Plant Propagation Method: ';

$output .= $this->enumDropdown(Plant_propagations_methods, plant_propagation_method);
 

$output .= '

Tips for selected plant propagation method: <textarea rows="1" cols="20" input type="text" name="plant_propagation_tips">	</textarea><br>

Resources for seeds/Commercial availability: <input type="text" name="seed_resources">
Country of resources <input type="text" name="country">

<br>	Grafting methods:  ';

$output .= $this->enumDropdown(grafting_methods, grafting_methods);
 

$output .= '
	
Other Grafting Methods: <textarea rows="1" cols="20" input type="text" name="other_grafting_method">	</textarea><br></div>


<p class="heading">Click to add Plant Function Information</p><div class="content">
Plant Functions: 
<input type="checkbox" name="Non_food_Use[]" checked="checked" value="not_known">Not Known<br>
<input type="checkbox" name="Non_food_Use[]" value="ink/dye">ink/dye<br>
<input type="checkbox" name="Non_food_Use[]" value="tanning">tanning<br>
<input type="checkbox" name="Non_food_Use[]" value="weaving">weaving<br>
<input type="checkbox" name="Non_food_Use[]" value="soap_making">soap making<br>
<input type="checkbox" name="Non_food_Use[]" value="oil_making">oil making<br>
<input type="checkbox" name="Non_food_Use[]" value="rope_making">rope making<br>
<input type="checkbox" name="Non_food_Use[]" value="cloth_making">cloth making<br>
<input type="checkbox" name="Non_food_Use[]" value="pot_scrubbers_abrasives">pot scrubbers/abrasives<br>
<input type="checkbox" name="Non_food_Use[]" value="sewing_needle_making">sewing_needle_making<br>
<input type="checkbox" name="Non_food_Use[]" value="other">other

Other: <input type="text" name="non_food_use_other">

<br> Mushroom Substrate: 
<input type="radio" name="mushroom_substrate" value="not_known">Not Known<br>
<input type="radio" name="mushroom_substrate" value="poor">Poor<br>
<input type="radio" name="mushroom_substrate" value="medium">Medium<br>
<input type="radio" name="mushroom_substrate" value="good">Good<br>

Mushroom Substrate Species: <input type="text" name="mushroom_substrate_species">


Lumber Usage:  ';

$output .= $this->enumDropdown(lumber_useage, lumber_usage);
 

$output .= ' <br>

Other lumber usage: <input type="text" name="other_lumber_use"><br>

Nutrient Fixing: 
<input type="checkbox" name="nutrient_fixing[]" value="not_known">Not Known
<input type="checkbox" name="nutrient_fixing[]" value="nitrogen">nitrogen
<input type="checkbox" name="nutrient_fixing[]" value="potassium">potassium
<br><input type="checkbox" name="nutrient_fixing[]" value="phosphorus">phosphorus
<input type="checkbox" name="nutrient_fixing[]" value="calcium">calcium
<input type="checkbox" name="nutrient_fixing[]" value="magnesium">magnesium
<br><input type="checkbox" name="nutrient_fixing[]" value="sulfer">sulfer
<input type="checkbox" name="nutrient_fixing[]" value="boron">boron
<input type="checkbox" name="nutrient_fixing[]" value="copper">copper
<br><input type="checkbox" name="nutrient_fixing[]" value="iron">iron
<input type="checkbox" name="nutrient_fixing[]" value="chloride">chloride
<input type="checkbox" name="nutrient_fixing[]" value="manganese">manganese
<br><input type="checkbox" name="nutrient_fixing[]" value="molybdenum">molybdenum
<input type="checkbox" name="nutrient_fixing[]" value="zinc">zinc
<br>

Compost:  CN ratio of dried plant: <input type="text" name="CN_ratio_dried_plant">
<br>CN ratio of live plant: <input type="text" name="CN_ratio_fresh_plant">
<br> Biodynamic accumulator mulch plant:  ';

$output .= $this->enumDropdown(compost, biodynamic_accumulator_mulch_plant);
 

$output .= '

<br> Sap Use:  ';

$output .= $this->enumDropdown(sap_use, sap_use);
 

$output .= '  Other: 
<input type="text" name="other_sap_use">

<br> Pollutant Cleaning:  ';

$output .= $this->enumDropdown(pollutant_cleaning, pollutant_cleaning_capabilities);
 

$output .= ' 

Beauty Products:  ';

$output .= $this->enumDropdown(beauty_products, beauty_products);
 

$output .= ' 

Other: <input type="text" name="other_beauty_products"></div>
<p class="heading">Click to add Placement/Community information</p>
<div class="content">
Habitat:
Native Habitat(WWF):
 <input type="checkbox" name="native_habitat[]" value="not_known">Not Known
<input type="checkbox" name="native_habitat[]" value="tropical_subtropical_moist_broadleaf_forest">Tropical/Subtropical moist broadleaf forest
<input type="checkbox" name="native_habitat[]" value="tropical_subtropical_dry_broadleaf_forests">Tropical/Subtropical dry broadleaf forest
<input type="checkbox" name="native_habitat[]" value="tropical_suptropical_coniferous_forest">Tropical/Subtropical coniferous forest
<input type="checkbox" name="native_habitat[]" value="temperate_broadleaf_mixed_forest">Temperate mixed broadleaf forest
<input type="checkbox" name="native_habitat[]" value="temperate_coniferous_forest">Temperate Coniferous Forest
<input type="checkbox" name="native_habitat[]" value="boreal_forests_taiga">Boreal Forests/Taiga
<input type="checkbox" name="native_habitat[]" value="tropical_subtropical_grassland">Tropical/Subtropical grasslands
<input type="checkbox" name="native_habitat[]" value="savanna_shrubland">Savanna Shrubland
<input type="checkbox" name="native_habitat[]" value="temperate_grassland">Temperate grassland
<input type="checkbox" name="native_habitat[]" value="flooded_grasslands_savannas">Flooded grassland/savanna
<input type="checkbox" name="native_habitat[]" value="montane_grassland_shrublands">Montane grasslands/shrublands
<input type="checkbox" name="native_habitat[]" value="tundra">Tundra
<input type="checkbox" name="native_habitat[]" value="mediterranean_forest">Mediterranean Forest
<input type="checkbox" name="native_habitat[]" value="woodlands_scrub">Woodlands Scrub
<input type="checkbox" name="native_habitat[]" value="deserts_xeric_shrublands">Deserts and Xeric Shrublands
<input type="checkbox" name="native_habitat[]" value="mangroves">Mangroves
<input type="checkbox" name="native_habitat[]" value="large_rivers">Large rivers
<input type="checkbox" name="native_habitat[]" value="small_rivers">Small rivers
<input type="checkbox" name="native_habitat[]" value="large_lakes">Large lakes
<input type="checkbox" name="native_habitat[]" value="small_lakes">Small lakes
<input type="checkbox" name="native_habitat[]" value="xeric_basins">Xeric basins
<input type="checkbox" name="native_habitat[]" value="polar">Polar
<input type="checkbox" name="native_habitat[]" value="temperate_shelf_seas">Temperate shelf seas
<input type="checkbox" name="native_habitat[]" value="tropical_coral">Tropical Coral
<input type="checkbox" name="native_habitat[]" value="other">Other 
<br>
Other native habitats: <input type="text" name="other_native_habitat"> <br>
Preferred Habitat Conditions:
Tolerates Drought:   ';

$output .= $this->enumDropdown(habitat_preferences, tolerates_drought);
 

$output .= ' 
Tolerates Flooding:  ';

$output .= $this->enumDropdown(habitat_preferences, tolerates_flooding);
 

$output .= ' 

<br> Erosion Control Use: ';

$output .= $this->enumDropdown(habitat_preferences, erosion_control_use);
 

$output .= ' 

Juglone Tolerant:   ';

$output .= $this->enumDropdown(habitat_preferences, juglone_tolerant);
 

$output .= ' 

<br>Pollution Tolerance:   ';

$output .= $this->enumDropdown(habitat_preferences, pollution_tolerant);
 

$output .= '  
Storm Water Retention:   ';

$output .= $this->enumDropdown(habitat_preferences, storm_water_retention);
 

$output .= '   

<br>Soil Salinity Tolerance:   ';

$output .= $this->enumDropdown(habitat_preferences, soil_salinity_tolerant);
 

$output .= '   
<br>
Sun Tolerance in hours: 
<input type="type" name="sun_tolerance_hrs">

Shade Tolerance in hours: 
<input type="type" name="shade_tolerance_hrs">
<br>
Altitude Preference Range: 
<input type="type" name="altitude_preference_min"> to <input type="type" name="altitude_preference_max">

<br> Suitable for:
<br> Rooftop Garden:   ';

$output .= $this->enumDropdown(habitat_preferences, rooftop_garden);
 

$output .= '   

 Containers:  ';

$output .= $this->enumDropdown(habitat_preferences, container_plant);
 

$output .= '   
Live Fences ' ;

$output .= $this->enumDropdown(habitat_preferences, live_fencing);
 

$output .= '   
 Terrariums: ' ;

$output .= $this->enumDropdown(habitat_preferences, terrarium);
 

$output .= '   
<br>Soil Content Preferences: ' ;

$output .= $this->enumDropdown(soil_content_preferences, soil_content_preferences);
 

$output .= ' 
<input type="text" name="other_content_preferences">

<br>Wind Break Hedge:  ' ;

$output .= $this->enumDropdown(habitat_preferences, hedge_wind_control);
 

$output .= '   

Breaks up Compact Soil:   ' ;

$output .= $this->enumDropdown(habitat_preferences, compact_soil_breaker);
 

$output .= ' 

Coppicable/Poulardable:    ' ;

$output .= $this->enumDropdown(habitat_preferences, coppiceable_poulardable);
 

$output .= ' 

Plant Function Type:   ' ;

$output .= $this->enumDropdown(plant_functions_in_environment_descriptions, plant_functions_in_environment);
 

$output .= ' 
<br>
Plant Layer in Forest Garden:   ' ;

$output .= $this->enumDropdown(layers_plant_type, layers_plant_type);
 

$output .= ' 

Companion Plant HERE I NEED TO FIGURE OUT HOW TO DO A DROPDOWN LIST OF ALL ADDED PLANTS. DO 3 LISTS.

<BR> Plant Guilds:   ' ;

$output .= $this->enumDropdown(plant_guilds, plant_guilds);
 

$output .= ' 

Other Plant Guilds:  <input type="text" name="other_plant_guilds">
<br>
Landscape Application:   ' ;

$output .= $this->enumDropdown(landscape_application, landscape_application);
 

$output .= '  
Other Landscape application: <input type="text" name="other_landscape_application">

<br> Plant is an indication of: ' ;

$output .= $this->enumDropdown(habitat_preferences, indication_of);
 

$output .= '</div> 


<p class="heading">Click to add Disease information </p>


<div class="content">Plant diseases:  
<input type="checkbox" name="plant_diseases[]" value="not_known">Not Known
<br><input type="checkbox" name="plant_diseases[]" value="fire_blight">Fire Blight
<input type="checkbox" name="plant_diseases[]" value="early_blight">Early Blight
<brinput type="checkbox" name="plant_diseases[]" value="late_blight">Late Blight
<input type="checkbox" name="plant_diseases[]" value="bacterial_blight">Bacterial Blight
<br><input type="checkbox" name="plant_diseases[]" value="cytosporta_cankers"> Cytosporta Cankers
<input type="checkbox" name="plant_diseases[]" value="nectria_canker">Nectria Canker
<input type="checkbox" name="plant_diseases[]" value="fruit_rot">Fruit Rot
<br><input type="checkbox" name="plant_diseases[]" value="root_stem_rots">Root and Stem Rots
<input type="checkbox" name="plant_diseases[]" value="mushroom_rots">Mushroom Rots
<input type="checkbox" name="plant_diseases[]" value="asparagus_rot">Asparagus Rust
<br><input type="checkbox" name="plant_diseases[]" value="other_rusts">Other Rusts
<input type="checkbox" name="plant_diseases[]" value="stewarts_wilt">Stewarts Wilt
<input type="checkbox" name="plant_diseases[]" value="verticulum_wilt">Verticulum Wilt
<input type="checkbox" name="plant_diseases[]" value="other">Other
<br>Other: 
<input type="text" name="plant_diseases_other">

<br>
Plant varieties that are resistant to diseases: 
DROP DOWN LIST OF ALL VARIETIES ENTERED FOR THIS PLANT.

<br>
Disease Treatments:  <textarea cols="20" rows="2" input type="text" name="disease_treatments_description"> </textarea>
Resources:
<textarea cols="20" rows="2" input type="text" name="disease_treatments_resources">
</textarea> </div>

<p class="heading">Click to add Growing and Maintenance information</p> <div class="content">

Vegetable Season: 
<input type="radio" name="vegetable_season" value="not_known">Not known
<input type="radio" name="vegetable_season" value="cold">Cold season vegetable 
<input type="radio" name="vegetable_season" value="warm"> Warm season vegetable
<br>
Fruiting habit:  ' ;

$output .= $this->enumDropdown(fruiting_habit, fruiting_habit);
 

$output .= '  	 

Other fruiting habit:  <input type="text" name="other_fruiting_habit">
<br>
Litter type:  	' ;

$output .= $this->enumDropdown(litter_type, litter_type);
 

$output .= '  	  

Other litter type:  <input type="text" name="other_litter_type">

<br>Propagation control:  	' ;

$output .= $this->enumDropdown(propagation_control_methods, propagation_control_methods);
 

$output .= '  	 
Other propagation controls: <input type="text" name="other_propagation_control_methods">
<br>
Seasonal growth and watering: 
Main season of growth: 
<input type="checkbox" name="growth_season[]" value="early">Early
<input type="checkbox" name="growth_season[]" value="mid">Mid
<input type="checkbox" name="growth_season[]" value="late">Late
<input type="checkbox" name="growth_season[]" value="spring">Spring
<input type="checkbox" name="growth_season[]" value="summer">Summer
<input type="checkbox" name="growth_season[]" value="fall">Fall
<input type="checkbox" name="growth_season[]" value="winter">Winter
<br>Extra watering needed: 
<input type="checkbox" name="extra_watering_needed[]" value="spring">Spring
<input type="checkbox" name="extra_watering_needed[]" value="summer">Summer
<input type="checkbox" name="extra_watering_needed[]" value="fall">Fall
<input type="checkbox" name="extra_watering_needed[]" value="winter">Winter
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Extra observation needed: 
<input type="checkbox" name="extra_observation_needed[]" value="spring">Spring
<input type="checkbox" name="extra_observation_needed[]" value="summer">Summer
<input type="checkbox" name="extra_observation_needed[]" value="fall">Fall
<input type="checkbox" name="extra_observation_needed[]" value="winter">Winter

<br>First Sap Flow Average Date <input type="text" name="first_sap">
First Leafing Out Average Date <input type="text" name="first_leaf">
</div>

<p class="heading">Click to add Repellent and Attraction information </p><div class="content">General attraction characteristics:
Attractive to beneficial insects for laying: 
<input type="radio" name="beneficial_insect_laying" value="not_known">Not Known
<input type="radio" name="beneficial_insect_laying" value="yes">Yes
<input type="radio" name="beneficial_insect_laying" value="no">No
<br>Attractive to beneficial insects for food:	 
<input type="radio" name="beneficial_insect_nectar_or_food" value="not_known">Not Known
<input type="radio" name="beneficial_insect_nectar_or_food" value="yes">Yes
<input type="radio" name="beneficial_insect_nectar_or_food" value="no">No

<br>Attractive to Beneficial Insects for shelter: 	
	<input type="radio" name="beneficial_insect_shelter" value="not_known">Not Known
<input type="radio" name="beneficial_insect_shelter" value="yes">Yes
<input type="radio" name="beneficial_insect_shelter" value="no">No
<br>
Flowering time for attracting beneficial predators:  <input type=text name="flowering_time_min"> to  <input type=text name="flowering_time_max">

<br>Pests Scientific name:   <input type=text name="pests_scientificname">  Common Name <input type=text name="pests_commonname">

<br>Predators of pests: 
<input type=text name="predators_scientificname">  Common Name <input type=text name="predators_commonname">

<br>Characteristics of deterrence:
<input type="checkbox" name="Deterrence_characteristics[]" value="not_known">Not known
<input type="checkbox" name="Deterrence_characteristics[]" value="Pest_Resistant">Pest Resistant
<br><input type="checkbox" name="Deterrence_characteristics[]" value="Trap_Plant">Trap Plant
<input type="checkbox" name="Deterrence_characteristics" value="Pest_Confuser">Pest Confuser
<br><input type="checkbox" name="Deterrence characteristics[]" value="Deer_unpalatable">Deer unpalatable
<input type="checkbox" name="Deterrence_characteristics[]" value="Rabbit_unpalatable">Rabbit unpalatable
<input type="checkbox" name="Deterrence_characteristics[]" value="aphid_unpalatable">Aphid unpalatable
<br><input type="checkbox" name="Deterrence_characteristics[]" value="cabbage_worm_unpalatable">Cabbage worm unpalatable
<input type="checkbox" name="Deterrence_characteristics[]" value="leafhoppers_unpalatable">Leafhopper unpalatable
<br><input type="checkbox" name="Deterrence_characteristics[]" value="plum_curculio_unpalatable">Plum curculio unpalatable
<input type="checkbox" name="Deterrence_characteristics[]" value="other">Other
<br>Other: 
<input type=text name="other_deterrence"> </div>
</div> 
<br><input type="submit">
	</form> '. "\n";
			
			/* $output is your variable, you're adding to it by using the ".=" operator (it's like += for strings) */
			

			
			/* whatever you return will display in the source of your page */
			
		}
		return $output; 					
	} 
/*******************************************************************************************/

} /* end of Class */

 
$plantSite = new Plantopia;
 

?>