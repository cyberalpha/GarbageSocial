<?php defined('_JEXEC') or die('Restricted access');
// Core connection functions are provided by the api. We need to include this file.
require "contentmap-api.php";

// Define our custom connector by overriding the Load() method
class usersGoogleMapMarkers extends GoogleMapMarkers
{
	protected function Load()
	{
		require_once realpath(dirname(__FILE__)) . "/../../../configuration.php";
		$config = new JConfig();
		$db = mysql_connect($config->host, $config->user, $config->password) or die("Database connection failed");
		mysql_select_db($config->db) or die(mysql_error());


		// This expression filters valid coordinates.
		$regex = '^"[+-]?[0-9]{1,2}([.][0-9]{1,})?[ ]{0,},[ ]{0,}[+-]?[0-9]{1,3}([.][0-9]{1,})?"$';

		// Build our custom query
		$query = "SELECT u.name, u.email, p.profile_value
		FROM " . $config->dbprefix . "user_profiles as p LEFT JOIN " . $config->dbprefix . "users as u ON p.user_id = u.id
		WHERE profile_key  = 'profile.aboutme'
		AND profile_value REGEXP '$regex'
		";
		// Run our custom query. It is specific for joomla users
		$dataset = mysql_query($query, $db) or die(mysql_error());

		while ($record = mysql_fetch_array($dataset, MYSQL_ASSOC))
		{
			// Create a new empty array *each cycle*
			$content = array();

			// Nickname
			$content["title"] = $record["name"];

			$record["profile_value"] = str_replace('"', '', $record["profile_value"]);
			$coordinates = explode(",", $record["profile_value"]);
			// Google map js needs them as two separate values (See constructor: google.maps.LatLng(lat, lon))
			$content["latitude"] = floatval($coordinates[0]);
			$content["longitude"] = floatval($coordinates[1]);

			// Infowindow content
			$content["html"] =
			'<div style="font-weight:bold;">' . $record["name"] . "</div>" .
			'<div class="created">' . $record["email"] . "</div>";

			// Add this record to the stack
			$this->Contents[] = $content;
		}

		mysql_close($db);
	}
}

// Create an instance of our custom connector
$mymarkers = new usersGoogleMapMarkers();

// output the data
echo $mymarkers;
