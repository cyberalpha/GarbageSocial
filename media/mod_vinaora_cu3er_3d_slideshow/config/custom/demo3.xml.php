<?php
/**
 * @version		$Id: demo3.xml.php 2012-03-01 vinaora $
 * @package		Vinaora Cu3er 3D Slideshow
 * @subpackage	mod_vinaora_cu3er_3d_slideshow
 * @copyright	Copyright (C) 2010 - 2012 VINAORA. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @website		http://vinaora.com
 * @twitter		http://twitter.com/vinaora
 * @facebook	http://facebook.com/vinaora
 */

// Get the beginning of URL
// Eg: URL = /media/mod_vinaora_slickshow/config/demo.xml.php --> Result = /
// Eg: URL = /path/to/sub/directory/media/mod_vinaora_slickshow/config/demo.xml.php --> Result = /path/to/sub/directory/
$base_path	= preg_replace( '/media\/mod_vinaora_cu3er_3d_slideshow\/(.*)$/', '', $_SERVER['SCRIPT_NAME'] );

if (!headers_sent()) header ("content-type: text/xml");
?>
<cu3er>
	<settings>
		<general slide_panel_width="600" slide_panel_height="300" />
		<prev_button>
			<defaults round_corners="5,5,5,5"/>
			<tweenOver tint="0xFFFFFF" scaleX="1.1" scaleY="1.1"/>
			<tweenOut tint="0x000000" />
		</prev_button>
		<prev_symbol>
			<tweenOver tint="0x000000" />
		</prev_symbol>
		<next_button>
			<defaults round_corners="5,5,5,5"/>
			<tweenOver tint="0xFFFFFF"  scaleX="1.1" scaleY="1.1"/>
			<tweenOut tint="0x000000" />
		</next_button>
		<next_symbol>
			<tweenOver tint="0x000000" />
		</next_symbol>
	</settings>
	<slides>
		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo3/slide_1.jpg</url>
			<description>
				<link target="_blank">http://vinaora.com</link>
				<heading>Vinaora Cu3er 3D Slideshow</heading>
				<paragraph>Vinaora Cu3er 3D Slide-show is a free Joomla! module (Joomla! extension) to show images in 3D Flash Slide-show.</paragraph>
			</description>
		</slide>
		<!-- changing transition between first & second slide -->
		<transition num="3" slicing="vertical" direction="down"/>
		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo3/slide_2.jpg</url>
			<description>
				<link target="_blank">http://vinaora.com/vinaora-nivo-slider/</link>
				<heading>Vinaora Nivo Slider</heading>
				<paragraph>Vinaora Nivo Slider is a great slideshow module for Joomla. It allows you to easily create an image slider (slideshow) using Nivo Slider.</paragraph>
			</description>
		</slide>
		<!-- changing transition between second & third slide -->
		<transition num="4" direction="right" shader="flat" />
		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo3/slide_3.jpg</url>
			<description>
				<link target="_blank">http://vinaora.com/vinaora-slick-slideshow/</link>
				<heading>Vinaora Slick Slideshow</heading>
				<paragraph>Vinaora Slick Slideshow is Fashionable flash + image slideshow with slick navigation and design, fully customizable from back-end, with a motion blur effect on image transition.</paragraph>
			</description>
		</slide>
		<!-- transitions properties defined in transitions template -->
		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo3/slide_4.jpg</url>
			<description>
				<link target="_blank">http://vinaora.com/vinaora-visitors-counter/</link>
				<heading>Vinaora Visitors Counter</heading>
				<paragraph>Vinaora Visitors Counter is a famous and nice counter module for Joomla!. This module shows you the number visitors of your site by day, by week, by month.</paragraph>
			</description>
		</slide>
		<transition num="6" slicing="vertical" direction="up" shader="flat" delay="0.05" z_multiplier="4" />
		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo3/slide_5.jpg</url>
			<description>
				<link target="_blank">http://vinaora.com/vinaora-world-time-clock/</link>
				<heading>Vinaora World Time Clock</heading>
				<paragraph>Vinaora World Time Clock is a nice clock module for Joomla!. It shows current local time in cities and countries in all time zones, adjusted for Daylight Saving Time rules automatically.</paragraph>
			</description>
		</slide>
	</slides>
</cu3er>