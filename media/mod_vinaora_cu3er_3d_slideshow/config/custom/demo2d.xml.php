<?php
/**
 * @version		$Id: demo2d.xml.php 2012-03-01 vinaora $
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
		<auto_play>
			<defaults symbol="circular" />
			<tweenIn x="280" y="20" width="16" height="16" />
			<tweenOver  width="22" height="22" />
			<tweenOut  />
		</auto_play>
		<prev_button>
			<defaults round_corners="20,0,20,0"/>
			<tweenIn x="54" y="220" width="40" height="40" />
			<tweenOver width="44" x="52" tint="0xFFFFFF" />
			<tweenOut x="32" tint="0x000000" />
		</prev_button>
		<prev_symbol>
			<defaults type="3" />
			<tweenIn x="54" y="220" scaleX=".7" scaleY=".7" />
			<tweenOver  x="49" tint="0x000000" scaleX=".6" scaleY=".6"/>
			<tweenOut  x="32" scaleX=".1" scaleY=".1"/>
		</prev_symbol>
		<next_button>
			<defaults round_corners="0,20,0,20"/>
			<tweenIn  x="245" y="220" width="40" height="40" />
			<tweenOver width="44" x="247" tint="0xFFFFFF" />
			<tweenOut  x="265" tint="0x000000" />
		</next_button>
		<next_symbol>
			<defaults type="3" />
			<tweenIn  x="245" y="220"  scaleX=".7" scaleY=".7" />
			<tweenOver  x="250"  tint="0x000000" scaleX=".6" scaleY=".6"/>
			<tweenOut   x="265" scaleX=".1" scaleY=".1"/>
		</next_symbol>
		<description>
			<defaults
				round_corners="0, 0, 0, 0"
				heading_font="Arial"
				heading_text_size="11"
				heading_text_align="center"
				heading_text_color="0xFFFFFF"
				heading_text_margin="10, 0, 0, 0"
			/>
			<tweenIn  x="75" y="200" width="149" height="40" />
			<tweenOut  y="260" />
		</description>
		<transitions light_position="0,0,-100000" shader="flat" />
	</settings>
	<slides>
		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo2/slide_1.jpg</url>
			<description>
				<heading>CU3ER - flash 3D slider!</heading>
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
				<heading>Flat &amp; phong shading</heading>
			</description>
		</slide>
		<transition num="6" slicing="vertical" direction="up" delay="0.02" z_multiplier="4" />
		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo2/slide_5.jpg</url>
			<description>
				<heading>Unique look &amp; feel </heading>
			</description>
		</slide>
	</slides>
</data>