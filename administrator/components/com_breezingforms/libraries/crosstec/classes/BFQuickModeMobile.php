<?php
/**
* BreezingForms - A Joomla Forms Application
* @version 1.8
* @package BreezingForms
* @copyright (C) 2008-2012 by Markus Bopp
* @license Released under the terms of the GNU General Public License
**/
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

require_once(JPATH_SITE.'/administrator/components/com_breezingforms/libraries/Zend/Json/Decoder.php');
require_once(JPATH_SITE.'/administrator/components/com_breezingforms/libraries/Zend/Json/Encoder.php');

class BFQuickModeMobile{
	
	/**
	 * @var HTML_facileFormsProcessor
	 */
	private $p = null;
	
	private $dataObject = array();
	
	private $rootMdata = array();
	
	private $useErrorAlerts = false;

        private $useDefaultErrors = false;

        private $useBalloonErrors = false;
	
	private $rollover = false;
	
	private $rolloverColor = '';
	
	private $toggleFields = '';
        
        private $hasFlashUpload = false;
	
	private $flashUploadTicket = '';
	
	private $cancelImagePath = '';
	
	private $uploadImagePath = '';
        
        public $forceMobileUrl = '';
        
	function __construct( HTML_facileFormsProcessor $p ){
                $head = JFactory::getDocument()->getHeadData();
                $head['styleSheets'] = array();
                $head['style'] = array();
                $head['scripts'] = array();
                $head['script'] = array();
                $head['custom'] = array();
                JFactory::getDocument()->setHeadData( $head );
                // will make sure mootools loads first, important 4 jquery
                JHtml::_('behavior.framework');
                jimport('joomla.version');
                $version = new JVersion();
                if(version_compare($version->getShortVersion(), '3.0', '<')){
                    JHTML::_('behavior.mootools');
                }
                
                $this->p = $p;
		$this->dataObject = Zend_Json::decode( base64_decode($this->p->formrow->template_code) );
		$this->rootMdata = $this->dataObject['properties'];
		$this->useErrorAlerts = $this->rootMdata['useErrorAlerts'];
                $this->useDefaultErrors = isset($this->rootMdata['useDefaultErrors']) ? $this->rootMdata['useDefaultErrors'] : false;
                $this->useBalloonErrors = isset($this->rootMdata['useBalloonErrors']) ? $this->rootMdata['useBalloonErrors'] : false;
		$this->rollover = $this->rootMdata['rollover'];
		$this->rolloverColor = $this->rootMdata['rolloverColor'];
		$this->toggleFields = $this->parseToggleFields( isset($this->rootMdata['toggleFields']) ? $this->rootMdata['toggleFields'] : '[]' );
		// loading theme
		$this->cancelImagePath = JURI::root(true) . '/media/breezingforms/themes/cancel.png';
		$this->uploadImagePath = JURI::root(true) . '/media/breezingforms/themes/upload.png';
		
                mt_srand();
		$this->flashUploadTicket = md5( strtotime('now') .  mt_rand( 0, mt_getrandmax() ) );
                
	}
        
        public function fetchHead($head)
	{
		$app = JFactory::getApplication();
                
		// Get line endings
		$lnEnd = JFactory::getDocument()->_getLineEnd();
		$tab = JFactory::getDocument()->_getTab();
		$tagEnd = ' />';
		$buffer = '';

		// Generate stylesheet links
		foreach ($head['styleSheets'] as $strSrc => $strAttr)
		{
			$buffer .= $tab . '<link rel="stylesheet" href="' . $strSrc . '" type="' . $strAttr['mime'] . '"';
			if (!is_null($strAttr['media']))
			{
				$buffer .= ' media="' . $strAttr['media'] . '" ';
			}
			if ($temp = JArrayHelper::toString($strAttr['attribs']))
			{
				$buffer .= ' ' . $temp;
			}
			$buffer .= $tagEnd . $lnEnd;
		}

		// Generate stylesheet declarations
		foreach ($head['style'] as $type => $content)
		{
			$buffer .= $tab . '<style type="' . $type . '">' . $lnEnd;

			// This is for full XHTML support.
			if (isset($document) && $document->_mime != 'text/html')
			{
				$buffer .= $tab . $tab . $lnEnd;
			}

			$buffer .= $content . $lnEnd;

			// See above note
			if (isset($document) && $document->_mime != 'text/html')
			{
				$buffer .= $tab . $tab . $lnEnd;
			}
			$buffer .= $tab . '</style>' . $lnEnd;
		}

		// Generate script file links
		foreach ($head['scripts'] as $strSrc => $strAttr)
		{
			$buffer .= $tab . '<script src="' . $strSrc . '"';
			if (isset($strAttr['mime']) && !is_null($strAttr['mime']))
			{
				$buffer .= ' type="' . ( $strAttr['mime'] == 't' ? 'text/javascript' : $strAttr['mime'] ) . '"';
			}
			$buffer .= '></script>' . $lnEnd;
		}

		// Generate script declarations
		foreach ($head['script'] as $type => $content)
		{
			$buffer .= $tab . '<script type="' . $type . '">' . $lnEnd;

			// This is for full XHTML support.
			if (isset($document) && $document->_mime != 'text/html')
			{
				$buffer .= $tab . $tab . $lnEnd;
			}

			$buffer .= $content . $lnEnd;

			// See above note
			if (isset($document) && $document->_mime != 'text/html')
			{
				$buffer .= $tab . $tab . $lnEnd;
			}
			$buffer .= $tab . '</script>' . $lnEnd;
		}

		foreach ($head['custom'] as $custom)
		{
			$buffer .= $tab . $custom . $lnEnd;
		}

		return $buffer;
	}
	
