<?php
######################################################################
# Google Analytics for Joomla plugin     	          	          	 #
# Copyright (C) 2010 by Analytics for Joomla	   	   	   	   	   	 #
# Homepage   : www.analyticsforjoomla.com		   	   	   	   	   	 #
# Author     : Martijn van Vreeden   		   	   	   	   	   	   	 #
# Email      : info@analyticsforjoomla.com 	   	   	   	   	   	   	 #
# Version    : 1.0	                       	   	    	   	   	     #
# License    : http://www.gnu.org/copyleft/gpl.html GNU/GPL          #
######################################################################

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin');


class plgSystemgoogleanalytics4joomla extends JPlugin
{

	function onAfterRender()
		{
		$mainframe = &JFactory::getApplication();

		if($mainframe->isAdmin() || strpos($_SERVER["PHP_SELF"], "index.php") === false || JRequest::getVar('format','html') != 'html'){
			return;
		}

		$ua_id = $this->params->get('ua_id', '');
		$tracking_mode = $this->params->get('tracking_mode', '0');
			
		if($ua_id == '' || $mainframe->isAdmin() || strpos($_SERVER["PHP_SELF"], "index.php") === false)
		{
			return;
		}

		if (strstr($ua_id, 'UA-') == false) {
			$ua_id = 'UA-'. $ua_id;
		}
		$domain = $this->remove_subdomain();
		$buffer = JResponse::getBody();

		$javascript = '
<!-- Google Analytics for Joomla 1.6 by Analytics For Joomla v1.0 | http://www.analyticsforjoomla.com/ -->
<script type="text/javascript">
';
		$javascript .= "
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '". $ua_id ."']);
  ";
		if ($tracking_mode == 1) {
			$javascript .= "_gaq.push(['_setDomainName', '.". $domain ."']);
";
		} elseif ($tracking_mode == 2) {
			$javascript .= "_gaq.push(['_setDomainName', 'none']);
  _gaq.push(['_setAllowLinker', true]);
";
		}
			$javascript .= "  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!-- End of Google Analytics for Joomla 1.6 by Analytics For Joomla v1.0 -->
";
		
		$buffer = JResponse::getBody();
		$buffer = preg_replace ("/<\/head>/", "\n\n".$javascript."\n\n</head>", $buffer);
		JResponse::setBody($buffer);
		return true;
	}
	
	function remove_subdomain(){
        $url='';
        
        $name=explode('.',$_SERVER['SERVER_NAME']);
        $name=implode('.',array_slice($name,1));

        $url = $name;

        return $url;
	}
}
?>