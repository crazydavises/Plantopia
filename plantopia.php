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
		add_shortcode( 'GetNumericOptions', array( $this, 'GetNumericOptionsShortcode' ) );
		add_shortcode( 'EnumDropDown', array( $this, 'EnumDropDownShortcode' ) );
	}
/*******************************************************************************************/
	function InitDB()
	{
		 /* General tip: put anything you want to display into a string called $output, and return that */
		$output = '';
		/* you probably want to create a database user that can only select and insert (and maybe modify) and use that */
		$this->plantDB = new wpdb('root', '', 'plant_characteristics', '127.0.0.1');
	   	 $this->plantDB->show_errors();
		
		$dbInit = true;
		/* we don't need to display anything from InitDB */
		return $output;
	}
/*******************************************************************************************/
	function AddGeneral($common_name, 
$latin_name, 
$family, 
$resources_for_more_info, 
$alternate_name_language, 
$alternate_names, 
$variety_name, 
$tips )
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

		$this->plantDB->insert( 'images', 
		array( 'PlantID' => $plantID,
		'$_FILES["file"]["name"]'=>$image_name), 
	array('%s') );


		
		$plantID = $this->plantDB->insert_id; 
		
		return $plantID;

	}
/*******************************************************************************************/
	function AddRegionalCharacteristics( $plantID, 
$hardy_min, 
$hardy_max, 
$sunset_zone, 
$chill_min, 
$chill_max, 
$heat_min, 
$heat_max, 
$frost_free_days, 
$sunlight_hours, 
$Koppen_climate_code)
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
function AddHarvesting( $maximum_bearing_lbs, 
$harvest_time_days_after_last_frost_min, 
$harvest_time_days_after_last_frost_max, 
$seedless_fruits, 
$years_until_first_bearing, 
$years_until_full_bearing, 
$storageability, 
$ease_of_harvest, 
$fruiting_frequency_other, 
$fruiting_frequency, 
$fruit_color, 
$fruit_type )
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
	function AddPhysicalCharacteristics($plantID, 
$Alleopathic, 
$Thorns, 
$epiphyte_attractive, 
$percentage_shade_underneath, 
$growth_speed, 
$branch_strength,  
$fire_resistance, 
$after_harvest_regrowth_rate_inches_per_month, 
$mature_size_max, 
$blocks_alleopathy, 
$mature_size_min, 
$life_span_minimum, 
$life_span_maximum, 
$life_span_classifications, 
$flower_color, 
$root_characteristics, 
$plant_shape, 
$leaf_color, 
$fall_leaf_color, 
$leaf_drop, 
$toxicity, 
$other_problems)
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


					
function AddConsumption( $plantID,
$other_edible_for, 
$edible_for, 
$human_edibility, 
$other_edible_uses, 
$edible_uses)
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
 


					
function AddProcessing( $plantID, 
$other_vegetable_processes,
 $vegetable_processes, 
$other_fruit_processing, 
$fruit_processing, 
$alcohol_processes_resources,
 $description_alcohol_processes_tools, 
$alcohol_processes, 
$alcohol_processes_resources)
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
 

					
function AddMedicinals( $plantID, 
$medicinal_uses, 
$other_medicinal_uses, 
$medicinaluseskey, 
$medicine_processes_resources, 
$medicine_processes_other, 
$medicine_processes)
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
 
					
function AddIncomeStreams( $plantID, 
$market_resource_website, 
$zipcode_of_current_market, 
$country_of_current_market, 
$marketing_strategies, 
$other_marketing_strategies)
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


function AddPropagation( $plantID, 
$other_grafting_method, 
$grafting_methods, 
$seeds_per_pound, 
$country, 
$seedling_vigor, 
$seed_size_in_mm, 
$seed_color, 
$seed_shape,
$light_requirements_hours_per_day, 
$time_to_germination, 
$time_to_germination, 
$percentage_germination, 
$transplantability, 
$seed_resources, 
$seeding_instructions, 
$plant_propagation_method, 
$plant_propagation_tips)
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


function AddPlantFunctions( $plantID, 
$non_food_use_other, 
$nonfoodusekey, 
$Non_food_Use, 
$nutrient_fixing, 
$CN_ratio_dried_plant, 
$CN_ratio_fresh_plant, 
$biodynamic_accumulator_mulch_plant, 
$lumber_usage, 
$mushroom_substrate,
 $mushroom_substrate_species, 
$beauty_products, 
$other_beauty_products, 
$pollutant_cleaning_capabilities, 
$sap_use, $other_sap_use)
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





function AddHabitatandCommunity($plantID, 
$plant_functions_in_environment, 
$layers_plant_type, 
$other_plant_guilds, 
$plantguildskey, 
$plant_guilds, 
$landscape_application, 
$other_landscape_application, 
$soil_content_preferences, 
$other_content_preferences, 
$tolerates_drought, 
$erosion_control_use, 
$juglone_tolerant, 
$pollution_tolerant, 
$storm_water_retention, 
$soil_salinity_tolerant, 
$sun_tolerance_hrs, 
$altitude_preference_min, 
$rooftop_garden, 
$container_plant, 
$altitude_preference_max, $terrarium, 
$tolerates_flooding, 
$hedge_wind_control, 
$compact_soil_breaker, 
$coppiceable_poulardable, 
$native_habitat, 
$nativehabitatkey)

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




function AddDiseases($plantID, 
$plant_diseases_other, 
$plant_diseaseskey, 
$plant_diseaseskey, 
$disease_treatments_description, 
$disease_treatments_resources)
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


function AddMaintenance($plantID, 
$fruiting_habit, 
$other_fruiting_habit, 
$litter_type, 
$other_litter_type, 
$propagation_control_methods, 
$other_propagation_control_methods, 
$growth_season, 
$extra_watering_needed, 
$extra_observation_needed, 
$vegetable_season) 


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


function AddAttractionandrepulsion($plantID, 
$Deterrence_characteristics,
 $other_deterrence, 
$flowering_time_min, 
$flowering_time_max, 
$beneficial_insect_laying,
 $beneficial_insect_nectar_or_food, 
$beneficial_insect_shelter, 
$predators_scientificname, 
$predators_commonname, 
$pests_scientificname, 
$pests_commonname )

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
	
	function getNumericOptionsShortcode( $atts )
	{	
		extract( shortcode_atts( array(
				'min_number' => 0,
				'max_number' => 1,
				'label'=>' ' ), $atts ) );
		return $this->getNumericOptions ($min_number, $max_number, $label );
	}
