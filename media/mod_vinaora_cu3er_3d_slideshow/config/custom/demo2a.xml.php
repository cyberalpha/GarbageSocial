<?php
/**
 * @version		$Id: demo2a.xml.php 2012-03-01 vinaora $
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
<data>
	<settings>
		<general slide_panel_width="300" slide_panel_height="250" />
		<prev_button>
			<defaults round_corners="50,50,50,50" />
			<tweenIn x="-25" width="100" height="100" alpha=".1" />
			<tweenOver  x="-20" tint="0xFFFFFF" alpha="0" />
			<tweenOut tint="0x000000" />
		</prev_button>
		<prev_symbol>
			<defaults type="6" />
			<tweenIn x="10" scaleX=".25" scaleY=".25" />
			<tweenOver  x="12" scaleX=".5" scaleY=".5"/>
		</prev_symbol>
		<next_button>
			<defaults round_corners="50,50,50,50"/>
			<tweenIn x="325" width="100" height="100" alpha=".1" />
			<tweenOver x="320" tint="0xFFFFFF" alpha="0"/>
			<tweenOut  tint="0x000000" />
		</next_button>
		<next_symbol>
			<defaults type="6" />
			<tweenIn x="290" scaleX=".25" scaleY=".25" />
			<tweenOver  x="288"  scaleX=".5" scaleY=".5"/>
		</next_symbol>
		<description>
			<defaults
				round_corners="20, 20, 20, 20"
				heading_font="Arial"
				heading_text_size="11"
				heading_text_align="center"
				heading_text_color="0xFFFFFF"
				heading_text_margin="2, 0, 0, 0"
			/>
			<tweenIn x="30" y="206" width="240" height="23" alpha=".1"/>
		</description>
		<transitions light_position="0,0,-100000" shader="flat" />
	</settings>
	<slides>
		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo2/slide_1.jpg</url>
			<description>
				<heading>CU3ER - free flash 3D image slider!</heading>
			</description>
		</slide>
		<transition num="3" slicing="vertical" direction="down" delay="0.03" z_multiplier="3" />
		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo2/slide_2.jpg</url>
			<description>
				<heading>Customizable via XML!</heading>
			</description>
		</slide>
		<transition num="3" direction="right" />
		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo2/slide_3.jpg</url>
			<description>
				<heading>Real 3D transitions</heading>
			</description>
		</slide>
		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo2/slide_4.jpg</url>
			<description>
				<heading>Flat and phong shading</heading>
			</description>
		</slide>
		<transition num="6" slicing="vertical" direction="up" delay="0.02" z_multiplier="4" />
		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo2/slide_5.jpg</url>
			<description>
				<heading>Unique look and feel</heading>
			</description>
		</slide>
	</slides>
</data>