	public function process(&$dataObject, $parent = null, $parentPage = null, $index = 0, $childrenLength = 0){
		if(isset($dataObject['attributes']) && isset($dataObject['properties']) ){
			
			$options = array('type' => 'normal', 'displayType' => 'breaks');
			if($parent != null && $parent['type'] == 'section'){
				$options['type'] = $parent['bfType'];
				$options['displayType'] = $parent['displayType'];
			}
			
			$class = ' class="bfBlock"';
			$wrapper = 'bfWrapperBlock';
			if($options['displayType'] == 'inline'){
				$class = ' class="bfInline"';
				$wrapper = 'bfWrapperInline';
			}
			
			$mdata = $dataObject['properties'];
			
			if($mdata['type'] == 'page'){
				
				$parentPage = $mdata;
				if($parentPage['pageNumber'] > 1){
					echo '</div><!-- bfPage end -->'."\n"; // closing previous pages
				}
				
				echo '<div id="bfPage'.$parentPage['pageNumber'].'" class="bfPage" style="display:none">'."\n"; // opening current page
				
				if(trim($mdata['pageIntro'])!=''){
					
                                        echo '<div class="bfPageIntro">'."\n";
                                        
                                        $regex		= '/{loadposition\s+(.*?)}/i';
                                        $introtext = $mdata['pageIntro'];
                                        
                                        preg_match_all($regex, $introtext, $matches, PREG_SET_ORDER);
                                        
                                        jimport('joomla.version');
                                        $version = new JVersion();
                                        
                                        if ($matches && version_compare($version->getShortVersion(), '1.6', '>=')) {
                                            
                                            $document	= JFactory::getDocument();
                                            $renderer	= $document->loadRenderer('modules');
                                            $options	= array('style' => 'xhtml');
                                            
                                            foreach ($matches as $match) {
                                        
                                                $matcheslist =  explode(',', $match[1]);
                                                $position = trim($matcheslist[0]);
                                                $output = $renderer->render($position, $options, null);
                                                $introtext = preg_replace("|$match[0]|", addcslashes($output, '\\'), $introtext, 1);
                                            }
                                        }
                                        
                                        echo $introtext."\n";
                                        
					echo '</div><div style="padding-bottom: 10px;"></div>'."\n";
				}
				
				if(!$this->useErrorAlerts){
					echo '<span class="bfErrorMessage" style="color: red; display:none;"></span>'."\n";
				}
				
			} else if($mdata['type'] == 'section'){

				if(isset($dataObject['properties']['name']) && isset($mdata['off']) && $mdata['off']){
					echo '<script type="text/javascript"><!--'."\n".'bfDeactivateSection.push("'.$dataObject['properties']['name'].'");'."\n".'//--></script>'."\n";
				}
				
				if($mdata['bfType'] == 'section'){
					echo '<div data-theme="b" data-role="collapsible-set"'.(isset($mdata['off']) && $mdata['off'] ? ' style="display:none" ' : '').(isset($dataObject['properties']['name']) && $dataObject['properties']['name'] != "" ? ' id="'.$dataObject['properties']['name'].'"' : '').'><div data-role="collapsible" data-collapsed="false">'."\n";
					if(trim($mdata['title']) != ''){
						echo '<h3>'.htmlentities(trim($mdata['title']), ENT_QUOTES, 'UTF-8').'</h3>'."\n";
					}
				} 
				else if( $mdata['bfType'] == 'normal' ) {
					if(isset($dataObject['properties']['name']) && $dataObject['properties']['name'] != ''){
						echo '<div '.(isset($mdata['off']) && $mdata['off'] ? 'style="display:none" ' : '').'class="bfNoSection"'.(isset($dataObject['properties']['name']) && $dataObject['properties']['name'] != "" ? ' id="'.$dataObject['properties']['name'].'"' : '').'>'."\n";
					}
				}
				
				if(trim($mdata['description'])!=''){
					echo '<div>'."\n";
                                        
                                        $regex		= '/{loadposition\s+(.*?)}/i';
                                        $introtext = $mdata['description'];
                                        
                                        preg_match_all($regex, $introtext, $matches, PREG_SET_ORDER);
                                        
                                        jimport('joomla.version');
                                        $version = new JVersion();
                                        
                                        if ($matches && version_compare($version->getShortVersion(), '1.6', '>=')) {
                                            
                                            $document	= JFactory::getDocument();
                                            $renderer	= $document->loadRenderer('modules');
                                            $options	= array('style' => 'xhtml');
                                            
                                            foreach ($matches as $match) {
                                        
                                                $matcheslist =  explode(',', $match[1]);
                                                $position = trim($matcheslist[0]);
                                                $output = $renderer->render($position, $options, null);
                                                $introtext = preg_replace("|$match[0]|", addcslashes($output, '\\'), $introtext, 1);
                                            }
                                        }
                                        
					echo $introtext."\n";
					echo '</div><div style="padding-bottom: 10px;"></div>'."\n";
				}
				
			} else if($mdata['type'] == 'element'){
				
                                //echo '<div class="bfElemWrap"'.(isset($mdata['off']) && $mdata['off'] ? ' style="display:none" ' : '').'>';
                            
                                // if labels left 
                                if( true ) {
                                    echo '<div'.(isset($mdata['off']) && $mdata['off'] ? ' style="display:none" ' : '').' id="fieldcontain'.$mdata['bfName'].'" class="bfElemWrap" data-role="fieldcontain">';
                                }
                                
				$onclick = '';
				if($mdata['actionClick'] == 1){
					$onclick = 'onclick="'.$mdata['actionFunctionName'] . '(this,\'click\');" ';	
				}
				
				$onblur = '';
				if($mdata['actionBlur'] == 1){
					$onblur = 'onblur="'.$mdata['actionFunctionName'] . '(this,\'blur\');" ';	
				}
				
				$onchange = '';
				if($mdata['actionChange'] == 1){
					$onchange = 'onchange="'.$mdata['actionFunctionName'] . '(this,\'change\');" ';	
				}
				
				$onfocus = '';
				if($mdata['actionFocus'] == 1){
					$onfocus = 'onfocus="'.$mdata['actionFunctionName'] . '(this,\'focus\');" ';	
				}
				
				$onselect = '';
				if(isset($mdata['actionSelect']) && $mdata['actionSelect'] == 1){
					$onselect = 'onselect="'.$mdata['actionFunctionName'] . '(this,\'select\');" ';	
				}
				
                                $legend = '';
                                
				if(!$mdata['hideLabel'] && $mdata['bfType'] != 'bfPayPal' && $mdata['bfType'] != 'bfSofortueberweisung'){
					
					$maxlengthCounter = '';
					if($mdata['bfType'] == 'bfTextarea' && isset($mdata['maxlength']) && $mdata['maxlength'] > 0 && isset($mdata['showMaxlengthCounter']) && $mdata['showMaxlengthCounter']){
						$maxlengthCounter = ' <span class=***bfMaxLengthCounter*** id=***bfMaxLengthCounter'.$mdata['dbId'].'***>('.$mdata['maxlength'].' '.BFText::_('COM_BREEZINGFORMS_CHARS_LEFT').')</span>';
					}

                                        $for = 'for="ff_elem'.$mdata['dbId'].'"';
                                        if($mdata['bfType'] == 'bfCaptcha' || $mdata['bfType'] == 'bfReCaptcha'){
                                            $for = 'for="bfCaptchaEntry"';
                                            if(JFactory::getApplication()->isSite())
                                            {
                                            $captcha_url = JURI::root(true).'/components/com_breezingforms/images/captcha/securimage_show.php';
                                            }
                                            else
                                            {
                                            $captcha_url = JURI::root(true).'/administrator/components/com_breezingforms/images/captcha/securimage_show.php';
                                            }

                                            echo '<div align="center"><img alt="" border="0" width="230" id="ff_capimgValue" class="ff_capimg" src="'.$captcha_url.'"/></div><br/>'."\n";

                                        }
                                        //else if($mdata['bfType'] == 'bfReCaptcha'){
                                        //    $for = 'for="recaptcha_response_field"';
                                        //}

                                        $req = '';
                                        if($mdata['required']){
                                            $req = '<span class="bfRequired"> *</span>'."\n";
                                        }
                                        
                                        $labelText = $req . trim($mdata['label']) . str_replace("***","\"",$maxlengthCounter);
                                        
                                        if( true && ( $mdata['bfType'] == 'bfCheckboxGroup' || $mdata['bfType'] == 'bfRadioGroup' ) ){
                                            $legend = '<legend id="bfLabel'.$mdata['dbId'].'">'.str_replace("***","\"",$labelText).'</legend>'."\n";
                                        } else if( $mdata['bfType'] == 'bfSummarize' ){
                                            $legend = $labelText;
                                        }else {
                                            echo '<label id="bfLabel'.$mdata['dbId'].'" '.$for.'>'.str_replace("***","\"",$labelText).'</label>'."\n";
                                        }
				}
				
				$readonly = '';
				if($mdata['readonly']){
					$readonly = 'readonly="readonly" ';
				}
				
				$tabIndex = '';
				if($mdata['tabIndex'] != -1 && is_numeric($mdata['tabIndex'])){
					$tabIndex = 'tabindex="'.intval($mdata['tabIndex']).'" ';
				}
			
				for($i = 0; $i < $this->p->rowcount; $i++) {
					$row = $this->p->rows[$i];
					if($mdata['bfName'] == $row->name){
						if( ( isset($mdata['value']) || isset($mdata['list']) || isset($mdata['group']))
							&& 
							( 
								$mdata['bfType'] == 'bfTextfield' ||
								$mdata['bfType'] == 'bfTextarea' ||
								$mdata['bfType'] == 'bfCheckbox' ||
								$mdata['bfType'] == 'bfCheckboxGroup' ||
								$mdata['bfType'] == 'bfSubmitButton' ||
								$mdata['bfType'] == 'bfHidden' ||
								$mdata['bfType'] == 'bfCalendar' ||
								$mdata['bfType'] == 'bfSelect' ||
								$mdata['bfType'] == 'bfRadioGroup'
							)
						){
							if($mdata['bfType'] == 'bfSelect')
							{
								$mdata['list'] = $this->p->replaceCode($row->data2, "data2 of " . $mdata['bfName'], 'e', $mdata['dbId'], 0);
							} 
							else if($mdata['bfType'] == 'bfCheckboxGroup' || $mdata['bfType'] == 'bfRadioGroup')
							{
								$mdata['group'] = $this->p->replaceCode($row->data2, "data2 of " . $mdata['bfName'], 'e', $mdata['dbId'], 0);
							} 
							else
							{
								$mdata['value'] = $this->p->replaceCode($row->data1, "data1 of " . $mdata['bfName'], 'e', $mdata['dbId'], 0);	
							}
						}
						if(isset($mdata['checked']) && $mdata['bfType'] == 'bfCheckbox'){
							$mdata['checked'] = $row->flag1 == 1 ? true : false;
						}
						break;
					}
				}
                                
                                $flashUploader = '';
				
				switch($mdata['bfType']){
					
					case 'bfTextfield':
						$type = 'text';
						
						if($mdata['password']){
							$type = 'password';
						}
						$maxlength = '';
						if(is_numeric($mdata['maxLength'])){
							$maxlength = 'maxlength="'.intval($mdata['maxLength']).'" ';
						}
						
						echo '<input class="ff_elem" '.$tabIndex.$maxlength.$onclick.$onblur.$onchange.$onfocus.$onselect.$readonly.'type="'.$type.'" name="ff_nm_'.$mdata['bfName'].'[]" value="'.htmlentities(trim($mdata['value']), ENT_QUOTES, 'UTF-8').'" id="ff_elem'.$mdata['dbId'].'"/>'."\n";
						if($mdata['mailbackAsSender']){
							echo '<input type="hidden" name="mailbackSender['.$mdata['bfName'].']" value="true"/>'."\n";
						}
						break;
						
					case 'bfTextarea':
						
                                                $onkeyup = '';
						if(isset($mdata['maxlength']) && $mdata['maxlength'] > 0){
							$onkeyup = 'onkeyup="bfCheckMaxlength('.intval($mdata['dbId']).', '.intval($mdata['maxlength']).', '.(isset($mdata['showMaxlengthCounter']) && $mdata['showMaxlengthCounter'] ? 'true' : 'false').')" ';	
						}
						echo '<textarea cols="20" rows="5" class="ff_elem" '.$onkeyup.$tabIndex.$onclick.$onblur.$onchange.$onfocus.$onselect.$readonly.'name="ff_nm_'.$mdata['bfName'].'[]" id="ff_elem'.$mdata['dbId'].'">'.htmlentities(trim($mdata['value']), ENT_QUOTES, 'UTF-8').'</textarea>'."\n";
						break;
						
					case 'bfRadioGroup':
						
						if($mdata['group'] != ''){
                                                    
                                                        $mdata['group'] = str_replace("\r", '', $mdata['group']);
							$gEx = explode("\n", $mdata['group']);
							$lines = count($gEx);
                                                    
							$wrapOpen = '<div data-role="fieldcontain">'."\n".'<fieldset '.($lines <= 3 ? 'data-type="horizontal" ' : '').'data-role="controlgroup">'.$legend."\n";
							$wrapClose = '</fieldset>'."\n".'</div>'."\n";
							
							echo $wrapOpen;
							for($i = 0; $i < $lines; $i++){
								$idExt = $i != 0 ? '_'.$i : '';
								$iEx = explode(";", $gEx[$i]);
								$iCnt = count($iEx);
								if($iCnt == 3){
									$lblRight = '<label class="bfGroupLabel" id="bfGroupLabel'.$mdata['dbId'].$idExt.'" for="ff_elem'.$mdata['dbId'].$idExt.'">'.htmlentities(trim($iEx[1]), ENT_QUOTES, 'UTF-8').'</label>';
									echo '<input '.($iEx[0] == 1 ? 'checked="checked" ' : '').' class="ff_elem" '.$tabIndex.$onclick.$onblur.$onchange.$onfocus.$onselect.$readonly.'type="radio" name="ff_nm_'.$mdata['bfName'].'[]" value="'.htmlentities(trim($iEx[2]), ENT_QUOTES, 'UTF-8').'" id="ff_elem'.$mdata['dbId'].$idExt.'"/>'.$lblRight."\n";
								}
							}
							echo $wrapClose;
						}
						
						break;
						
					case 'bfCheckboxGroup':
						
						if($mdata['group'] != ''){
                                                    
                                                        $mdata['group'] = str_replace("\r", '', $mdata['group']);
							$gEx = explode("\n", $mdata['group']);
							$lines = count($gEx);
                                                    
                                                        $wrapOpen = '<div data-role="fieldcontain">'."\n".'<fieldset data-role="controlgroup">'.$legend."\n";
							$wrapClose = '</fieldset>'."\n".'</div>'."\n";
							
							echo $wrapOpen;
							for($i = 0; $i < $lines; $i++){
								$idExt = $i != 0 ? '_'.$i : '';
								$iEx = explode(";", $gEx[$i]);
								$iCnt = count($iEx);
								if($iCnt == 3){
									$lbl = '<label class="bfGroupLabel" id="bfGroupLabel'.$mdata['dbId'].$idExt.'" for="ff_elem'.$mdata['dbId'].$idExt.'">'.htmlentities(trim($iEx[1]), ENT_QUOTES, 'UTF-8').'</label>';
                                                                        echo '<input '.($iEx[0] == 1 ? 'checked="checked" ' : '').' class="ff_elem" '.$tabIndex.$onclick.$onblur.$onchange.$onfocus.$onselect.$readonly.'type="checkbox" name="ff_nm_'.$mdata['bfName'].'[]" value="'.htmlentities(trim($iEx[2]), ENT_QUOTES, 'UTF-8').'" id="ff_elem'.$mdata['dbId'].$idExt.'"/>'.$lbl."\n";
                                                                }
							}
							echo $wrapClose;
                                                         
                                                }
						
						break;
					
					case 'bfCheckbox':
						
                                                echo '<input class="ff_elem" '.($mdata['checked'] ? 'checked="checked" ' : '').$tabIndex.$onclick.$onblur.$onchange.$onfocus.$onselect.$readonly.'type="checkbox" name="ff_nm_'.$mdata['bfName'].'[]" value="'.htmlentities(trim($mdata['value']), ENT_QUOTES, 'UTF-8').'" id="ff_elem'.$mdata['dbId'].'"/>'."\n";
						if($mdata['mailbackAccept']){
							echo '<input type="hidden" class="ff_elem" name="mailbackConnectWith['.$mdata['mailbackConnectWith'].']" value="true_'.$mdata['bfName'].'"/>'."\n";
						}
						break;
						
					case 'bfSelect':
						
						if($mdata['list'] != ''){
							
							$mdata['list'] = str_replace("\r", '', $mdata['list']);
							$gEx = explode("\n", $mdata['list']);
							$lines = count($gEx);
                                                        // data-native-menu="false" 
							echo '<select class="ff_elem" '.($mdata['multiple'] ? 'multiple="multiple" data-native-menu="false" ' : '').$tabIndex.$onclick.$onblur.$onchange.$onfocus.$onselect.$readonly.'name="ff_nm_'.$mdata['bfName'].'[]" id="ff_elem'.$mdata['dbId'].'">'."\n";
							for($i = 0; $i < $lines; $i++){
								$iEx = explode(";", $gEx[$i]);
								$iCnt = count($iEx);
								if($iCnt == 3){
									echo '<option '.($iEx[0] == 1 ? 'selected="selected" ' : '').'value="'.htmlentities(trim($iEx[2]), ENT_QUOTES, 'UTF-8').'">'.htmlentities(trim($iEx[1]), ENT_QUOTES, 'UTF-8').'</option>'."\n";
								}
							}
							echo '</select>'."\n";
						}
						
						break;
						
					case 'bfFile':
                                                if( ( isset( $mdata['flashUploader'] ) && $mdata['flashUploader'] ) || ( isset( $mdata['html5'] ) && $mdata['html5'] ) ){
                                                        
                                                        $base = explode('/',JURI::base());
                                                        if(isset($base[count($base)-2]) && $base[count($base)-2] == 'administrator'){
                                                            unset($base[count($base)-2]);
                                                            $base = array_merge($base);
                                                        }
                                                        $base = implode('/', $base);
                                                    
                                                        echo '<input type="hidden" id="flashUpload'.$mdata['bfName'].'" name="flashUpload'.$mdata['bfName'].'" value="bfFlashFileQueue'.$mdata['dbId'].'"/>'."\n";
							$this->hasFlashUpload = true;
							//allowedFileExtensions
							$allowedExts = explode(',',$mdata['allowedFileExtensions']);
							$allowedExtsCnt = count($allowedExts);
							for($i = 0; $i < $allowedExtsCnt;$i++){
								$allowedExts[$i] = $allowedExts[$i];
							}
							$exts = '';
							if($allowedExtsCnt != 0){
								$exts = implode(',',$allowedExts);
							}
                                                        $bytes = (isset($mdata['flashUploaderBytes']) && is_numeric($mdata['flashUploaderBytes']) && $mdata['flashUploaderBytes'] > 0 ? "max_file_size : '" . intval($mdata['flashUploaderBytes']) ."'," : '');
							$flashUploader = "
                                                        <div id=\"bfUploadContainer".$mdata['dbId']."\">
							<img style=\"cursor: pointer;\" id=\"bfPickFiles".$mdata['dbId']."\" src=\"".$this->uploadImagePath."\" border=\"0\" width=\"".(isset($mdata['flashUploaderWidth']) && is_numeric($mdata['flashUploaderWidth']) && $mdata['flashUploaderWidth'] > 0 ? intval($mdata['flashUploaderWidth']) : '64')."\" height=\"".(isset($mdata['flashUploaderHeight']) && is_numeric($mdata['flashUploaderHeight']) && $mdata['flashUploaderHeight'] > 0 ? intval($mdata['flashUploaderHeight']) : '64')."\"/>
                                                        </div>
                                                        <span id=\"bfUploader".$mdata['bfName']."\"></span>
                                                        <div class=\"bfFlashFileQueueClass\" id=\"bfFlashFileQueue".$mdata['dbId']."\"></div>
                                                        <script type=\"text/javascript\">
                                                        <!--
							bfFlashUploaders.push('ff_elem".$mdata['dbId']."');
                                                        var bfFlashFileQueue".$mdata['dbId']." = {};
                                                        function bfUploadImageThumb(file) {
                                                                var img;
                                                                img = new o.Image;
                                                                img.onload = function() {
                                                                        img.embed(JQuery('#' + file.id+'thumb').get(0), { 
                                                                                width: 100, 
                                                                                height: 60, 
                                                                                crop: true,
                                                                                swf_url: mOxie.resolveUrl('".$base."components/com_breezingforms/libraries/jquery/plupload/Moxie.swf')
                                                                        });
                                                                };

                                                                img.onembedded = function() {
                                                                        img.destroy();
                                                                };

                                                                img.onerror = function() {
                                                                        
                                                                };
                                                                
                                                                img.load(file.getSource());
                                                                
                                                        }
                                                        JQuery(document).ready(
                                                            function() {
                                                                var iOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/i) ? true : false );
                                                                var uploader = new plupload.Uploader({
                                                                        multi_selection: ".( isset($mdata['flashUploaderMulti']) && $mdata['flashUploaderMulti'] ? 'true' : 'false' ).",
                                                                        unique_names: iOS,
                                                                        chunk_size: '100kb',
                                                                        runtimes : '".( isset( $mdata['html5'] ) && $mdata['html5'] ? 'html5,' : '' ).( isset( $mdata['flashUploader'] ) && $mdata['flashUploader'] ? 'flash,' : '')."html4',
                                                                        browse_button : 'bfPickFiles".$mdata['dbId']."',
                                                                        container: 'bfUploadContainer".$mdata['dbId']."',
                                                                        file_data_name: 'Filedata',
                                                                        multipart_params: { form: ".$this->p->form.", itemName : '".$mdata['bfName']."', bfFlashUploadTicket: '".$this->flashUploadTicket."', option: 'com_breezingforms', format: 'html', flashUpload: 'true', Itemid: 0 },
                                                                        ".$bytes."
                                                                        url : '".$base.(BFJoomlaConfig::get('config.sef') && !BFJoomlaConfig::get('config.sef_rewrite') ? 'index.php/' : '').(JRequest::getCmd('lang','') && BFJoomlaConfig::get('config.sef') ? JRequest::getCmd('lang','') . ( BFJoomlaConfig::get('config.sef_rewrite') ? 'index.php' : '' ) : 'index.php')."',
                                                                        flash_swf_url : '".$base."components/com_breezingforms/libraries/jquery/plupload/Moxie.swf',
                                                                        filters : [
                                                                                {title : '".addslashes(BFText::_('COM_BREEZINGFORMS_CHOOSE_FILE'))."', extensions : '".$exts."'}
                                                                        ]
                                                                });
                                                                uploader.bind('FilesAdded', function(up, files) {
                                                                        for (var i in files) {
                                                                                if(typeof files[i].id != 'undefined' && files[i].id != null){
                                                                                    var fsize = '';
                                                                                    if(typeof files[i].size != 'undefined'){
                                                                                        fsize = '(' + plupload.formatSize(files[i].size) + ') ';
                                                                                    }
                                                                                    JQuery('#bfFileQueue').append( '<div id=\"' + files[i].id + 'queue\">' + (iOS ? '' : files[i].name) + ' '+fsize+'<b></b></div>' );
                                                                                }
                                                                        }
                                                                        for (var i in files) {
                                                                            if(typeof files[i].id != 'undefined' && files[i].id != null){
                                                                                var error = false;
                                                                                var fsize = '';
                                                                                if(typeof files[i].size != 'undefined'){
                                                                                    fsize = '(' + plupload.formatSize(files[i].size) + ') ';
                                                                                }
                                                                                JQuery('#bfFlashFileQueue".$mdata['dbId']."').append('<div class=\"bfFileQueueItem\" id=\"' + files[i].id + 'queueitem\"><div id=\"' + files[i].id + 'thumb\"></div><div id=\"' + files[i].id + '\"><img id=\"' + files[i].id + 'cancel\" src=\"".$this->cancelImagePath."\" style=\"cursor: pointer; padding-right: 10px;\" border=\"0\"/>' + (iOS ? '' : files[i].name) + ' ' + fsize + '<b id=\"' + files[i].id + 'msg\" style=\"color:red;\"></b></div></div>');
                                                                                var file_ = files[i];
                                                                                var uploader_ = uploader;
                                                                                var bfUploaders_ = bfUploaders;
                                                                                JQuery('#' + files[i].id + 'cancel').click( 
                                                                                    function(){
                                                                                        for( var i = 0; i < bfUploaders_.length; i++ ){
                                                                                            bfUploaders_[i].stop();
                                                                                        }
                                                                                        var id_ = this.id.split('cancel');
                                                                                        id_ = id_[0];
                                                                                        uploader_.removeFileById(id_);
                                                                                        JQuery('#'+id_+'queue').remove();
                                                                                        JQuery('#'+id_+'queueitem').remove();
                                                                                        bfFlashUploadersLength--;
                                                                                        for( var i = 0; i < bfUploaders_.length; i++ ){
                                                                                            bfUploaders_[i].start();
                                                                                        }
                                                                                    } 
                                                                                );
                                                                                var thebytes = ".(isset($mdata['flashUploaderBytes']) && is_numeric($mdata['flashUploaderBytes']) && $mdata['flashUploaderBytes'] > 0 ? intval($mdata['flashUploaderBytes']) : '0').";
                                                                                if(thebytes > 0 && typeof files[i].size != 'undefined' && files[i].size > thebytes){
                                                                                     alert(' ".addslashes(BFText::_('COM_BREEZINGFORMS_FLASH_UPLOADER_TOO_LARGE'))."');
                                                                                     error = true;
                                                                                }
                                                                                var ext = files[i].name.split('.').pop().toLowerCase();
                                                                                var exts = '".strtolower($exts)."'.split(',');
                                                                                var found = 0;
                                                                                for (var x in exts){
                                                                                    if(exts[x] == ext){
                                                                                        found++;
                                                                                    }
                                                                                }
                                                                                if(found == 0){
                                                                                    alert( ' ".addslashes(BFText::_('COM_BREEZINGFORMS_FILE_EXTENSION_NOT_ALLOWED'))."' );
                                                                                    error = true;
                                                                                }
                                                                                if(error){
                                                                                    JQuery('#'+files[i].id+'queue').remove();
                                                                                    JQuery('#'+files[i].id+'queueitem').remove();
                                                                                }else{
                                                                                    bfFlashUploadersLength++;
                                                                                }
                                                                                bfUploadImageThumb(files[i]);
                                                                            }
                                                                        }
                                                                });
                                                                uploader.bind('UploadProgress', function(up, file) {
                                                                    if(typeof JQuery('#'+file.id+'queue').get(0) != 'undefined'){
                                                                        JQuery('#'+file.id+'queue').get(0).getElementsByTagName('b')[0].innerHTML = file.percent + '% <div style=\"height: 5px;width: ' + (file.percent*1.5) + 'px;background-color: #9de24f;\"></div>';
                                                                    }
                                                                });
                                                                uploader.bind('FileUploaded', function(up, file, response) {
                                                                    if(response.response!=''){
                                                                        if(response.response !== null){
                                                                            alert(response.response);
                                                                        }
                                                                    }
                                                                    JQuery('#'+file.id+'queue').remove();
                                                                });
                                                                uploader.init();
                                                                bfUploaders.push(uploader);
                                                            });
							//-->
                                                        </script>
							";
                                                        // on mobiles, file uploads are forced not to be mandatory, since we cannot determin safely for all handsets if they are even allowed
                                                        echo '<script type="text/javascript"><!--'."\n".'var bfIsValidMobile = ( navigator.userAgent.match(/(iPad|iPhone|iPod|Android)/i) ? true : false )'."\n".'if(!bfIsValidMobile){bfDeactivateField["ff_nm_'.$mdata['bfName'].'[]"]=true;}'."\n".'//--></script>'."\n";
                                                
                                                        echo '<input class="ff_elem" '.$tabIndex.$onclick.$onblur.$onchange.$onfocus.$onselect.$readonly.'type="hidden" name="ff_nm_'.$mdata['bfName'].'[]" id="ff_elem'.$mdata['dbId'].'"/>'."\n";
						}else{
                                                    echo '<input class="ff_elem" '.$tabIndex.$onclick.$onblur.$onchange.$onfocus.$onselect.$readonly.'type="file" name="ff_nm_'.$mdata['bfName'].'[]" id="ff_elem'.$mdata['dbId'].'"/>'."\n";
						}
						if($mdata['attachToAdminMail']){
							echo '<input type="hidden" name="attachToAdminMail['.$mdata['bfName'].']" value="true"/>'."\n";
						}
						if($mdata['attachToUserMail']){
							echo '<input type="hidden" name="attachToUserMail['.$mdata['bfName'].']" value="true"/>'."\n";
						}
						break;
                                                
                                                // on mobiles, file uploads are forced not to be mandatory, since we cannot determin safely for all handsets if they are even allowed
                                                echo '<script type="text/javascript"><!--'."\n".'bfDeactivateField["ff_nm_'.$mdata['bfName'].'[]"]=true;'."\n".'//--></script>'."\n";
                                                
						break;
						
					case 'bfSubmitButton':
						
						$value = '';
						$type = 'submit';
						$src = '';
                                                
						if($mdata['src'] != ''){
							$type = 'image';
							$src = 'src="'.$mdata['src'].'" ';
						}
						if($mdata['value'] != ''){
							$value = 'value="'.htmlentities(trim($mdata['value']), ENT_QUOTES, 'UTF-8').'" ';
						}
						if($mdata['actionClick'] == 1){
							$onclick = 'onclick="populateSummarizers();if(document.getElementById(\'bfPaymentMethod\')){document.getElementById(\'bfPaymentMethod\').value=\'\';};'.$mdata['actionFunctionName'] . '(this,\'click\');return false;" ';
						} else {
							$onclick = 'onclick="populateSummarizers();if(document.getElementById(\'bfPaymentMethod\')){document.getElementById(\'bfPaymentMethod\').value=\'\';};return false;" ';
						}
                                                if($src == ''){
                                                    echo '<button data-theme="e" class="ff_elem" '.$value.$src.$tabIndex.$onclick.$onblur.$onchange.$onfocus.$onselect.$readonly.'type="'.$type.'" name="ff_nm_'.$mdata['bfName'].'[]" id="ff_elem'.$mdata['dbId'].'"><span>'.$mdata['value'].'</span></button>'."\n";
                                                }else{
                                                    echo '<input class="ff_elem" '.$value.$src.$tabIndex.$onclick.$onblur.$onchange.$onfocus.$onselect.$readonly.'type="'.$type.'" name="ff_nm_'.$mdata['bfName'].'[]" id="ff_elem'.$mdata['dbId'].'" value="'.$mdata['value'].'"/>'."\n";
                                                }
						break;
						
					case 'bfHidden':
						
						echo '<input class="ff_elem" type="hidden" name="ff_nm_'.$mdata['bfName'].'[]" value="'.htmlentities(trim($mdata['value']), ENT_QUOTES, 'UTF-8').'" id="ff_elem'.$mdata['dbId'].'"/>'."\n";
						break;
						
					case 'bfSummarize':
						
                                                echo '<div class="ui-grid-a">
                                                            <div class="ui-block-a"><strong>'.$legend.'</strong></div>
                                                            <div class="ui-block-b ff_elem bfSummarize" id="ff_elem'.$mdata['dbId'].'"></div>
                                                    </div>';
                                            	echo '<script type="text/javascript"><!--'."\n".'bfRegisterSummarize("ff_elem'.$mdata['dbId'].'", "'.$mdata['connectWith'].'", "'.$mdata['connectType'].'", "'.addslashes($mdata['emptyMessage']).'", '.($mdata['hideIfEmpty'] ? 'true' : 'false').')'."\n".'//--></script>';
						if(trim($mdata['fieldCalc']) != ''){
							echo '<script type="text/javascript">
                                                        <!--
							function bfFieldCalcff_elem'.$mdata['dbId'].'(value){
								if(!isNaN(value)){
									value = Number(value);
								}
								'.$mdata['fieldCalc'].'
								return value;
							}
                                                        //-->
							</script>';
						}
						break;
                                        
                                        // recaptcha doesn't currently play well with jquery mobile
                                        case 'bfReCaptcha':
                                        case 'bfCaptcha':

                                                echo '<input autocomplete="off" class="ff_elem" type="text" name="bfCaptchaEntry" id="bfCaptchaEntry" />'."\n";
						echo '<button data-role="button" data-icon="refresh" data-inline="true" data-iconpos="notext" data-theme="e" id="bfCaptchaReload" onclick="document.getElementById(\'bfCaptchaEntry\').value=\'\';document.getElementById(\'bfCaptchaEntry\').focus();document.getElementById(\'ff_capimgValue\').src = \''.$captcha_url.'?bfMathRandom=\' + Math.random(); return false"><span>Reload Captcha</span></button>';
                                                
                                                break;
						
					case 'bfCalendar':
					
                                                JHTML::_( 'behavior.calendar' ); 
                                            
						$exploded = explode('::',trim($mdata['value']));
                                                
                                                $left = '';
                                                $right = '';
                                                if(count($exploded) == 2){
                                                    $left = trim($exploded[0]);
                                                    $right = trim($exploded[1]); 
                                                }else{
                                                    $right = trim($exploded[0]);
                                                }
                                                
                                                
						echo '<input autocomplete="off" class="ff_elem" type="text" name="ff_nm_'.$mdata['bfName'].'[]"  id="ff_elem'.$mdata['dbId'].'" value="'.htmlentities($left, ENT_QUOTES, 'UTF-8').'"/>'."\n";
                                                echo '<label for="ff_elem'.$mdata['dbId'].'_calendarButton"></label>';
                                                echo '<button data-theme="e" id="ff_elem'.$mdata['dbId'].'_calendarButton" type="submit" class="bfCalendar" value="'.htmlentities($right, ENT_QUOTES, 'UTF-8').'"><span>'.htmlentities($right, ENT_QUOTES, 'UTF-8').'</span></button>'."\n";
		
						
                                                echo '<script type="text/javascript">
                                                <!--
                                                JQuery(document).bind("pageinit", function() {
                                                Calendar.setup({
                                                        inputField     :    "ff_elem'.$mdata['dbId'].'",
                                                        ifFormat       :    "'.$mdata['format'].'",
                                                        button         :    "ff_elem'.$mdata['dbId'].'_calendarButton",
                                                        align          :    "Bl",
                                                        singleClick    :    true
                                                    });
                                                });
                                                //-->
                                                </script>'."\n";
                                                
						break;	
						
					case 'bfPayPal':
						
						$value = '';
						$type = 'submit';
						$src = '';
						if($mdata['image'] != ''){
							$type = 'image';
							$src = 'src="'.$mdata['image'].'" ';
						}else{
							$value = 'value="PayPal" ';
						}
						if($mdata['actionClick'] == 1){
							$onclick = 'onclick="document.getElementById(\'bfPaymentMethod\').value=\'PayPal\';'.$mdata['actionFunctionName'] . '(this,\'click\');" ';	
						} else {
							$onclick = 'onclick="document.getElementById(\'bfPaymentMethod\').value=\'PayPal\';" ';
						}
						echo '<div align="center"><input data-role="none" class="ff_elem" '.$value.$src.$tabIndex.$onclick.$onblur.$onchange.$onfocus.$onselect.$readonly.'type="'.$type.'" name="ff_nm_'.$mdata['bfName'].'[]" id="ff_elem'.$mdata['dbId'].'"/></div>'."\n";
						break;
						
					case 'bfSofortueberweisung':
						
						$value = '';
						$type = 'submit';
						$src = '';
						if($mdata['image'] != ''){
							$type = 'image';
							$src = 'src="'.$mdata['image'].'" ';
						}else{
							$value = 'value="Sofortueberweisung" ';
						}
						if($mdata['actionClick'] == 1){
							$onclick = 'onclick="document.getElementById(\'bfPaymentMethod\').value=\'Sofortueberweisung\';'.$mdata['actionFunctionName'] . '(this,\'click\');" ';	
						} else {
							$onclick = 'onclick="document.getElementById(\'bfPaymentMethod\').value=\'Sofortueberweisung\';" ';
						}
						echo '<div align="center"><input data-role="none" class="ff_elem" '.$value.$src.$tabIndex.$onclick.$onblur.$onchange.$onfocus.$onselect.$readonly.'type="'.$type.'" name="ff_nm_'.$mdata['bfName'].'[]" id="ff_elem'.$mdata['dbId'].'"/></div>'."\n";
						break;
				}
                                
                                if(trim($mdata['hint']) != ''){
                                    $labid = uniqid();
                                    echo '<div><button data-theme="e" onclick="JQuery(\'.tooltip\').hide(\'fast\');JQuery(\'#'.$labid.'_tip\').show(\'fast\');" data-role="button" data-icon="info" data-inline="true" data-iconpos="notext" id="'.$labid.'">'.trim($mdata['hint']).'</button><span id="'.$labid.'_tip" class="tooltip">'.trim($mdata['hint']).'</span></div>';
                                }
				
				if(isset($mdata['bfName']) && isset($mdata['off']) && $mdata['off']){
					echo '<script type="text/javascript"><!--'."\n".'bfDeactivateField["ff_nm_'.$mdata['bfName'].'[]"]=true;'."\n".'//--></script>'."\n";
				}
				
				if($mdata['bfType'] == 'bfFile'){
                                    echo '<span id="ff_elem'.$mdata['dbId'].'_files"></span>';
                                }
                                
                                echo $flashUploader;
                                
                                // if labels left 
                                if( true ) {
                                    echo '</div>';
                                }
                                
                                //echo '</div>';
			}
		}

		/**
		 * Paging and wrapping of inline element containers
		 */
		if(isset($dataObject['children']) && count($dataObject['children']) != 0){
			$childrenAmount = count($dataObject['children']);
			for($i = 0; $i < $childrenAmount; $i++){
				$this->process( $dataObject['children'][$i], $mdata, $parentPage, $i, $childrenAmount );
			}
		}	
		
		if(isset($dataObject['properties']) && $dataObject['properties']['type'] == 'section' && $dataObject['properties']['bfType'] == 'section'){
			
			echo '</div></div>'."\n";
			
		} else if(isset($dataObject['properties']) &&  $dataObject['properties']['type'] == 'section' && $dataObject['properties']['bfType'] == 'normal' ) {
			if(isset($dataObject['properties']['name']) && $dataObject['properties']['name'] != ''){
				echo '</div>'."\n";
			}
		}
		else if(isset($dataObject['properties']) && $dataObject['properties']['type'] == 'page'){

			$isLastPage = false;
			if($this->rootMdata['lastPageThankYou'] && $dataObject['properties']['pageNumber'] == count($this->dataObject['children']) && count($this->dataObject['children']) > 1){
				$isLastPage = true;
			}
			
			if(!$isLastPage){
			
				$last = 0;
				if($this->rootMdata['lastPageThankYou']){
					$last = 1;
				}
				
				if($this->rootMdata['pagingInclude'] && $dataObject['properties']['pageNumber'] > 1){
					echo '<button data-theme="e" class="bfPrevButton" type="submit" onclick="if(ff_currentpage > 1){ff_switchpage(ff_currentpage-1);self.scrollTo(0,0);}populateSummarizers();if(typeof bfRefreshAll != \'undefined\'){bfRefreshAll();}" value="'.htmlentities(trim($this->rootMdata['pagingPrevLabel']), ENT_QUOTES, 'UTF-8').'"><span>'.htmlentities(trim($this->rootMdata['pagingPrevLabel']), ENT_QUOTES, 'UTF-8').'</span></button>'."\n";
				}
	
				if($this->rootMdata['pagingInclude'] && $dataObject['properties']['pageNumber'] < count($this->dataObject['children']) - $last){
					echo '<button data-theme="e" class="bfNextButton" type="submit" onclick="ff_validate_nextpage(this, \'click\');populateSummarizers();if(typeof bfRefreshAll != \'undefined\'){bfRefreshAll();}" value="'.htmlentities(trim($this->rootMdata['pagingNextLabel']), ENT_QUOTES, 'UTF-8').'"><span>'.htmlentities(trim($this->rootMdata['pagingNextLabel']), ENT_QUOTES, 'UTF-8').'</span></button>'."\n";
				}
	
				if($this->rootMdata['cancelInclude'] && $dataObject['properties']['pageNumber'] + 1 > count($this->dataObject['children']) - $last){
					echo '<button data-theme="e" class="bfCancelButton" type="submit" onclick="ff_resetForm(this, \'click\');"  value="'.htmlentities(trim($this->rootMdata['cancelLabel']), ENT_QUOTES, 'UTF-8').'"><span>'.htmlentities(trim($this->rootMdata['cancelLabel']), ENT_QUOTES, 'UTF-8').'</span></button>'."\n";
				}
				
				$callSubmit = 'ff_validate_submit(this, \'click\')';
				if( $this->hasFlashUpload ){
					$callSubmit = 'if(typeof bfAjaxObject101 == \'undefined\' && typeof bfReCaptchaLoaded == \'undefined\'){bfDoFlashUpload()}else{ff_validate_submit(this, \'click\')}';
				}
				if($this->rootMdata['submitInclude'] && $dataObject['properties']['pageNumber'] + 1 > count($this->dataObject['children']) - $last){
					echo '<button data-theme="b" id="bfSubmitButton" class="bfSubmitButton" type="submit" onclick="if(document.getElementById(\'bfPaymentMethod\')){document.getElementById(\'bfPaymentMethod\').value=\'\';};'.$callSubmit.';" value="'.htmlentities(trim($this->rootMdata['submitLabel']), ENT_QUOTES, 'UTF-8').'"><span>'.htmlentities(trim($this->rootMdata['submitLabel']), ENT_QUOTES, 'UTF-8').'</span></button>'."\n";
				}
			
			}
		}
	}
	
        public function addStyleDeclaration($declaration){
            echo '<style type="text/css">'."\n".$declaration."\n".'</style>'."\n";
        }
        
        public function addScript($script){
            echo '<script type="text/javascript" src="'.$script.'"/>'."\n".'</script>'."\n";
        }
        
        public function addStyleSheet($sheet){
            echo '<link rel="stylesheet" href="'.$sheet.'" type="text/css" />'."\n";
        }
        
        public function addScriptDeclaration($declaration){
            echo '<script type="text/javascript"/><!--'."\n".$declaration."\n".'//--></script>'."\n";
        }
        
        public function headers(){
            
                // loading system css
		$this->addStyleSheet( JURI::root(true) . '/components/com_breezingforms/themes/quickmode/mobile-system.css' );
            
                $this->addScript(JURI::root(true) . '/components/com_breezingforms/libraries/jquery/jq.min.js');
                
                $this->addStyleSheet( JURI::root(true) . '/media/breezingforms/themes/jq.mobile.1.3.min.css' );
                $this->addScript(JURI::root(true) . '/components/com_breezingforms/libraries/jquery/jq.mobile.min.js');
                
                $this->addStyleSheet( JURI::root(true) . '/components/com_breezingforms/libraries/jquery/tooltip.css' );
                $this->addScript(JURI::root(true) . '/components/com_breezingforms/libraries/jquery/tooltip.js');

                if( $this->hasFlashUpload ){
			$tickets = JFactory::getSession()->get('bfFlashUploadTickets', array());
			$tickets[$this->flashUploadTicket] = array(); // stores file info for later processing
			JFactory::getSession()->set('bfFlashUploadTickets', $tickets);
			$this->addScript(JURI::root(true) . '/components/com_breezingforms/libraries/jquery/plupload/moxie.js');
                        $this->addScript(JURI::root(true) . '/components/com_breezingforms/libraries/jquery/plupload/plupload.js');
                        $this->addScript(JURI::root(true) . '/components/com_breezingforms/libraries/jquery/center.js');
			$this->addScriptDeclaration('
                        var bfUploaders = [];
                        var bfUploaderErrorElements = [];
			var bfFlashUploadInterval = null;
			var bfFlashUploaders = new Array();
                        var bfFlashUploadersLength = 0;
                        function bfRefreshAll(){
                            for( var i = 0; i < bfUploaders.length; i++ ){
                                bfUploaders[i].refresh();
                            }
                        }
                        function bfInitAll(){
                            for( var i = 0; i < bfUploaders.length; i++ ){
                                bfUploaders[i].init();
                            }
                        }
			function bfDoFlashUpload(){
                                JQuery("#bfSubmitMessage").css("visibility","hidden");
				JQuery(".bfErrorMessage").html("");
                                JQuery(".bfErrorMessage").css("display","none");
                                for(var i = 0; i < bfUploaderErrorElements.length; i++){
                                    JQuery("#"+bfUploaderErrorElements[i]).html("");
                                }
                                bfUploaderErrorElements = [];
                                if(ff_validation(0) == ""){
					try{
                                            bfFlashUploadInterval = window.setInterval( bfCheckFlashUploadProgress, 1000 );
                                            if(bfFlashUploadersLength > 0){
                                                JQuery("#bfFileQueue").bfcenter(true);
                                                JQuery("#bfFileQueue").css("visibility","visible");
                                                for( var i = 0; i < bfUploaders.length; i++ ){
                                                    bfUploaders[i].start();
                                                }
                                            }
					} catch(e){alert(e)}
				} else {
					if(typeof bfUseErrorAlerts == "undefined"){
                                            alert(error);
                                        } else {
                                            bfShowErrors(error);
                                        }
                                        ff_validationFocus("");
				}
			}
			function bfCheckFlashUploadProgress(){
				if( JQuery("#bfFileQueue").html() == "" ){ // empty indicates that all queues are uploaded or in any way cancelled
					JQuery("#bfFileQueue").css("visibility","hidden");
					window.clearInterval( bfFlashUploadInterval );
                                        if(typeof bfAjaxObject101 != \'undefined\' || typeof bfReCaptchaLoaded != \'undefined\'){
                                            ff_submitForm2();
                                        }else{
                                            ff_validate_submit(document.getElementById("bfSubmitButton"), "click");
                                        }
					JQuery(".bfFlashFileQueueClass").html("");
                                        if(bfFlashUploadersLength > 0){
                                            JQuery("#bfSubmitMessage").bfcenter(true);
                                            JQuery("#bfSubmitMessage").css("visibility","visible");
                                        }
                                        
				}
			}
			');
		}
                
                if($this->useBalloonErrors){
                    $this->addStyleSheet( JURI::root(true) . '/components/com_breezingforms/libraries/jquery/validationEngine.jquery.css' );
                    $this->addScript(JURI::root(true) . '/components/com_breezingforms/libraries/jquery/jquery.validationEngine-en.js');
                    $this->addScript(JURI::root(true) . '/components/com_breezingforms/libraries/jquery/jquery.validationEngine.js');
                }

                $this->addStyleDeclaration('.tooltip { margin-left: 2%; margin-top: 5px; }');
                
		$toggleCode = '';
		if($this->toggleFields != '[]'){
			$toggleCode = '
			var toggleFieldsArray = '.$this->toggleFields.';
			String.prototype.beginsWith = function(t, i) { if (i==false) { return
			(t == this.substring(0, t.length)); } else { return (t.toLowerCase()
			== this.substring(0, t.length).toLowerCase()); } } 
			function bfDeactivateSectionFields(){
				for( var i = 0; i < bfDeactivateSection.length; i++ ){
                                        bfSetFieldValue(bfDeactivateSection[i], "off");
					JQuery("#"+bfDeactivateSection[i]+" .ff_elem").each(function(i){
                                            if( JQuery(this).get(0).name && JQuery(this).get(0).name.beginsWith("ff_nm_", true) ){
                                                bfDeactivateField[JQuery(this).get(0).name] = true;
                                            }
					});
				}
                                for( var i = 0; i < toggleFieldsArray.length; i++ ){
                                    if(toggleFieldsArray[i].state == "turn"){
                                        bfSetFieldValue(toggleFieldsArray[i].tName, "off");
                                    }
                                }
			}
			function bfToggleFields(state, tCat, tName, thisBfDeactivateField){
                                // maybe a little to harsh, but currently no other workaround
				// file uploads will be removed for the complete form if a rule is executed
				// make sure you offer file uploads at the end of your form if you have visibility rules!
				if(state == "on"){
					if(tCat == "element"){
                                                if( typeof JQuery("#fieldcontain"+tName) != "undefined" && JQuery("#fieldcontain"+tName).attr("class").substr(0, 10) == "bfElemWrap" ){
                                                    JQuery("#fieldcontain"+tName).css("display", "");
                                                }
						thisBfDeactivateField["ff_nm_"+tName+"[]"] = false;
                                                bfSetFieldValue(tName, "on");
					} else {
						JQuery("#"+tName).css("display", "");
                                                bfSetFieldValue(tName, "on");
						JQuery("#"+tName).find(".ff_elem").each(function(i){
                                                    if( JQuery(this).get(0).name && JQuery(this).get(0).name.beginsWith("ff_nm_", true) ){
                                                        thisBfDeactivateField[JQuery(this).get(0).name] = false;
                                                    }
						});
					}
				} else {
					if(tCat == "element"){
                                                if( typeof JQuery("#fieldcontain"+tName) != "undefined" && JQuery("#fieldcontain"+tName).attr("class").substr(0, 10) == "bfElemWrap" ){
                                                    JQuery("#fieldcontain"+tName).css("display", "none");
                                                }
						thisBfDeactivateField["ff_nm_"+tName+"[]"] = true;
                                                bfSetFieldValue(tName, "off");
					} else {
						JQuery("#"+tName).css("display", "none");
                                                bfSetFieldValue(tName, "off");
						JQuery("#"+tName+" .ff_elem").each(function(i){
                                                    if( JQuery(this).get(0).name && JQuery(this).get(0).name.beginsWith("ff_nm_", true) ){
                                                        thisBfDeactivateField[JQuery(this).get(0).name] = true;
                                                    }
						});
					}
				}
			}
                        function bfSetFieldValue(name, condition){
                            for( var i = 0; i < toggleFieldsArray.length; i++ ){
                                if( toggleFieldsArray[i].action == "if" ) {
                                    //alert(toggleFieldsArray[i].condition);
                                    if(name == toggleFieldsArray[i].tCat && condition == toggleFieldsArray[i].statement){
                                    
                                        var element = JQuery("[name=\"ff_nm_"+toggleFieldsArray[i].condition+"[]\"]");
                                        
                                        switch(element.get(0).type){
                                            case "text":
                                            case "textarea":
                                                if(toggleFieldsArray[i].value == "!empty"){
                                                    element.val("");
                                                } else {
                                                    element.val(toggleFieldsArray[i].value);
                                                }
                                            break;
                                            case "select-multiple":
                                            case "select-one":
                                                if(toggleFieldsArray[i].value == "!empty"){
                                                    for(var j = 0; j < element.get(0).options.length; j++){
                                                        element.get(0).options[j].selected = false;
                                                    }
                                                }
                                                for(var j = 0; j < element.get(0).options.length; j++){
                                                    if(element.get(0).options[j].value == toggleFieldsArray[i].value){
                                                        element.get(0).options[j].selected = true;
                                                    }
                                                }
                                            break;
                                            case "radio":
                                            case "checkbox":
                                                var radioLength = element.size();
                                                if(toggleFieldsArray[i].value == "!empty"){
                                                    for(var j = 0; j < radioLength; j++){
                                                        element.get(j).checked = false;
                                                    }
                                                }
						for(var j = 0; j < radioLength; j++){
                                                    if( element.get(j).value == toggleFieldsArray[i].value ){
                                                        element.get(j).checked = true;
                                                    }
                                                }
                                            break;
                                        }
                                    }
                                }
                            }
                        }
			function bfRegisterToggleFields(){
                        
                                var offset = 0;
                                var last_offset = 0;
                                var limit  = 10;
                                var limit_cnt = 0;
                                
                                if( arguments.length == 1 ){
                                    offset = arguments[0];
                                }

                                var thisToggleFieldsArray = toggleFieldsArray;
				var thisBfDeactivateField = bfDeactivateField;
                                var thisBfToggleFields = bfToggleFields;
                                
				for( var i = offset; limit_cnt < limit && i < toggleFieldsArray.length; i++ ){
                                //  for( var i = 0; i < toggleFieldsArray.length; i++ ){
                                              if( toggleFieldsArray[i].action == "turn" && (toggleFieldsArray[i].tCat == "element" || toggleFieldsArray[i].tCat == "section") ){
						var toggleField = toggleFieldsArray[i];
						var element = JQuery("[name=\"ff_nm_"+toggleFieldsArray[i].sName+"[]\"]");
						if(element.get(0)){
							switch(element.get(0).type){
								case "text":
								case "textarea":
                                                                        JQuery("[name=\"ff_nm_"+toggleField.sName+"[]\"]").unbind("blur");
									JQuery("[name=\"ff_nm_"+toggleField.sName+"[]\"]").blur(
										function(){
											for( var k = 0; k < thisToggleFieldsArray.length; k++ ){
												var regExp = "";
												if(thisToggleFieldsArray[k].value.beginsWith("!", true) && JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]"){
										 			regExp = thisToggleFieldsArray[k].value.substring(1, thisToggleFieldsArray[k].value.length);
										 		}

                                                                                                if(thisToggleFieldsArray[k].condition == "isnot"){
                                                                                                    if(
                                                                                                            ( ( regExp != "" && JQuery(this).val().test(regExp) <= 0 ) || JQuery(this).val() != thisToggleFieldsArray[k].value ) && JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]"
                                                                                                    ){
                                                                                                            var names = thisToggleFieldsArray[k].tName.split(",");
                                                                                                            for(var n = 0; n < names.length; n++){
                                                                                                                thisBfToggleFields(thisToggleFieldsArray[k].state, thisToggleFieldsArray[k].tCat, JQuery.trim(names[n]), thisBfDeactivateField);
                                                                                                            }
                                                                                                            //break;
                                                                                                    }
                                                                                                } else if(thisToggleFieldsArray[k].condition == "is"){
                                                                                                    if(
                                                                                                            ( ( regExp != "" && JQuery(this).val().test(regExp) > 0 ) || JQuery(this).val() == thisToggleFieldsArray[k].value ) && JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]"
                                                                                                    ){
                                                                                                            var names = thisToggleFieldsArray[k].tName.split(",");
                                                                                                            for(var n = 0; n < names.length; n++){
                                                                                                                thisBfToggleFields(thisToggleFieldsArray[k].state, thisToggleFieldsArray[k].tCat, JQuery.trim(names[n]), thisBfDeactivateField);
                                                                                                            }
                                                                                                            //break;
                                                                                                    }
                                                                                                }
											}
										}
									);
									break;
								case "select-multiple":
								case "select-one":
                                                                        JQuery("[name=\"ff_nm_"+toggleField.sName+"[]\"]").unbind("change");
									JQuery("[name=\"ff_nm_"+toggleField.sName+"[]\"]").change(
										function(){
											var res = JQuery.isArray( JQuery(this).val() ) == false ? [ JQuery(this).val() ] : JQuery(this).val();
											for( var k = 0; k < thisToggleFieldsArray.length; k++ ){
												
												// The or-case in lists 
												var found = false;
												var chkGrpValues = new Array();
										 		if(thisToggleFieldsArray[k].value.beginsWith("#", true) && JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]"){
										 			chkGrpValues = thisToggleFieldsArray[k].value.substring(1, thisToggleFieldsArray[k].value.length).split("|");
										 			for(var l = 0; l < chkGrpValues.length; l++){
										 				if( JQuery.inArray(chkGrpValues[l], res) != -1 ){
										 					found = true;
										 					break;
										 				}
										 			}
										 		}
												// the and-case in lists
												var foundCount = 0;
												chkGrpValues2 = new Array();
										 		if(thisToggleFieldsArray[k].value.beginsWith("#", true) && JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]"){
										 			chkGrpValues2 = thisToggleFieldsArray[k].value.substring(1, thisToggleFieldsArray[k].value.length).split(";");
										 			for(var l = 0; l < res.length; l++){
										 				if( JQuery.inArray(res[l], chkGrpValues2) != -1 ){
										 					foundCount++;
										 				}
										 			}
										 		}
                                                                                                
                                                                                                if(thisToggleFieldsArray[k].condition == "isnot"){
                                                                                                
                                                                                                    if(
                                                                                                            (
                                                                                                                    !JQuery.isArray(res) && JQuery(this).val() != thisToggleFieldsArray[k].value && JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]"
                                                                                                            )
                                                                                                            ||
                                                                                                            (
                                                                                                                    JQuery.isArray(res) && ( JQuery.inArray(thisToggleFieldsArray[k].value, res) == -1 || !found || ( foundCount == 0 || foundCount != chkGrpValues2.length ) ) && JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]"
                                                                                                            )
                                                                                                     ){
                                                                                                            var names = thisToggleFieldsArray[k].tName.split(",");
                                                                                                            for(var n = 0; n < names.length; n++){
                                                                                                                thisBfToggleFields(thisToggleFieldsArray[k].state, thisToggleFieldsArray[k].tCat, JQuery.trim(names[n]), thisBfDeactivateField);
                                                                                                            }
                                                                                                            //break;
                                                                                                    }
                                                                                                } else if(thisToggleFieldsArray[k].condition == "is"){
                                                                                                    if(
                                                                                                            (
                                                                                                                    !JQuery.isArray(res) && JQuery(this).val() == thisToggleFieldsArray[k].value && JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]"
                                                                                                            )
                                                                                                            ||
                                                                                                            (
                                                                                                                    JQuery.isArray(res) && ( JQuery.inArray(thisToggleFieldsArray[k].value, res) != -1 || found || ( foundCount != 0 && foundCount == chkGrpValues2.length ) ) && JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]"
                                                                                                            )
                                                                                                     ){
                                                                                                            var names = thisToggleFieldsArray[k].tName.split(",");
                                                                                                            for(var n = 0; n < names.length; n++){
                                                                                                                thisBfToggleFields(thisToggleFieldsArray[k].state, thisToggleFieldsArray[k].tCat, JQuery.trim(names[n]), thisBfDeactivateField);
                                                                                                            }
                                                                                                            //break;
                                                                                                    }
                                                                                                }
											}
										}
									);
									break;
								case "radio":
								case "checkbox":
									var radioLength = JQuery("[name=\"ff_nm_"+toggleField.sName+"[]\"]").size();
									for(var j = 0; j < radioLength; j++){
                                                                                 JQuery("#" + JQuery("[name=\"ff_nm_"+toggleField.sName+"[]\"]").get(j).id ).unbind("click");
										 JQuery("#" + JQuery("[name=\"ff_nm_"+toggleField.sName+"[]\"]").get(j).id ).click(										 	
										 	function(){
										 		// NOT O(n^2) since its ony executed on click event!
										 		for( var k = 0; k < thisToggleFieldsArray.length; k++ ){
										 			
										 			// used for complex checkbox group case below
										 			var chkGrpValues = new Array();
										 			if(JQuery(this).get(0).checked && thisToggleFieldsArray[k].value.beginsWith("#", true) && JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]"){
										 				chkGrpValues = thisToggleFieldsArray[k].value.substring(1, thisToggleFieldsArray[k].value.length).split("|");
										 			}

                                                                                                        if(thisToggleFieldsArray[k].condition == "isnot"){

                                                                                                            if(
                                                                                                                    // simple radio case for selected value
                                                                                                                    ( JQuery(this).get(0).type == "radio" && JQuery(this).get(0).checked && JQuery(this).val() != thisToggleFieldsArray[k].value && JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]" )
                                                                                                                    ||
                                                                                                                    // single checkbox case for checked/unchecked
                                                                                                                    (
                                                                                                                            JQuery(this).get(0).type == "checkbox" &&
                                                                                                                            JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]" &&
                                                                                                                            ( JQuery(this).get(0).checked && thisToggleFieldsArray[k].value != "!checked"
                                                                                                                             ||
                                                                                                                              JQuery(this).get(0).checked && thisToggleFieldsArray[k].value == "!unchecked"
                                                                                                                            )
                                                                                                                    )
                                                                                                                    ||
                                                                                                                    // complex checkbox/radio group case by multiple values
                                                                                                                    (
                                                                                                                            JQuery(this).get(0).checked && JQuery.inArray(JQuery(this).val(), chkGrpValues) == -1 && JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]"
                                                                                                                    )
                                                                                                                    ||
                                                                                                                    // simple checkbox group case by single value
                                                                                                                    (
                                                                                                                            JQuery(this).get(0).type == "checkbox" && JQuery(this).get(0).checked && JQuery(this).val() != thisToggleFieldsArray[k].value && JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]"
                                                                                                                    )
                                                                                                            ){
                                                                                                                    var names = thisToggleFieldsArray[k].tName.split(",");
                                                                                                                    for(var n = 0; n < names.length; n++){
                                                                                                                        thisBfToggleFields(thisToggleFieldsArray[k].state, thisToggleFieldsArray[k].tCat, JQuery.trim(names[n]), thisBfDeactivateField);
                                                                                                                    }
                                                                                                                    //break;
                                                                                                            }
                                                                                                        }
                                                                                                        else
                                                                                                        if(thisToggleFieldsArray[k].condition == "is"){
                                                                                                            if(
                                                                                                                    // simple radio case for selected value
                                                                                                                    ( JQuery(this).get(0).type == "radio" && JQuery(this).get(0).checked && JQuery(this).val() == thisToggleFieldsArray[k].value && JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]" )
                                                                                                                    ||
                                                                                                                    // single checkbox case for checked/unchecked
                                                                                                                    (
                                                                                                                            JQuery(this).get(0).type == "checkbox" &&
                                                                                                                            JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]" &&
                                                                                                                            ( JQuery(this).get(0).checked && thisToggleFieldsArray[k].value == "!checked"
                                                                                                                             ||
                                                                                                                              !JQuery(this).get(0).checked && thisToggleFieldsArray[k].value == "!unchecked"
                                                                                                                            )
                                                                                                                    )
                                                                                                                    ||
                                                                                                                    // complex checkbox/radio group case by multiple values
                                                                                                                    (
                                                                                                                            JQuery(this).get(0).checked && JQuery.inArray(JQuery(this).val(), chkGrpValues) != -1 && JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]"
                                                                                                                    )
                                                                                                                    ||
                                                                                                                    // simple checkbox group case by single value
                                                                                                                    (
                                                                                                                            JQuery(this).get(0).type == "checkbox" && JQuery(this).get(0).checked && JQuery(this).val() == thisToggleFieldsArray[k].value && JQuery(this).get(0).name == "ff_nm_"+thisToggleFieldsArray[k].sName+"[]"
                                                                                                                    )
                                                                                                            ){
                                                                                                                    var names = thisToggleFieldsArray[k].tName.split(",");
                                                                                                                    for(var n = 0; n < names.length; n++){
                                                                                                                        thisBfToggleFields(thisToggleFieldsArray[k].state, thisToggleFieldsArray[k].tCat, JQuery.trim(names[n]), thisBfDeactivateField);
                                                                                                                    }
                                                                                                                    //break;
                                                                                                            }
                                                                                                        }
												}
												
											}
										 );
									}
									break;
							}
						}
					}
                                        
                                        limit_cnt++;
                                        last_offset = i;
                                }
                                
                                if( last_offset+1 < toggleFieldsArray.length ){ setTimeout("bfRegisterToggleFields( "+last_offset+" )", 350); }
                        }';
			
		}
		
		$this->addScriptDeclaration(
                        '
			var inlineErrorElements = new Array();
			var bfSummarizers = new Array();
			var bfDeactivateField = new Array();
			var bfDeactivateSection = new Array();
			'.$toggleCode.'
			function bfCheckMaxlength(id, maxlength, showMaxlength){
				if( JQuery("#ff_elem"+id).val().length > maxlength ){
					JQuery("#ff_elem"+id).val( JQuery("#ff_elem"+id).val().substring(0, maxlength) );
				}
				if(showMaxlength){
					JQuery("#bfMaxLengthCounter"+id).text( "(" + (maxlength - JQuery("#ff_elem"+id).val().length) + " '.BFText::_('COM_BREEZINGFORMS_CHARS_LEFT').')" );
				}
			}
			function bfRegisterSummarize(id, connectWith, type, emptyMessage, hideIfEmpty){
				bfSummarizers.push( { id : id, connectWith : connectWith, type : type, emptyMessage : emptyMessage, hideIfEmpty : hideIfEmpty } );
			}
			function bfField(name){
				var value = "";
				switch(ff_getElementByName(name).type){
					case "radio":
						if(JQuery("[name="+ff_getElementByName(name).name+"]:checked").val() != "" && typeof JQuery("[name="+ff_getElementByName(name).name+"]:checked").val() != "undefined"){
							value = JQuery("[name="+ff_getElementByName(name).name+"]:checked").val();
							if(!isNaN(value)){
								value = Number(value);
							}
						}
						break;
					case "checkbox":
					case "select-one":
					case "select-multiple":
						var nodeList = document["'.$this->p->form_id.'"][""+ff_getElementByName(name).name+""];
						if(ff_getElementByName(name).type == "checkbox" && typeof nodeList.length == "undefined"){
							if(typeof JQuery("[name="+ff_getElementByName(name).name+"]:checked").val() != "undefined"){
								value = JQuery("[name="+ff_getElementByName(name).name+"]:checked").val();
								if(!isNaN(value)){
									value = Number(value);
								}
							}
						} else {
							var val = "";
							for(var j = 0; j < nodeList.length; j++){
								if(nodeList[j].checked || nodeList[j].selected){
									val += nodeList[j].value + ", ";
								}
							}
							if(val != ""){
								value = val.substr(0, val.length - 2);
								if(!isNaN(value)){
									value = Number(value);
								}
							}
						}
						break;
					default:
						if(!isNaN(ff_getElementByName(name).value)){
							value = Number(ff_getElementByName(name).value);
						} else {
							value = ff_getElementByName(name).value;
						}
				}
				return value;
			}
			function populateSummarizers(){
				// cleaning first
                                
				for(var i = 0; i < bfSummarizers.length; i++){
					JQuery("#"+bfSummarizers[i].id).parent().css("display", "");
					JQuery("#"+bfSummarizers[i].id).html("<span class=\"bfNotAvailable\">"+bfSummarizers[i].emptyMessage+"</span>");
				}
				for(var i = 0; i < bfSummarizers.length; i++){
					var summVal = "";
					switch(bfSummarizers[i].type){
						case "bfTextfield":
						case "bfTextarea":
						case "bfHidden":
						case "bfCalendar":
						case "bfFile":
							if(JQuery("[name=\"ff_nm_"+bfSummarizers[i].connectWith+"[]\"]").val() != ""){
								JQuery("#"+bfSummarizers[i].id).text( JQuery("[name=\"ff_nm_"+bfSummarizers[i].connectWith+"[]\"]").val() ).html();
								var breakableText = JQuery("#"+bfSummarizers[i].id).html().replace(/\\r/g, "").replace(/\\n/g, "<br/>");
								
								if(breakableText != ""){
									var calc = null;
									eval( "calc = typeof bfFieldCalc"+bfSummarizers[i].id+" != \"undefined\" ? bfFieldCalc"+bfSummarizers[i].id+" : null" );
									if(calc){
										breakableText = calc(breakableText);
									}
								}
								
								JQuery("#"+bfSummarizers[i].id).html(breakableText);
								summVal = breakableText;
							}
						break;
						case "bfRadioGroup":
						case "bfCheckbox":
							if(JQuery("[name=\"ff_nm_"+bfSummarizers[i].connectWith+"[]\"]:checked").val() != "" && typeof JQuery("[name=\"ff_nm_"+bfSummarizers[i].connectWith+"[]\"]:checked").val() != "undefined"){
								var theText = JQuery("[name=\"ff_nm_"+bfSummarizers[i].connectWith+"[]\"]:checked").val();
								if(theText != ""){
									var calc = null;
									eval( "calc = typeof bfFieldCalc"+bfSummarizers[i].id+" != \"undefined\" ? bfFieldCalc"+bfSummarizers[i].id+" : null" );
									if(calc){
										theText = calc(theText);
									}
								}
								JQuery("#"+bfSummarizers[i].id).text( theText );
								summVal = theText;
							}
						break;
						case "bfCheckboxGroup":
						case "bfSelect":
							var val = "";
							var nodeList = document["'.$this->p->form_id.'"]["ff_nm_"+bfSummarizers[i].connectWith+"[]"];
							
							for(var j = 0; j < nodeList.length; j++){
								if(nodeList[j].checked || nodeList[j].selected){
									val += nodeList[j].value + ", ";
								}
							}
							if(val != ""){
								var theText = val.substr(0, val.length - 2);
								if(theText != ""){
									var calc = null;
									eval( "calc = typeof bfFieldCalc"+bfSummarizers[i].id+" != \"undefined\" ? bfFieldCalc"+bfSummarizers[i].id+" : null" );
									if(calc){
										theText = calc(theText);
									}
								}
								JQuery("#"+bfSummarizers[i].id).text( theText );
								summVal = theText;
							}
						break;
					}
					
					if( ( bfSummarizers[i].hideIfEmpty && summVal == "" ) || ( typeof bfDeactivateField != "undefined" && bfDeactivateField["ff_nm_"+bfSummarizers[i].connectWith+"[]"] ) ){
                                            JQuery("#"+bfSummarizers[i].id).parent().css("display", "none");
					}
				}
			}
                ');
		
		if(!$this->useErrorAlerts || $this->rollover){
			if(!$this->useErrorAlerts){
                                $defaultErrors = '';
                                if($this->useDefaultErrors || (!$this->useDefaultErrors && !$this->useBalloonErrors)){
                                    $defaultErrors = 'JQuery(".bfErrorMessage").html("");
					JQuery(".bfErrorMessage").css("display","none");
					JQuery(".bfErrorMessage").fadeIn(1500);
					var allErrors = "";
					var errors = error.split("\n");
					for(var i = 0; i < errors.length; i++){
						allErrors += "<div class=\"bfError\">" + errors[i] + "</div>";
					}
					JQuery(".bfErrorMessage").html(allErrors);
					JQuery(".bfErrorMessage").css("display","");';
                                }
				$this->addScriptDeclaration('var bfUseErrorAlerts = false;'."\n");
				$this->addScriptDeclaration('
				function bfShowErrors(error){
                                        '.$defaultErrors.'

                                        if(JQuery.bfvalidationEngine)
                                        {
                                            JQuery("#'.$this->p->form_id.'").bfvalidationEngine({
                                              promptPosition: "bottomLeft",
                                              success :  false,
                                              failure : function() {}
                                            });

                                            for(var i = 0; i < inlineErrorElements.length; i++)
                                            {
                                                if(inlineErrorElements[i][1] != "")
                                                {
                                                    var prompt = null;
                                                    
                                                    if(inlineErrorElements[i][0] == "bfCaptchaEntry" || inlineErrorElements[i][0] == "bfReCaptchaEntry"){
                                                        prompt = JQuery.bfvalidationEngine.buildPrompt("#bfCaptchaEntry",inlineErrorElements[i][1],"error");
                                                    }
                                                    else if(typeof JQuery("#bfUploader"+inlineErrorElements[i][0]).get(0) != "undefined")
                                                    {
                                                        alert(inlineErrorElements[i][1]);
                                                        //prompt = JQuery.bfvalidationEngine.buildPrompt("#"+JQuery("#bfUploader"+inlineErrorElements[i][0]).val(),inlineErrorElements[i][1],"error");
                                                    }
                                                    else
                                                    {
                                                        prompt = JQuery.bfvalidationEngine.buildPrompt("#"+ff_getElementByName(inlineErrorElements[i][0]).id,inlineErrorElements[i][1],"error");
                                                    }
                                                    
                                                    JQuery(prompt).mouseover(
                                                        function(){
                                                            var inlineError = JQuery(this).attr("class").split(" ");
                                                            if(inlineError && inlineError.length && inlineError.length == 2){
                                                                var result = inlineError[1].split("formError");
                                                                if(result && result.length && result.length >= 1){
                                                                    JQuery.bfvalidationEngine.closePrompt("#"+result[0]);
                                                                }
                                                            }
                                                        }
                                                    );
                                                }
                                                else
                                                {
                                                    if(typeof JQuery("#bfUploader"+inlineErrorElements[i][0]).get(0) != "undefined")
                                                    {
                                                        //JQuery.bfvalidationEngine.closePrompt("#"+JQuery("#bfUploader"+inlineErrorElements[i][0]).val());
                                                    }
                                                    else
                                                    {
                                                        if(ff_getElementByName(inlineErrorElements[i][0])){
                                                            JQuery.bfvalidationEngine.closePrompt("#"+ff_getElementByName(inlineErrorElements[i][0]).id);
                                                        }
                                                    }
                                                }
                                            }
                                            inlineErrorElements = new Array();
                                        }
				}');
			}
		}
		$this->addScriptDeclaration('
			JQuery(document).bind("pageinit", function() {
				if(typeof bfSetElemWrapBg != "undefined")bfSetElemWrapBg();
				if(typeof bfRegisterToggleFields != "undefined")bfRegisterToggleFields();
				if(typeof bfDeactivateSectionFields != "undefined")bfDeactivateSectionFields();
                                if(JQuery.bfvalidationEngine)
                                {
                                    JQuery.bfvalidationEngineLanguage.newLang();
                                    JQuery(".ff_elem").change(
                                        function(){
                                            JQuery.bfvalidationEngine.closePrompt(this);
                                        }
                                    );
                                }
				JQuery(".hasTip").css("color","inherit"); // fixing label text color issue
				JQuery(".bfTooltip").css("color","inherit"); // fixing label text color issue
    
                                JQuery("input[type=text]").bind("keypress", function(evt) {
                                    if(evt.keyCode == 13) {
                                        evt.preventDefault();
                                    }
                                });
                                JQuery(".tooltip").hide();
                                setInterval(
                                    function(){
                                        JQuery("input[type=\'checkbox\']").checkboxradio("refresh");
                                        JQuery("input[type=\'radio\']").checkboxradio("refresh");
                                        JQuery("input[type=\'text\']").textinput();
                                        JQuery("select").selectmenu("refresh");
                                        JQuery("textarea").textinput();
                                    }
                                    ,
                                    500
                                );
			});
                      
                        JQuery(document).bind("mobileinit", function(){
                            JQuery.mobile.loadingMessage = false;
                            JQuery.mobile.ignoreContentEnabled = false;
                            JQuery.mobile.selectmenu.prototype.options.nativeMenu = false;
                        });
		');
                
        }
        
	public function render(){

                echo '<div data-role="page">';
                
                //  data-position="fixed"
                echo '<div data-role="header">';
                echo '<h1>'.JFactory::getDocument()->getTitle().'</h1>';
                $return_url = JURI::getInstance()->toString();
                $return_url = (strstr($return_url,'?mobile=1') !== false ? str_replace('?mobile=1','',$return_url) : str_replace('&mobile=1','',$return_url));
                $return_url = $return_url.(strstr($return_url,'?') !== false ? '&' : '?') . 'non_mobile=1';
                echo '<a rel="external" href="'.($this->forceMobileUrl != '' ? $this->forceMobileUrl : $return_url).'" data-role="button" data-icon="back">'.BFText::_('COM_BREEZINGFORMS_DESKTOP').'</a>';
                echo '</div>';
                
                echo '<div data-role="content">';
            
                $this->process($this->dataObject);
		echo '</div>'."\n"; // closing last page
                
                if($this->hasFlashUpload){
                    echo '<input type="hidden" name="bfFlashUploadTicket" value="'.$this->flashUploadTicket.'"/>'."\n";
                    echo "<div style=\"visibility:hidden;\" id=\"bfFileQueue\"></div>";
                    echo "<div style=\"visibility:hidden;\" id=\"bfSubmitMessage\">".BFText::_('COM_BREEZINGFORMS_SUBMIT_MESSAGE')."</div>";
                }
                
                echo '<script type="text/javascript"><!--'."\n".'if(document.getElementById("bfPage'.$this->p->page.'"))document.getElementById("bfPage'.$this->p->page.'").style.display = "";'."\n".'//--></script>'."\n";
		echo '<noscript>Please turn on javascript to submit your data. Thank you!</noscript>'."\n";
                
                echo '</div>';
                
                echo '</div>';
                
                echo '<input type="hidden" name="tmpl" value="component"/>';
                
	}
	
	public function parseToggleFields( $code ){
		/*
		 	example codes:

			turn on element bla if blub is on
			turn off section bla if blub is on
			turn on section bla if blub is off
			turn off element bla if blub is off

                        if element opener is off set opener huhuu

			syntax:
			ACTION STATE TARGETCATEGORY TARGETNAME if SRCNAME is VALUE 
		 */
		
		$parsed = '';
		$code = str_replace("\r", '', $code);
		$lines = explode( "\n", $code );
		$linesCnt = count( $lines );
		
		for($i = 0; $i < $linesCnt;$i++){
			$tokens = explode( ' ', trim($lines[$i]) );
			$tokensCnt = count($tokens);
			if($tokensCnt >= 8){
				$state = '';
				// rebuilding the state as it could be a value containing blanks
				for($j = 7; $j < $tokensCnt; $j++){
					if($j+1 < $tokensCnt)
						$state .= $tokens[$j] . ' ';
					else
						$state .= $tokens[$j];
				}
				$parsed .= '{ action: "'.$tokens[0].'", state: "'.$tokens[1].'", tCat: "'.$tokens[2].'", tName: "'.$tokens[3].'", statement: "'.$tokens[4].'", sName: "'.$tokens[5].'", condition: "'.$tokens[6].'", value: "'.addslashes($state).'" },';
			}
		}
		
		return "[".rtrim($parsed, ",")."]";
	}
}