/*******************************************************************************************/	
function enumDropdown($table_name, $column_name, $echo = false)
{

	$selectDropdown = "<select name=\"$column_name\">";
	$values = $this->plantDB->get_var("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
       WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'");

	preg_match('/^enum\((.*)\)$/', $values, $matches);
    
	foreach( explode(',', $matches[1]) as $value )
    {
         $selectDropdown .= "<option value=]" . trim( $value, "'" ) . ">$value</option>";
    }   
	
    $selectDropdown .= "</select>";

	if ($echo)
        echo $selectDropdown;

    return $selectDropdown;
}

function enumDropdownShortcode( $atts )
{
	extract( shortcode_atts( array(
				'table' => '',
				'column' => '',
				'echo'=>false ), $atts ) );
	return $this->enumDropdown($table, $column, $echo);
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

		$plantID = $this->AddGeneral( $_POST["common_name"], 
		$_POST["latin_name"] , $_POST["family"], $_POST["resources_for_more_info"],
		$_POST["alternative_name_language"], $_POST["alternate_names"], 
		$_POST["variety_name"], $_POST["tips"]);
		
		$this->AddRegionalCharacteristics( $plantID, $_POST["hardiness_zone_max"],  
		$_POST["hardiness_zone_min"], $_POST["Sunset_zones"],  
		$_POST["chill_hours_min"], $_POST["chill_hours_max"],  
		$_POST["heat_zone_min"], $_POST["heat_zone_max"],  
		$_POST["frost_free_days_needed"], $_POST["sunlight_hours_for_fruiting"],  
		$_POST["tips"]); 
 
		$this->AddHarvesting( $plantID,  $_POST["maximum_bearing_lbs"],   
		$_POST["harvest_time_days_after_last_frost_min"],   
		$_POST["harvest_time_days_after_last_frost_max"],   
		$_POST["seedless_fruits"],  $_POST["years_until_first_bearing"],   
		$_POST["years_until_full_bearing"],  $_POST["storageability"],   
		$_POST["ease_of_harvest"], $_POST["fruiting_frequency_other"],  
		$_POST["fruiting_frequency"], $_POST["fruit_color"], $_POST["fruit_type"] );
		
		$this->AddPhysicalCharacteristics( $plantID,  $_POST["Alleopathic"],  
		$_POST["Thorns"], $_POST["epiphyte_attractive"],  
		$_POST["percentage_shade_underneath"], $_POST["growth_speed"],  
		$_POST["branch_strength"],  $_POST["fire_resistance"],  
		$_POST["after_harvest_regrowth_rate_inches_per_month"],  
		$_POST["mature_size_max"], $_POST["blocks_alleopathy"],  
		$_POST["mature_size_min"], $_POST["life_span_minimum"],  
		$_POST["life_span_maximum"], $_POST["life_span_classifications"],  
		$_POST["flower_color"], $_POST["root_characteristics"],  
		$_POST["plant_shape"], $_POST["leaf_color"],  
		$_POST["fall_leaf_color"], $_POST["leaf_drop"],  
		$_POST["toxicity"], $_POST["other_problems"]);


		$this->AddConsumption( $plantID, $_POST["other_edible_for"],  
		$_POST["edible_for"], $_POST["human_edibility"],  
		$_POST["other_edible_uses"], $_POST["edible_uses"] );


		$this->AddProcessing( $plantID, $_POST["other_vegetable_processes"],  
		$_POST["vegetable_processes"], $_POST["other_fruit_processing"],  
		$_POST["fruit_processing"], $_POST["alcohol_processes_resources"],  
		$_POST["description_alcohol_processes_tools"], $_POST["alcohol_processes"],  
		$_POST["alcohol_processes_resources"]);

		$this->AddMedicinals( $plantID, $_POST["medicinal_uses"],  
		$_POST["other_medicinal_uses"], $_POST["medicinaluseskey"],  
		$_POST["medicine_processes_resources"], $_POST["medicine_processes_other"],  
		$_POST["medicine_processes"]);

		$this->AddIncomeStreams( $plantID, $_POST["market_resource_website"],  
		$_POST["zipcode_of_current_market"], $_POST["country_of_current_market"],  
		$_POST["marketing_strategies"], $_POST["other_marketing_strategies"]);
	

		$this->AddPropagation($plantID, $_POST["other_grafting_method"],  
		$_POST["grafting_methods"], $_POST["seeds_per_pound"], $_POST["country"],  
		$_POST["seedling_vigor"], $_POST["seed_size_in_mm"], $_POST["seed_color"],  
		$_POST["seed_shape"], $_POST["light_requirements_hours_per_day"],  
		$_POST["time_to_germination"], $_POST["time_to_germination"],  
		$_POST["percentage_germination"], $_POST["transplantability"],  
		$_POST["seed_resources"], $_POST["seeding_instructions"],  
		$_POST["plant_propagation_method"], $_POST["plant_propagation_tips"]);


		$this->AddPlantFunctions( $plantID, $_POST["non_food_use_other"],  
		$_POST["nonfoodusekey"], $_POST["Non_food_Use"], $_POST["nutrient_fixing"],  
		$_POST["CN_ratio_dried_plant"], $_POST["CN_ratio_fresh_plant"],  
		$_POST["biodynamic_accumulator_mulch_plant"], $_POST["lumber_usage"],  
		$_POST["mushroom_substrate"], $_POST["mushroom_substrate_species"],  
		$_POST["beauty_products"], $_POST["other_beauty_products"],  
		$_POST["pollutant_cleaning_capabilities"], $_POST["sap_use"],  
		$_POST["other_sap_use"]);


		$this->AddHabitatandCommunity($plantID, $_POST["plant_functions_in_environment"], 
		 $_POST["layers_plant_type"], $_POST["other_plant_guilds"],  
		$_POST["plantguildskey"], $_POST["plant_guilds"],  
		$_POST["landscape_application"], $_POST["other_landscape_application"], 
		 $_POST["soil_content_preferences"], $_POST["other_content_preferences"],  
		$_POST["tolerates_drought"], $_POST["erosion_control_use"],  
		$_POST["juglone_tolerant"], $_POST["pollution_tolerant"],  
		$_POST["storm_water_retention"], $_POST["soil_salinity_tolerant"], 
		 $_POST["sun_tolerance_hrs"], $_POST["altitude_preference_min"], 
		 $_POST["rooftop_garden"], $_POST["container_plant"],  
		$_POST["altitude_preference_max"], $_POST["terrarium"],  
		$_POST["tolerates_flooding"], $_POST["hedge_wind_control"],  
		$_POST["compact_soil_breaker"], $_POST["coppiceable_poulardable"],  
		$_POST["native_habitat"], $_POST["nativehabitatkey"], $_POST["indication_of"]);

		$this->AddDiseases($plantID, $_POST["plant_diseases_other"],  
		$_POST["plant_diseaseskey"], $_POST["plant_diseaseskey"],  
		$_POST["disease_treatments_description"], $_POST["disease_treatments_resources"]);


		$this->AddMaintenance($plantID, $_POST["fruiting_habit"], 
		$_POST["other_fruiting_habit"], $_POST["litter_type"],  
		$_POST["other_litter_type"], $_POST["propagation_control_methods"],  
		$_POST["other_propagation_control_methods"], $_POST["growth_season"],  
		$_POST["extra_watering_needed"], $_POST["extra_observation_needed"],  
		$_POST["vegetable_season"]); 


		$this->AddAttractionandrepulsion($plantID, $_POST["Deterrence_characteristics"], 
		 $_POST["other_deterrence"], $_POST["flowering_time_min"],  
		$_POST["flowering_time_max"], $_POST["beneficial_insect_laying"],  
		$_POST["beneficial_insect_nectar_or_food"],  
		$_POST["beneficial_insect_shelter"], $_POST["predators_scientificname"], 
		 $_POST["predators_commonname"], $_POST["pests_scientificname"],  
		$_POST["pests_commonname"]);




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
	&& ($_FILES["file"]["size"] < 2097152)
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

$output .= '</head>' . PHP_EOL;
$output .= '<body>' . PHP_EOL;
$output .= '<form  method="post" enctype="multipart/form-data"  action="">' . PHP_EOL;
$output .= '<br><div class="layers">' . PHP_EOL;
$output .= '<p class="heading">' . PHP_EOL;
$output .= 'Click to add General Information</p> ' . PHP_EOL;
$output .= '<div class="content">' . PHP_EOL;
$output .= 'Scientific Name:<input type="text" name="latin_name"  required>' . PHP_EOL;
$output .= '<br>Common Name: <input type="text" name="common_name">' . PHP_EOL;
$output .= '<br>Family: <input type="text" name="family">' . PHP_EOL;
$output .= '<br>Resources for more information:  <input type="text" name="resources_for_more_info"> ' . PHP_EOL;
$output .= '<br>Alternate Names: <input type="text" name="alternate_names"> ' . PHP_EOL;
$output .= '<br>Language of name: <input type="text" name="alternate_name_language">  ' . PHP_EOL;
$output .= '<br>Variety: <input type="text" name="variety_name">' . PHP_EOL;
$output .= '<br> Tips: <textarea cols="30" rows="3" input type="text" name="Tips"></textarea>' . PHP_EOL;
$output .= '<br>Add up to three images, all files must be under 1 MB in size and must have image file extensions. <label for="file">Filename:</label>' . PHP_EOL;
$output .= '<input type="file" name="file" id="file">' . PHP_EOL;
$output .= '<br><label for="file">Filename:</label>' . PHP_EOL;
$output .= '<input type="file" name="file" id="file">' . PHP_EOL;
$output .= '<br><label for="file">Filename:</label>' . PHP_EOL;
$output .= '<input type="file" name="file" id="file">' . PHP_EOL;
$output .= 'ADD ZIP CODE LINK' . PHP_EOL;
$output .= '</div> ' . PHP_EOL;

  /* end General Information */

$output .= '<p class="heading">Click to add Zone Information</p>' . PHP_EOL;
$output .= '<div class="content">' . PHP_EOL;
$output .= 'Hardiness Zone Minimum: ' . PHP_EOL;
$output .= '<select name="hardiness_zone_min">' . PHP_EOL;
$output .= '<option value=14>Not Known</option>' . PHP_EOL;
$output .= $this->getNumericOptions( 1, 13, "Zone" ) . PHP_EOL;
$output .= '</select>' . PHP_EOL;
$output .= '<br>Hardiness Zone Maximum: ' . PHP_EOL;
$output .= '<select name="hardiness_zone_max">' . PHP_EOL;
$output .= '<option value=14>Not Known</option>' . PHP_EOL;
$output .= $this->getNumericOptions( 1, 13, "Zone" )  . PHP_EOL;
$output .= '</select>' . PHP_EOL;
$output .= ' <br> Sunset Zones divided by commas: <input type="text" name="Sunset_zones">  <br> ' . PHP_EOL;
$output .= 'Koppen Climate Code divided by commas:' . PHP_EOL;
$output .= '<input name="Koppen_climate_code" type="text">' . PHP_EOL;
$output .= '<br>Heat Zone Minimum:  <select name="heat_zone_min">' . PHP_EOL;
$output .= '<option value=14>Not Known</option>' . PHP_EOL;
$output .= $this->getNumericOptions( 1, 12, "Zone" ) . PHP_EOL;
$output .=  '</select>' . PHP_EOL;
$output .= 'Heat Zone Maximum: ' . PHP_EOL;
$output .= '<select name="heat_zone_max">' . PHP_EOL;
$output .= '<option value=14>Not Known</option>' . PHP_EOL;
$output .= $this->getNumericOptions( 1, 12, "Zone" )  . PHP_EOL;
$output .= ' </select>' . PHP_EOL;
$output .= ' <br>Chill Hours Min: <input type="text" name="chill_hours_max"> ' . PHP_EOL;
$output .= 'Chill Hours Max: <input type="text" name="chill_hours_min"> </div>' . PHP_EOL;

  /* end zone Information */


$output .= ' <p class="heading">Click to add Physical Characteristics Information</p>' . 

PHP_EOL;
$output .= '<div class="content">Mature size in feet <input type"text" 

name="mature_size_min">" ' . PHP_EOL;
$output .= 'to <input type"text" name="mature_size_max">"' . PHP_EOL;
$output .= '<br> Growth Speed:  ' . PHP_EOL;
$output .= $this->enumDropdown(physical_characteristics, growth_speed) . PHP_EOL;
 $output .= ' Branch strength: ' . PHP_EOL;
$output .= $this->enumDropdown(physical_characteristics, branch_strength) . PHP_EOL;
 $output .= ' Fire resistance: ' . PHP_EOL;
$output .= $this->enumDropdown(physical_characteristics, fire_resistance) . PHP_EOL;
 $output .= ' <br>Life span classifications: ' . PHP_EOL;
$output .= $this->enumDropdown(life_span_classifications, life_span_classifications) . 

PHP_EOL;
 $output .= '  Perennial plant expected life span:  ' . PHP_EOL;
$output .= '<input type="text" name="life_span_minimum"> ' . PHP_EOL;
$output .= 'to <input type="text" name="life_span_maximum">' . PHP_EOL;
$output .= '<br>Alleopathic: ' . PHP_EOL;
$output .= '<input type="radio" name="Alleopathic" value="not_known" checked="checked">Not 

known		' . PHP_EOL;
$output .= '<input type="radio" name="Alleopathic" value="Yes">Yes ' . PHP_EOL;
$output .= '<input type="radio" name="Alleopathic" value="No">No ' . PHP_EOL;
$output .= '<br>Blocks Alleopathy: ' . PHP_EOL;
$output .= '<input type="radio" name="blocks_alleopathy" value="not_known" 

checked="checked">Not known ' . PHP_EOL;
$output .= '<input type="radio" name="blocks_alleopathy" value="Yes">Yes ' . PHP_EOL;
$output .= '<input type="radio" name="blocks_alleopathy" value="No">No ' . PHP_EOL;
$output .= '<br>Thorns ' . PHP_EOL;
$output .= '<input type="radio" name="Thorns" value="yes">Yes ' . PHP_EOL;
$output .= '<input type="radio" name="Thorns" value="no">No ' . PHP_EOL;
$output .= '<input type="radio" name="Thorns" value="not_known" checked="checked">Not known' . 

PHP_EOL;	
$output .= '<br> Epiphyte Attractive: ' . PHP_EOL;
$output .= '<input type="radio" name="epiphyte_attractive" value="yes">Yes ' . PHP_EOL;
$output .= '<input type="radio" name="epiphyte_attractive" value="no">No' . PHP_EOL;
 $output .= '<input type="radio" name="epiphyte_attractive" value="not_known" 

checked="checked">Not known ' . PHP_EOL;
$output .= '<br> Percentage of shade underneath plant: ' . PHP_EOL;
$output .= '<input type="text" name="percentage_shade_underneath">' . PHP_EOL;
$output .= '<br> After coppice/cut/mow regrowth rate in inches per month: <input type="text" 

name="after_harvest_regrowth_rate_inches_per_month">' . PHP_EOL;
$output .= '<br>Leaf Characteristics:  Leaf color: ' . PHP_EOL;
$output .= $this->enumDropdown(leaf_characteristics, leaf_color) . PHP_EOL;
 $output .= ' Fall Leaf Color: ' . PHP_EOL;
$output .= $this->enumDropdown(leaf_characteristics, fall_leaf_color)  . PHP_EOL;
 $output .= ' Leaf Drop: ' . PHP_EOL;
$output .= $this->enumDropdown(leaf_characteristics, leaf_drop)  . PHP_EOL;
$output .= '<br>Plant Shape:' . PHP_EOL;
$output .= $this->enumDropdown(plant_shape, plant_shape)  . PHP_EOL; 
$output .= ' <br> Toxicity: ' . PHP_EOL;
$output .= $this->enumDropdown(problems, toxicity)  . PHP_EOL;
$output .= 'Other Problems: <textarea rows="1" cols="20" input type="text" 

name="other_problems">	</textarea>' . PHP_EOL;
$output .= '<br> Root Characteristics:  ' . PHP_EOL;
$output .= $this->enumDropdown(root_characteristics, root_characteristics) . PHP_EOL;
 $output .= ' Flower Color: ' . PHP_EOL;
$output .= $this->enumDropdown(flower_color, flower_color)  . PHP_EOL;
 $output .= '</div>' . PHP_EOL;

  /* end physical Characteristics Information */

 $output .= '<p class="heading">Click to add Harvesting Information</p>' . PHP_EOL;
$output .= '<div class="content">' . PHP_EOL;
$output .= 'Plant Part for harvest: <br>' . PHP_EOL;
$output .= 'Total sunlight hours needed for fruiting: ' . PHP_EOL;
$output .= '<input type="text" name="sunlight_hours_for_fruiting">' . PHP_EOL;
$output .= 'Frost free days needed for harvest: ' . PHP_EOL;
$output .= '<input type="text" name="frost_free_days_needed">' . PHP_EOL;
$output .= '<br>Ease of harvest: ' . PHP_EOL;
$output .= $this->enumDropdown(harvesting, ease_of_harvest) . PHP_EOL;
$output .= '<br>Maximum bearing in lbs. <input type="text" name="maximum_bearing_lbs">' . PHP_EOL; 
$output .= '<br>Harvest time after last frost minimum: <input type="text" 
name="harvest_time_days_after_last_frost_min"> ' . PHP_EOL;
$output .= 'Harvest time after last frost maximum: <input type="text" 
name="harvest_time_days_after_last_frost_max"> ' . PHP_EOL;
$output .= '<br>Seedless fruits:  <input type="radio" name="seedless_fruits" value="not_known" checked="checked">Not known' . PHP_EOL;
$output .= '<input type="radio" name="seedless_fruits" value="yes">Yes ' . PHP_EOL;
$output .= '<input type="radio" name="seedless_fruits" value="no">No ' . PHP_EOL;
$output .= '<br>Years until first bearing: <input type="text" 
Name="years_until_first_bearing"> ' . PHP_EOL;
$output .= 'Years until full bearing: <input type="text" name="years_until_full_bearing">' . PHP_EOL;
$output .= '<br>Storageability: ' . PHP_EOL;
$output .= $this->enumDropdown(harvesting, storageability) . PHP_EOL;
 $output .= 'Fruit Color: ' . PHP_EOL;
$output .= $this->enumDropdown(fruit_color, fruit_color) . PHP_EOL;
 $output .= 'Fruit Type: ' . PHP_EOL;
$output .= $this->enumDropdown(fruit_type, fruit_type) . PHP_EOL;
 $output .= '<br>Fruiting Frequency: ' . PHP_EOL;
$output .= $this->enumDropdown(fruiting_frequency, fruiting_frequency) . PHP_EOL;
$output .= 'Other: <input name="fruiting_frequency_other" type="text"> ' . PHP_EOL;
$output .= '</div>' . PHP_EOL;
  /* end harvesting Information */

$output .= '<p class="heading">Click to add Consumption information </p>' . PHP_EOL;
$output .= ' <div class="content">Edibility: <br>' . PHP_EOL;
$output .= 'Humans:  ' . PHP_EOL;
$output .= $this->enumDropdown(Human_Consumption, human_edibility) . PHP_EOL;
$output .= 'Edible Uses: ' . PHP_EOL;
$output .= $this->enumDropdown(Human_Consumption, edible_uses) . PHP_EOL;
$output .= 'Other Edible Uses: <input type="text" name="other_edible_uses">' . PHP_EOL;
$output .= '<br>Livestock: <input name="edible_for" type=checkbox value="not_known"> Not Known' . PHP_EOL;
$output .= '<input name="edible_for" type=checkbox value="chicken"> Chicken' . PHP_EOL;
$output .= '<input  name="edible_for" type=checkbox value="sheep"> Sheep' . PHP_EOL;
$output .= '<input name="edible_for" type=checkbox value="goats"> Goats' . PHP_EOL;
$output .= '<input name="edible_for" type=checkbox value="quail"> Quail' . PHP_EOL;
$output .= '<input name="edible_for" type=checkbox value="cattle"> Cattle' . PHP_EOL;
$output .= '<input name="edible_for" type=checkbox value="ducks"> Ducks' . PHP_EOL;
$output .= '<input name="edible_for" type=checkbox value="rabbits"> Rabbits ' . PHP_EOL;
$output .= '<input name="edible_for" type=checkbox value="pigs"> Pigs' . PHP_EOL;
$output .= '<input name="edible_for" type=checkbox value="horses"> Horses ' . PHP_EOL;
$output .= '<input name="edible_for" type=checkbox value="other"> Other' . PHP_EOL;
$output .= '<br>Other Livestock: <input type="text" name="other_edible_for">' . PHP_EOL;
$output .= '</div>' . PHP_EOL;

/*End Edibility information*/

$output .= '<p class="heading"> Click to add Food Processing Information</p>' . PHP_EOL;
$output .= '<div class="content"> Alcohol Processes:   ' . PHP_EOL;
$output .= $this->enumDropdown(alcohol_making, alcohol_processes) . PHP_EOL;
$output .= '<br>Description of Process: <textarea rows="2" cols="20" input type="text" border="0" name="description_alcohol_processes_tools"></textarea>' . PHP_EOL;
$output .= 'Resources for more information: <textarea rows="2" cols="20" border="0"  input type="text"  name="alcohol_processes_resources"></textarea>' . PHP_EOL;
$output .= '<br>Fruit processes:' . PHP_EOL;
$output .= $this->enumDropdown(fruit_processing, fruit_processing) . PHP_EOL;
$output .= '<br>Other Description: <textarea rows="1" cols="20" input type="text" name="other_fruit_processing">	</textarea>' . PHP_EOL;
$output .= '<br>Vegetable Processes:  ' . PHP_EOL;
$output .= $this->enumDropdown(vegetable_processing, vegetable_processes) . PHP_EOL;
$output .= '<br>Other Description: <textarea rows="1" cols="20" input type="text" name="other_vegetable_processes"></textarea>' . PHP_EOL;
$output .= '</div>' . PHP_EOL;

/*End processing information*/




$output .= '<p class="heading">Click to add Medicinal Information</p>' . PHP_EOL;
$output .= '<div class="content">Medicinal uses: ' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="not_known">Not Known<br> ' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="pain">Pain' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="cold">Cold' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="cough">Cough<br>' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="anti_inflammatory">Anti-inflammatory' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="warts">Warts' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="laxative">Laxative<br>' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="menstrual_cycle">Menstrual cycle' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="immune_resilience">Immune system resilience' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="vitamins">Vitamins<br>' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="digestion">Digestion' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="blood_sugar_levels">Blood sugar levels' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="burns">Burns<br>' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="diuretic">Diuretic' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="antifungal">Antifungal' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="antiseptic">Antiseptic<br>' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="antibacterial">Antibacterial' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="heart_protection">Heart protection' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="hormone_stabilization">Hormone stabilization<br>' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="increase_mental_capacity">Increase mental capacity' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="parasites">Parasites' . PHP_EOL;
$output .= '<input type="checkbox" name="medicinal_uses[]" value="other">Other<br>' . PHP_EOL;
$output .= '<br> Other: <input type="text" name="other_medicinal_uses">' . PHP_EOL;
$output .= '<br>Medicinal processing:' . PHP_EOL;
$output .= '<input type="checkbox" name="medicine_processes[]" value="fresh_plant_tincture"> Fresh plant tincture' . PHP_EOL;
$output .= '<input type="checkbox" name="medicine_processes[]" value="dry_plant_tincture"> Dry plant tincture' . PHP_EOL;
$output .= '<input type="checkbox" name="medicine_processes[]" value="tea">Tea ' . PHP_EOL;
$output .= '<input type="checkbox" name="medicine_processes[]" value="syrup">Syrup' . PHP_EOL;
$output .= '<input type="checkbox" name="medicine_processes[]" value="salve">Salve ' . PHP_EOL;
$output .= '<input type="checkbox" name="medicine_processes[]" value="decoction"> Decoction' . PHP_EOL;
$output .= '<input type="checkbox" name="medicine_processes[]" value="other">Other' . PHP_EOL;
$output .= '<br>Other: <input type="text" name="medicine_processes_other">' . PHP_EOL;
$output .= '<br>Resources: <textarea rows="1" columns="20" input type="text" name="medicine_processes_resources"></textarea>' . PHP_EOL;
$output .= '</div>' . PHP_EOL;



  /* end Medicinal Information */

$output .= '<p class="heading">Click to add Income Streams information</p>' . PHP_EOL;
$output .= '<div class="content">Profitability of Crops Resources: <textarea rows="1" cols="20" input type=text name="market_resource_website"> </textarea>' . PHP_EOL;
$output .= '<br>Zipcode of current market: <input type=text name="zipcode_of_current_market"> </input>' . PHP_EOL;
$output .= 'Marketing Strategies: ' . PHP_EOL;
$output .= $this->enumDropdown(marketing_strategies, marketing_strategies) . PHP_EOL;
$output .= '<br>Other Description: <textarea rows="1" cols="20" input type="text" name="other_marketing_strategies"></textarea>' . PHP_EOL;
$output .= '<br>Country of current market: <input type=text name="country_of_current_market"></input> ' . PHP_EOL;
$output .= '</div>' . PHP_EOL;

  /* end income streams Information */

$output .= '<p class="heading">Click to add Propagation of Plants information</p>' . PHP_EOL;
$output .= '<div class="content">Seeds per pound: <input type="text" name="seeds_per_pound">' . PHP_EOL;
$output .= 'Seed size <input type="text" name="seed_size_in_mm">' . PHP_EOL;
$output .= 'Seed color: ' . PHP_EOL;
$output .= $this->enumDropdown(seeds, seed_color) . PHP_EOL;
 $output .= '<br>Seed shape: ' . PHP_EOL;
$output .= $this->enumDropdown(seeds, seed_shape) . PHP_EOL;
 $output .= 'Seedling Vigor:   ' . PHP_EOL;
$output .= $this->enumDropdown(seeds, seedling_vigor) . PHP_EOL;
 $output .= '	Time to Germination in days: <input type="text" name="time_to_germination"> ' . PHP_EOL;
$output .= '<br>Percentage Germination:  <input type="text" name="percentage_germination">  %   &nbsp; &nbsp; &nbsp; &nbsp' . PHP_EOL;
$output .= 'Transplantability:' . PHP_EOL;
$output .= $this->enumDropdown(seeds, transplantability) . PHP_EOL;
$output .= '<br>Light requirements:  <input type="text" name="light_requirements_hours_per_day"> in hours per day.' . PHP_EOL;
$output .= ' &nbsp; &nbsp; &nbsp; &nbsp;Seeding instructions <textarea rows="1" cols="20" input type="text" name="seeding_instructions">	</textarea><br>' . PHP_EOL;
$output .= 'Best Plant Propagation Method: ' . PHP_EOL;
$output .= $this->enumDropdown(Plant_propagations_methods, plant_propagation_method) . PHP_EOL;
$output .= 'Tips for selected plant propagation method: <textarea rows="1" cols="20" input type="text" name="plant_propagation_tips">	</textarea><br>' . PHP_EOL;
$output .= 'Resources for seeds/Commercial availability: <input type="text" name="seed_resources">' . PHP_EOL;
$output .= 'Country of resources <input type="text" name="country">' . PHP_EOL;
$output .= '<br>	Grafting methods:  ' . PHP_EOL;
$output .= $this->enumDropdown(grafting_methods, grafting_methods) . PHP_EOL;
$output .= 'Other Grafting Methods: <textarea rows="1" cols="20" input type="text" name="other_grafting_method">	</textarea><br>' . PHP_EOL;
$output .= '</div>' . PHP_EOL;

  /* end propagation Information */

 $output .= '<p class="heading">Click to add Plant Function Information</p>' . PHP_EOL;
 $output .= '<div class="content">' . PHP_EOL;
 $output .= 'Plant Functions: ' . PHP_EOL;
 $output .= '<input type="checkbox" name="Non_food_Use[]" checked="checked" value="not_known">Not Known<br>' . PHP_EOL;
 $output .= '<input type="checkbox" name="Non_food_Use[]" value="ink/dye">ink/dye<br>' . PHP_EOL;
 $output .= '<input type="checkbox" name="Non_food_Use[]" value="tanning">tanning<br>' . PHP_EOL;
 $output .= '<input type="checkbox" name="Non_food_Use[]" value="weaving">weaving<br>' . PHP_EOL;
 $output .= '<input type="checkbox" name="Non_food_Use[]" value="soap_making">soap making<br>' . PHP_EOL;
 $output .= '<input type="checkbox" name="Non_food_Use[]" value="oil_making">oil making<br>' . PHP_EOL;
 $output .= '<input type="checkbox" name="Non_food_Use[]" value="rope_making">rope making<br>' . PHP_EOL;
 $output .= '<input type="checkbox" name="Non_food_Use[]" value="cloth_making">cloth making<br>' . PHP_EOL;
 $output .= '<input type="checkbox" name="Non_food_Use[]" value="pot_scrubbers_abrasives">pot scrubbers/abrasives<br>' . PHP_EOL;
 $output .= '<input type="checkbox" name="Non_food_Use[]" value="sewing_needle_making">sewing_needle_making<br>' . PHP_EOL;
 $output .= '<input type="checkbox" name="Non_food_Use[]" value="other">other' . PHP_EOL;
 $output .= 'Other: <input type="text" name="non_food_use_other">' . PHP_EOL;
 $output .= '<br> Mushroom Substrate: ' . PHP_EOL;
 $output .= '<input type="radio" name="mushroom_substrate" value="not_known">Not Known<br>' . PHP_EOL;
 $output .= '<input type="radio" name="mushroom_substrate" value="poor">Poor<br>' . PHP_EOL;
 $output .= '<input type="radio" name="mushroom_substrate" value="medium">Medium<br>' . PHP_EOL;
 $output .= '<input type="radio" name="mushroom_substrate" value="good">Good<br>' . PHP_EOL;
 $output .= 'Mushroom Species: <input type="text" name="mushroom_substrate_species">' . PHP_EOL;
 $output .= 'Lumber Usage: ' . PHP_EOL;
$output .= $this->enumDropdown(lumber_useage, lumber_usage) . PHP_EOL;
$output .= ' <br>Other lumber usage: <input type="text" name="other_lumber_use"><br>' . PHP_EOL;
 $output .= 'Nutrient Fixing: ' . PHP_EOL;
 $output .= '<input type="checkbox" name="nutrient_fixing[]" value="not_known">Not Known' . PHP_EOL;
 $output .= '<input type="checkbox" name="nutrient_fixing[]" value="nitrogen">nitrogen' . PHP_EOL;
 $output .= '<input type="checkbox" name="nutrient_fixing[]" value="potassium">potassium' . PHP_EOL;
 $output .= '<br><input type="checkbox" name="nutrient_fixing[]" value="phosphorus">phosphorus' . PHP_EOL;
 $output .= '<input type="checkbox" name="nutrient_fixing[]" value="calcium">calcium' . PHP_EOL;
 $output .= '<input type="checkbox" name="nutrient_fixing[]" value="magnesium">magnesium' . PHP_EOL;
 $output .= '<br><input type="checkbox" name="nutrient_fixing[]" value="sulfer">sulfer' . PHP_EOL;
 $output .= '<input type="checkbox" name="nutrient_fixing[]" value="boron">boron' . PHP_EOL;
 $output .= '<input type="checkbox" name="nutrient_fixing[]" value="copper">copper' . PHP_EOL;
 $output .= '<br><input type="checkbox" name="nutrient_fixing[]" value="iron">iron' . PHP_EOL;
 $output .= '<input type="checkbox" name="nutrient_fixing[]" value="chloride">chloride' . PHP_EOL;
 $output .= '<input type="checkbox" name="nutrient_fixing[]" value="manganese">manganese' . PHP_EOL;
 $output .= '<br><input type="checkbox" name="nutrient_fixing[]" value="molybdenum">molybdenum' . PHP_EOL;
 $output .= '<input type="checkbox" name="nutrient_fixing[]" value="zinc">zinc' . PHP_EOL;
 $output .= '<br>Compost:  CN ratio of dried plant: <input type="text" name="CN_ratio_dried_plant">' . PHP_EOL;
 $output .= '<br>CN ratio of live plant: <input type="text" name="CN_ratio_fresh_plant">' . PHP_EOL;
 $output .= '<br> Biodynamic accumulator mulch plant: ' . PHP_EOL;
$output .= $this->enumDropdown(compost, biodynamic_accumulator_mulch_plant) . PHP_EOL;
 $output .= '<br> Sap Use: ' . PHP_EOL;
$output .= $this->enumDropdown(sap_use, sap_use) . PHP_EOL;
 $output .= '  Other: ' . PHP_EOL;
 $output .= '<input type="text" name="other_sap_use">' . PHP_EOL;
 $output .= '<br> Pollutant Cleaning:  ' . PHP_EOL;
$output .= $this->enumDropdown(pollutant_cleaning, pollutant_cleaning_capabilities) . PHP_EOL;
 $output .= ' Beauty Products:  ' . PHP_EOL;
$output .= $this->enumDropdown(beauty_products, beauty_products) . PHP_EOL;
 $output .= 'Other: <input type="text" name="other_beauty_products">' . PHP_EOL;
 $output .= '</div>' . PHP_EOL;

  /* end function Information */

 $output .= '<p class="heading">Click to add Placement/Community information</p>' . PHP_EOL;
 $output .= '<div class="content">' . PHP_EOL;
 $output .= 'Habitat:Native Habitat(WWF):' . PHP_EOL;
 $output .= ' <input type="checkbox" name="native_habitat[]" value="not_known">Not Known' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="tropical_subtropical_moist_broadleaf_forest">Tropical/Subtropical moist broadleaf forest' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="tropical_subtropical_dry_broadleaf_forests">Tropical/Subtropical dry broadleaf forest' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="tropical_suptropical_coniferous_forest">Tropical/Subtropical coniferous forest' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="temperate_broadleaf_mixed_forest">Temperate mixed broadleaf forest' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="temperate_coniferous_forest">Temperate Coniferous Forest' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="boreal_forests_taiga">Boreal Forests/Taiga' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="tropical_subtropical_grassland">Tropical/Subtropical grasslands' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="savanna_shrubland">Savanna Shrubland' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="temperate_grassland">Temperate grassland' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="flooded_grasslands_savannas">Flooded grassland/savanna' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="montane_grassland_shrublands">Montane grasslands/shrublands' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="tundra">Tundra' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="mediterranean_forest">Mediterranean Forest' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="woodlands_scrub">Woodlands Scrub' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="deserts_xeric_shrublands">Deserts and Xeric Shrublands' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="mangroves">Mangroves' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="large_rivers">Large rivers' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="small_rivers">Small rivers' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="large_lakes">Large lakes' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="small_lakes">Small lakes' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="xeric_basins">Xeric basins' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="polar">Polar' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="temperate_shelf_seas">Temperate shelf seas' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="tropical_coral">Tropical Coral' . PHP_EOL;
 $output .= '<input type="checkbox" name="native_habitat[]" value="other">Other ' . PHP_EOL;
 $output .= '<br> Other native habitats: <input type="text" name="other_native_habitat"> <br>' . PHP_EOL;
 $output .= 'Preferred Habitat Conditions:' . PHP_EOL;
 $output .= 'Tolerates Drought:   ' . PHP_EOL;
$output .= $this->enumDropdown(habitat_preferences, tolerates_drought). PHP_EOL;
 $output .= 'Tolerates Flooding:  '. PHP_EOL;
$output .= $this->enumDropdown(habitat_preferences, tolerates_flooding). PHP_EOL;
 $output .= ' <br> Erosion Control Use: '. PHP_EOL;
$output .= $this->enumDropdown(habitat_preferences, erosion_control_use). PHP_EOL;
 $output .= ' Juglone Tolerant:   '. PHP_EOL;
$output .= $this->enumDropdown(habitat_preferences, juglone_tolerant). PHP_EOL;
$output .= ' <br>Pollution Tolerance:   '. PHP_EOL;
$output .= $this->enumDropdown(habitat_preferences, pollution_tolerant). PHP_EOL;
 $output .= 'Storm Water Retention:   '. PHP_EOL;
$output .= $this->enumDropdown(habitat_preferences, storm_water_retention). PHP_EOL;
 $output .= '   <br>Soil Salinity Tolerance:   '. PHP_EOL;
$output .= $this->enumDropdown(habitat_preferences, soil_salinity_tolerant). PHP_EOL;
 $output .= '   <br>Sun Tolerance in hours:'. PHP_EOL; 
 $output .= '<input type="type" name="sun_tolerance_hrs">'. PHP_EOL; 
 $output .= 'Shade Tolerance in hours: '. PHP_EOL; 
 $output .= '<input type="type" name="shade_tolerance_hrs">'. PHP_EOL; 
 $output .= '<br>Altitude Preference Range: '. PHP_EOL; 
 $output .= '<input type="type" name="altitude_preference_min"> to <input type="type" name="altitude_preference_max">'. PHP_EOL; 
 $output .= '<br> Suitable for:'. PHP_EOL; 
 $output .= '<br> Rooftop Garden:   '. PHP_EOL; 
$output .= $this->enumDropdown(habitat_preferences, rooftop_garden). PHP_EOL;
 $output .= '    Containers:  '. PHP_EOL;
$output .= $this->enumDropdown(habitat_preferences, container_plant). PHP_EOL;
 $output .= '   Live Fences '. PHP_EOL;
$output .= $this->enumDropdown(habitat_preferences, live_fencing). PHP_EOL;
 $output .= '    Terrariums: ' . PHP_EOL;
$output .= $this->enumDropdown(habitat_preferences, terrarium). PHP_EOL;
 $output .= '   <br>Soil Content Preferences: ' . PHP_EOL;
$output .= $this->enumDropdown(soil_content_preferences, soil_content_preferences). PHP_EOL;
 $output .= ' <input type="text" name="other_content_preferences">' . PHP_EOL;
 $output .= '<br>Wind Break Hedge:  ' . PHP_EOL;
$output .= $this->enumDropdown(habitat_preferences, hedge_wind_control). PHP_EOL;
 $output .= '   Breaks up Compact Soil:   '. PHP_EOL;
$output .= $this->enumDropdown(habitat_preferences, compact_soil_breaker). PHP_EOL;
 $output .= ' Coppicable/Poulardable:    ' . PHP_EOL;
$output .= $this->enumDropdown(habitat_preferences, coppiceable_poulardable). PHP_EOL;
 $output .= ' Plant Function Type:   ' . PHP_EOL;
$output .= $this->enumDropdown(plant_functions_in_environment_descriptions, plant_functions_in_environment). PHP_EOL;
 $output .= ' <br>Plant Layer in Forest Garden:   '. PHP_EOL;
$output .= $this->enumDropdown(layers_plant_type, layers_plant_type). PHP_EOL;
 $output .= ' Companion Plant HERE I NEED TO FIGURE OUT HOW TO DO A DROPDOWN LIST OF ALL ADDED PLANTS. DO 3 LISTS.'. PHP_EOL;
 $output .= '<BR> Plant Guilds:   ' . PHP_EOL;
$output .= $this->enumDropdown(plant_guilds, plant_guilds). PHP_EOL;
 $output .= ' Other Plant Guilds:  <input type="text" name="other_plant_guilds">'. PHP_EOL;
 $output .= '<br>Landscape Application:   ' . PHP_EOL;
$output .= $this->enumDropdown(landscape_application, landscape_application) . PHP_EOL;
 $output .= ' Other Landscape application: <input type="text" name="other_landscape_application">'. PHP_EOL;
 $output .= '<br> Plant is an indication of: '. PHP_EOL;
$output .= $this->enumDropdown(habitat_preferences, indication_of). PHP_EOL;
 $output .= '</div> '. PHP_EOL;
   /* end community Information */

 $output .= '<p class="heading">Click to add Disease information </p>'. PHP_EOL;
 $output .= '<div class="content">Plant diseases:  '. PHP_EOL;
 $output .= '<input type="checkbox" name="plant_diseases[]" value="not_known">Not Known'. PHP_EOL;
 $output .= '<br><input type="checkbox" name="plant_diseases[]" value="fire_blight">Fire Blight'. PHP_EOL;
 $output .= '<input type="checkbox" name="plant_diseases[]" value="early_blight">Early Blight'. PHP_EOL;
 $output .= '<br>input type="checkbox" name="plant_diseases[]" value="late_blight">Late Blight'. PHP_EOL;
 $output .= '<input type="checkbox" name="plant_diseases[]" value="bacterial_blight">Bacterial Blight'. PHP_EOL;
 $output .= '<br><input type="checkbox" name="plant_diseases[]" value="cytosporta_cankers"> Cytosporta Cankers'. PHP_EOL;
 $output .= '<input type="checkbox" name="plant_diseases[]" value="nectria_canker">Nectria Canker'. PHP_EOL;
 $output .= '<input type="checkbox" name="plant_diseases[]" value="fruit_rot">Fruit Rot'. PHP_EOL;
 $output .= '<br><input type="checkbox" name="plant_diseases[]" value="root_stem_rots">Root and Stem Rots'. PHP_EOL;
 $output .= '<input type="checkbox" name="plant_diseases[]" value="mushroom_rots">Mushroom Rots'. PHP_EOL;
 $output .= '<input type="checkbox" name="plant_diseases[]" value="asparagus_rot">Asparagus Rust'. PHP_EOL;
 $output .= '<br><input type="checkbox" name="plant_diseases[]" value="other_rusts">Other Rusts'. PHP_EOL;
 $output .= '<input type="checkbox" name="plant_diseases[]" value="stewarts_wilt">Stewarts Wilt'. PHP_EOL;
 $output .= '<input type="checkbox" name="plant_diseases[]" value="verticulum_wilt">Verticulum Wilt'. PHP_EOL;
 $output .= '<input type="checkbox" name="plant_diseases[]" value="other">Other'. PHP_EOL;
 $output .= '<br>Other: '. PHP_EOL;
 $output .= '<input type="text" name="plant_diseases_other">'. PHP_EOL;
 $output .= '<br>Plant varieties that are resistant to diseases: '. PHP_EOL;
 $output .= 'DROP DOWN LIST OF ALL VARIETIES ENTERED FOR THIS PLANT.'. PHP_EOL;
 $output .= '<br> Disease Treatments:  <textarea cols="20" rows="2" input type="text" name="disease_treatments_description"> </textarea>'. PHP_EOL;
 $output .= 'Resources: <textarea cols="20" rows="2" input type="text" name="disease_treatments_resources"> </textarea> '. PHP_EOL;
 $output .= '</div>'. PHP_EOL;

  /* end diseases Information */

 $output .= '<p class="heading">Click to add Growing and Maintenance information</p>  '. PHP_EOL;
$output .= '<div class="content">'. PHP_EOL;
 $output .= 'Vegetable Season: '. PHP_EOL;
 $output .= '<input type="radio" name="vegetable_season" value="not_known">Not known'. PHP_EOL;
 $output .= '<input type="radio" name="vegetable_season" value="cold">Cold season vegetable '. PHP_EOL;
 $output .= '<input type="radio" name="vegetable_season" value="warm"> Warm season vegetable'. PHP_EOL;
 $output .= '<br>Fruiting habit: '. PHP_EOL;
$output .= $this->enumDropdown(fruiting_habit, fruiting_habit). PHP_EOL;
 $output .= ' Other fruiting habit:  <input type="text" name="other_fruiting_habit">'. PHP_EOL;
 $output .= '<br>Litter type:  	'. PHP_EOL;
$output .= $this->enumDropdown(litter_type, litter_type). PHP_EOL;
 $output .= 'Other litter type:  <input type="text" name="other_litter_type">'. PHP_EOL;
 $output .= '<br>Propagation control:'. PHP_EOL;
$output .= $this->enumDropdown(propagation_control_methods, propagation_control_methods) . PHP_EOL;
 $output .= 'Other propagation controls: <input type="text" name="other_propagation_control_methods">'. PHP_EOL;
 $output .= '<br>Seasonal growth and watering: '. PHP_EOL;
 $output .= 'Main season of growth: '. PHP_EOL;
 $output .= '<input type="checkbox" name="growth_season[]" value="early">Early'. PHP_EOL;
 $output .= '<input type="checkbox" name="growth_season[]" value="mid">Mid'. PHP_EOL;
 $output .= '<input type="checkbox" name="growth_season[]" value="late">Late'. PHP_EOL;
 $output .= '<input type="checkbox" name="growth_season[]" value="spring">Spring'. PHP_EOL;
 $output .= '<input type="checkbox" name="growth_season[]" value="summer">Summer'. PHP_EOL;
 $output .= '<input type="checkbox" name="growth_season[]" value="fall">Fall'. PHP_EOL;
 $output .= '<input type="checkbox" name="growth_season[]" value="winter">Winter'. PHP_EOL;
 $output .= '<br>Extra watering needed: '. PHP_EOL;
 $output .= '<input type="checkbox" name="extra_watering_needed[]" value="spring">Spring'. PHP_EOL;
 $output .= '<input type="checkbox" name="extra_watering_needed[]" value="summer">Summer'. PHP_EOL;
 $output .= '<input type="checkbox" name="extra_watering_needed[]" value="fall">Fall'. PHP_EOL;
 $output .= '<input type="checkbox" name="extra_watering_needed[]" value="winter">Winter'. PHP_EOL;
 $output .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Extra observation needed: '. PHP_EOL;
 $output .= '<input type="checkbox" name="extra_observation_needed[]" value="spring">Spring'. PHP_EOL;
 $output .= '<input type="checkbox" name="extra_observation_needed[]" value="summer">Summer'. PHP_EOL;
 $output .= '<input type="checkbox" name="extra_observation_needed[]" value="fall">Fall'. PHP_EOL;
 $output .= '<input type="checkbox" name="extra_observation_needed[]" value="winter">Winter'. PHP_EOL;
 $output .= '<br>First Sap Flow Average Date <input type="text" name="first_sap">'. PHP_EOL;
 $output .= 'First Leafing Out Average Date <input type="text" name="first_leaf">'. PHP_EOL;
 $output .= '</div>'. PHP_EOL;

  /* end Maintenance Information */

 $output .= '<p class="heading">Click to add Repellent and Attraction information </p> '. PHP_EOL;
$output .= '<div class="content">'. PHP_EOL;
 $output .= 'General attraction characteristics:'. PHP_EOL;
 $output .= 'Attractive to beneficial insects for laying: '. PHP_EOL;
 $output .= '<input type="radio" name="beneficial_insect_laying" value="not_known">Not Known'. PHP_EOL;
 $output .= '<input type="radio" name="beneficial_insect_laying" value="yes">Yes'. PHP_EOL;
 $output .= '<input type="radio" name="beneficial_insect_laying" value="no">No'. PHP_EOL;
 $output .= '<br>Attractive to beneficial insects for food:	'. PHP_EOL; 
 $output .= '<input type="radio" name="beneficial_insect_nectar_or_food" value="not_known">Not Known'. PHP_EOL;
 $output .= '<input type="radio" name="beneficial_insect_nectar_or_food" value="yes">Yes'. PHP_EOL;
 $output .= '<input type="radio" name="beneficial_insect_nectar_or_food" value="no">No'. PHP_EOL;
 $output .= '<br>Attractive to Beneficial Insects for shelter: 	'. PHP_EOL;
 $output .= '<input type="radio" name="beneficial_insect_shelter" value="not_known">Not Known'. PHP_EOL;
 $output .= '<input type="radio" name="beneficial_insect_shelter" value="yes">Yes'. PHP_EOL;
 $output .= '<input type="radio" name="beneficial_insect_shelter" value="no">No'. PHP_EOL;
 $output .= '<br>Flowering time for attracting beneficial predators:  <input type=text name="flowering_time_min">'. PHP_EOL;
 $output .= ' to  <input type=text name="flowering_time_max">'. PHP_EOL;
 $output .= '<br>Pests Scientific name:   <input type=text name="pests_scientificname">  '. PHP_EOL;
 $output .= 'Common Name <input type=text name="pests_commonname">'. PHP_EOL;
 $output .= '<br>Predators of pests: '. PHP_EOL;
 $output .= 'Scientific Name <input type=text name="predators_scientificname"> '. PHP_EOL; 
 $output .= 'Common Name <input type=text name="predators_commonname">'. PHP_EOL;
 $output .= '<br>Characteristics of deterrence:'. PHP_EOL;
 $output .= '<input type="checkbox" name="Deterrence_characteristics[]" value="not_known">Not known'. PHP_EOL;
 $output .= '<input type="checkbox" name="Deterrence_characteristics[]" value="Pest_Resistant">Pest Resistant'. PHP_EOL;
 $output .= '<br><input type="checkbox" name="Deterrence_characteristics[]" value="Trap_Plant">Trap Plant'. PHP_EOL;
 $output .= '<input type="checkbox" name="Deterrence_characteristics" value="Pest_Confuser">Pest Confuser'. PHP_EOL;
 $output .= '<br><input type="checkbox" name="Deterrence characteristics[]" value="Deer_unpalatable">Deer unpalatable'. PHP_EOL;
 $output .= '<input type="checkbox" name="Deterrence_characteristics[]" value="Rabbit_unpalatable">Rabbit unpalatable'. PHP_EOL;
 $output .= '<input type="checkbox" name="Deterrence_characteristics[]" value="aphid_unpalatable">Aphid unpalatable'. PHP_EOL;
 $output .= '<br><input type="checkbox" name="Deterrence_characteristics[]" value="cabbage_worm_unpalatable">Cabbage worm unpalatable'. PHP_EOL;
 $output .= '<input type="checkbox" name="Deterrence_characteristics[]" value="leafhoppers_unpalatable">Leafhopper unpalatable'. PHP_EOL;
 $output .= '<br><input type="checkbox" name="Deterrence_characteristics[]" value="plum_curculio_unpalatable">Plum curculio unpalatable'. PHP_EOL;
 $output .= '<input type="checkbox" name="Deterrence_characteristics[]" value="other">Other'. PHP_EOL;
 $output .= '<br>Other: '. PHP_EOL;
 $output .= '<input type=text name="other_deterrence">'. PHP_EOL;
  $output .= '</div> '. PHP_EOL;
 $output .= '</div> '. PHP_EOL;

  /* end attraction and deterrance Information */

 $output .= '<br><input type="submit">'. PHP_EOL;
 $output .= '	</form> '. PHP_EOL; "\n";
			
			/* $output is your variable, you're adding to it by using the ".=" operator (it's like += for strings) */
			

			
			/* whatever you return will display in the source of your page */
			
		}
		return $output; 					
	} 
/*******************************************************************************************/

} /* end of Class */

 
$plantSite = new Plantopia;
 

?>