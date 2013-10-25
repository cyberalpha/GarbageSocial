<?php
/**
 * @package		 Ultimate Google AdSense Plugin By Internet Partner
 * @subpackage	 Advertisement
 * @copyright    Copyright (C) 2011 Internet Partner Agency <office@internetpartner.info>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgContentUGAPBW extends JPlugin {
    
    public function __construct($subject, $params){
        
        parent::__construct($subject, $params);
    
    }   
    
	public function onContentPrepare($context, &$article, &$params, $limitstart) {

        if( JRequest::getWord( "view" ) == "article" ) { 

		    $app =& JFactory::getApplication();
		    if( $app->isAdmin() ) { return; }

		    $doc = JFactory::getDocument();     
		    if( $doc->getType() != "html" ) { return; }

			$ips = array_map( "trim", explode( ",", $this->params->get( 'blockedIPs' ) ) );
			if( in_array( $_SERVER["REMOTE_ADDR"], $ips ) ) { return "<div style='clear:both;'>".$this->params->get('altMessage')."</div>"; }


			$ads = array();   

			if( isset($article) == null || empty($article->id) || isset($this->params) == null ) { return; }  
    	
			foreach( array('top', 'middle', 'bottom') as $type ) {
				$ads[$type] = $this->prepareAdSenseCode($article, $params, $type);			
			}		

			if( stripos($article->text, '{NO_TOP_ADSENSE}') != false ) {
				unset( $ads['top'] );
			}
			if( stripos($article->text, '{NO_MIDDLE_ADSENSE}') != false ) {
				unset( $ads['middle'] );
			}
			if( stripos($article->text, '{NO_BOTTOM_ADSENSE}') != false ) {
				unset( $ads['bottom'] );
			}

			if ( $this->params->get('topShow') == 'only_with_tag' and stripos($article->text, '{TOP_ADSENSE}') === false ) { 
				unset( $ads['top'] );
			}  
			if ( $this->params->get('middleShow') == 'only_with_tag' and stripos($article->text, '{MIDDLE_ADSENSE}') == false ) { 
				unset( $ads['middle'] );
			} 
			if ( $this->params->get('bottomShow') == 'only_with_tag' and stripos($article->text, '{BOTTOM_ADSENSE}') === false ) { 
				unset( $ads['bottom'] );
			} 			
			
			if( isset( $ads['middle'] ) ) {
				if( stripos($article->text, '{MIDDLE_ADSENSE}') != false ) {
					$article->text = str_ireplace("{MIDDLE_ADSENSE}", $ads['middle'], $article->text);				
				} 
				else {
					$array = explode('<p>', $article->text);
					$count = count($array);			
					if( $count == 1 ) {
						$article->text .= $ads['middle'];			
					}
					else {
						$article->text = str_replace("<p> </p>", "########!!!!!!@@@@@@@%%%%%%%%", $article->text);				
						$temp = $added = null;
						for($i=0; $i<$count; $i++) {
							$temp .= "<p>".$array[$i];
							if( $added == null ) {
								if( $count < 4 && $i == 1 ) { $temp .= $ads['middle'];	$added = true; }						
								else if( $count < 5 && $i == 2 ) { $temp .= $ads['middle'];	$added = true; }
								else if( $i == 3 ) { $temp .= $ads['middle']; $added = true; }
							}
						}
					}
					$article->text = $temp;										
					$article->text = str_replace("########!!!!!!@@@@@@@%%%%%%%%", "<p> </p>", $article->text);
				}					
			}
			if( isset( $ads['top'] ) ) {
				if( stripos($article->text, '{TOP_ADSENSE}') != false ) {
					$article->text = str_ireplace("{TOP_ADSENSE}", $ads['top'], $article->text);				
				} 
				else {			
					$article->text = $ads['top'].$article->text;	
				}
			}			
			if( isset( $ads['bottom'] ) ) {
				if( strpos($article->text, "{BOTTOM_ADSENSE}") != false ) {
					$article->text = str_ireplace("{BOTTOM_ADSENSE}", $ads['bottom'], $article->text);				
				} 
				else {	
					$article->text = $article->text.$ads['bottom'];	
				}
			}			
			$article->text = str_ireplace(
				array("{MIDDLE_ADSENSE}", "{BOTTOM_ADSENSE}", "{TOP_ADSENSE}", 
						"{NO_MIDDLE_ADSENSE}", "{NO_BOTTOM_ADSENSE}", "{NO_TOP_ADSENSE}"
				), "", $article->text
			);
		}
	}
	
    private function prepareAdSenseCode(&$article, &$params, &$type){

		if( $this->params->get( $type.'Enabled' ) == 0 ) { return; }
                     
		// Exluded Articles
		$excludedCats    = $this->params->get( 'excludeCats' );
		$excludeArticles = $this->params->get( 'excludeArticles' );
		if( $excludedCats )    { array_map( "trim", $excludedCats = explode(',', $excludedCats) ); }
		if( $excludeArticles ) { array_map( "trim", $excludeArticles = explode(',', $excludeArticles) ); }
		settype($excludedCats, 	  'array');
		settype($excludeArticles, 'array');
		if( in_array( $article->catid, $excludedCats ) || in_array( $article->id, $excludeArticles ) ) { return; }


        $publisherId = $this->params->get($type.'PublisherId');
        $slotId      = $this->params->get($type.'Slot');
        $adType  	 = $this->params->get($type.'Type');  
        $unitName  	 = $this->params->get($type.'Name'); 
        $adFormat    = $this->params->get($type.'Format');
        $format    	 = explode("-", $adFormat);
        $width       = explode("x", $format[0]);
        $height      = explode("_", $width[1]);
		                
		$emptyLine = $title = $style = null;
        if ( $this->params->get($type.'EmptyLine') == "yes" ) { $emptyLine = "<br />\n"; }
        if ( $this->params->get($type.'Title') ) { $title = "\t\t<p>".$this->params->get($type.'Title')."</p>"; }  
        if ( $this->params->get($type.'Style') ) { $style = "style='".$this->params->get($type.'Style')."'"; }            
       if ( $this->params->get($type.'Class') ) { $style = "class='".$this->params->get($type.'Class')."'"; }        
        return  $emptyLine."<div ".$style." ".$class.">".$title.'
		<!-- Ultimate Google AdSense Plugin By Internet Partner http://internetpartner.info -->        
		<script type="text/javascript"><!--
			google_ad_client = "' . $publisherId . '";
			/* "' . $unitName . '" */
			google_ad_slot = "' . $slotId . '";
			google_ad_width = "' . $width[0] . '";
			google_ad_height = "' . $height[0] . '";
			//-->
		</script>
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script></div>'.$emptyLine.$emptyLine;

    }    
}
