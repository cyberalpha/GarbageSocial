<?php
/**
 * @version		$Id: demo1.xml.php 2012-03-01 vinaora $
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
		<general slide_panel_width="960" slide_panel_height="360" />

		<auto_play>
			<defaults symbol="circular"/>
			<tweenIn x="895" y="45" width="30" height="30" tint="0xFFFFFF" alpha="0.5"/>
			<tweenOver alpha="1"/>
		</auto_play>

		<prev_button>
			<tweenIn x="865" y="300" width="30" height="30" alpha="0"/>
			<tweenOver alpha="0"/>
		</prev_button>

		<next_button>
			<tweenIn x="895" y="300" width="30" height="30" alpha="0"/>
			<tweenOver alpha="0"/>
		</next_button>

		<prev_symbol>
			<defaults type="3"/>
			<tweenIn x="865" y="300" alpha="0.5"/>
			<tweenOver time="0.15" x="860" scaleX="1.1" scaleY="1.1"/>
		</prev_symbol>

		<next_symbol>
			<defaults type="3"/>
			<tweenIn x="895" y="300" alpha="0.5"/>
			<tweenOver time="0.15" x="900" scaleX="1.1" scaleY="1.1"/>
		</next_symbol>

		<description>
			<defaults round_corners="10, 10, 10, 10" heading_text_size="22" heading_text_color="0xfc9900" paragraph_text_size="13" paragraph_text_color="0xFFFFFF"/>
			<tweenIn x="200" y="240" width="560" height="90" alpha="0.15"/>
			<tweenOver alpha="0.3"/>
		</description>

		<transitions slicing="vertical" direction="down" duration="0.6" delay="0.2" cube_color="0x611811"/>
	</settings>

	<slides>

		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo1/slide_1.jpg</url>
			<link target="_blank">http://vinaora.com</link>
		</slide>

		<transition direction="left"/>

		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo1/slide_2.jpg</url>
			<link target="_blank">http://vinaora.com</link>
		</slide>

		<transition duration="0.6" delay=".2" direction="down"/>

		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo1/slide_3.jpg</url>
			<link target="_blank">http://vinaora.com</link>
		</slide>

		<transition num="3" slicing="horizontal" direction="left" delay="0.05"/>

		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo1/slide_4.jpg</url>
			<link target="_blank">http://vinaora.com</link>
		</slide>

		<transition num="3"/>

		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo1/slide_5.jpg</url>
			<link target="_blank">http://vinaora.com</link>
		</slide>

		<transition num="6" slicing="horizontal" direction="right" duration="0.8" delay="0.05" z_multiplier="5"/>

		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo1/slide_6.jpg</url>
			<link target="_blank">http://vinaora.com</link>
		</slide>

		<transition num="6" slicing="vertical" direction="down" shader="phong" delay="0.05"/>

		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo1/slide_7.jpg</url>
			<link target="_blank">http://vinaora.com</link>
		</slide>

		<transition num="4" direction="down" slicing="horizontal" z_multiplier="6" delay="0.1"/>

		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo1/slide_8.jpg</url>
		</slide>

		<transition num="4" direction="up" z_multiplier="2.5" delay="0.03"/>

		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo1/slide_9.jpg</url>
			<description>
				<link target="_blank">http://vinaora.com</link>
				<heading>Put your heading here!</heading>
				<paragraph>Paragraph text - put your text here and describe your beautiful slide. Paragraph text - put your text here and describe your beautiful slide. Paragraph text - put your text here and describe your beautiful slide.</paragraph>
			</description>
		</slide>

		<transition direction="right"/>

		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo1/slide_10.jpg</url>
		</slide>

		<transition num="3" direction="up"/>

		<slide>
			<url><?php echo $base_path; ?>media/mod_vinaora_cu3er_3d_slideshow/images/demo1/slide_11.jpg</url>
			<link target="_blank">http://vinaora.com</link>
		</slide>

	</slides>
</data>