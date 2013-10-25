<?php defined('_JEXEC') or die('Restricted access');
// Core connection functions are provided by the api. We need to include this file.
require "contentmap-api.php";

// Define our custom connector by overriding the Load() method
class smfGoogleMapMarkers extends GoogleMapMarkers
{
	protected function Load()
	{
		//include("SSI.php");
		//$db = mysql_connect($db_server, $db_user, $db_passwd) or die("Database connection failed");
		//mysql_select_db($db_name) or die(mysql_error());
		$db = mysql_connect("localhost", "mysqluser", "mysqlpass") or die("Database connection failed");
		mysql_select_db("forum_joomla") or die(mysql_error());

		// Some transposition values specific for smf
		$gender = array();
		$gender[0] = "Not specified";
		$gender[1] = "Male";
		$gender[2] = "Female";

		// This expression filters valid coordinates.
		$regex = '^[+-]?[0-9]{1,2}([.][0-9]{1,})?[ ]{0,},[ ]{0,}[+-]?[0-9]{1,3}([.][0-9]{1,})?$';

		// Build our custom query
		$query = "SELECT m.member_name, m.id_member, m.posts, m.gender, t.value
		FROM smf_themes as t LEFT JOIN smf_members as m ON t.id_member = m.id_member
		WHERE variable  = 'coordina'
		AND value REGEXP '$regex'
		";
		// Run our custom query. It is specific for smf
		$dataset = mysql_query($query, $db);

		while ($record = mysql_fetch_array($dataset, MYSQL_ASSOC))
		{
			// Create a new empty array *each cycle*
			$content = array();

			// Nickname
			$content["title"] = $record["member_name"];

			$coordinates = explode(",", $record["value"]);
			// Google map js needs them as two separate values (See constructor: google.maps.LatLng(lat, lon))
			$content["latitude"] = floatval($coordinates[0]);
			$content["longitude"] = floatval($coordinates[1]);

			// Infowindow content
			$content["html"] =
			'<div style="font-weight:bold;">' . $record["member_name"] . "</div>" .
			'<div class="created">' . $gender[$record["gender"]] . "</div>" .
			'<div class="created"><a href="http://forum.joomla.it/index.php?action=profile;area=showposts;u=' . $record["id_member"] . '" target="_blank">Post: ' . $record["posts"] . "</a></div>" .
			'<div class="created"><a href="http://forum.joomla.it/index.php?action=profile;u=' . $record["id_member"] . '" target="_blank">Visualizza profilo</a></div>';

			// Add this record to the stack
			$this->Contents[] = $content;
		}

		mysql_close($db);
	}
}

// Create an instance of our custom connector
$mymarkers = new smfGoogleMapMarkers();

// output the data
echo $mymarkers;
