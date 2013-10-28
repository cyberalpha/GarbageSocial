<?php
/**
* @version 1.5.x
* @package ZooTemplate Project
* @email webmaster@zootemplate.com
* @copyright (c) 2008 - 2011 http://www.ZooTemplate.com. All rights reserved.
*/
?>
<?php if($this->params->get('zt_change_color')) { ?>
<div id="option_wrapper" style="left:-197px;">
	<div class="inner">
			<?php			
				$cookies = array();
				foreach($groups as $key=>$val)
				{
					echo "<div class=\"grouptitle\">".$val."</div>";
					foreach($value[$key] as $k=>$v)
					{
						$cookies[] = $prefix.'_'.$k.'_'.$key;
						switch($k)
						{
							case "color":
								include (dirname(__FILE__).DS.'_color.php');
							break;
							case "image":
								include (dirname(__FILE__).DS.'_images.php');
							break;
							case "link":
								include (dirname(__FILE__).DS.'_link.php');
							break;
							case "text":
								include (dirname(__FILE__).DS.'_text.php');								
							break;
						}
					}
				}
			?>	
			<div class="rb-items clearfix">
				<input type="button" onclick="javascript: onResetDefault(['<?php echo implode($cookies, '\',\'');?>']);" value="Reset" class="rb-reset" />
			</div>
	</div>
</div>
<div id="option_btn" style="left:0;"><span>&nbsp;</span></div>
<?php }?>