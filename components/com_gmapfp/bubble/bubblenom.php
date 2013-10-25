<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.7.x
	* Version 10.25pro
	* Creation date: Décembre 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

$bubble = ($this->_num_marqueurs+1000).", \"<div class='gmapfp_marqueur' style='overflow-y:auto;';><span class='titre'>".$nom."</span>";
$bubble.="<br />".$plus_detail."</div>\",\"";

return $bubble;
?>