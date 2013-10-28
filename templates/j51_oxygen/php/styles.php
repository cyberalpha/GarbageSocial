
<?php
defined( '_JEXEC' ) or die( 'Restricted index access' );?>   

<link rel="stylesheet" href="templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template?>/css/reset.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template?>/css/typo.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template?>/css/template.css" type="text/css" />
<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/<?php echo $this->params->get('colorStyle'); ?>.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template?>/css/nexus.css" type="text/css" />

<?php /*?>Set Google font choices to body, articleheads, moduleheads and hornav menu<?php */?>
<?php if(($body_fontstyle == "Arial, Helvetica, sans-serif") || ($body_fontstyle == "Courier, monospace") || ($body_fontstyle == "Tahoma, Geneva, sans-serif") || ($body_fontstyle == "Garamond, serif") || ($body_fontstyle == "Georgia, serif") || ($body_fontstyle == "Impact, Charcoal, sans-serif") || ($body_fontstyle == "Lucida Console, Monaco, monospace") || ($body_fontstyle == "Lucida Sans Unicode, Lucida Grande, sans-serif") || ($body_fontstyle == "MS Sans Serif, Geneva, sans-serif") || ($body_fontstyle == "MS Serif, New York, sans-serif") || ($body_fontstyle == "Palatino Linotype, Book Antiqua, Palatino, serif") || ($body_fontstyle == "Times New Roman, Times, serif") || ($body_fontstyle == "Trebuchet MS, Helvetica, sans-serif") || ($body_fontstyle == "Verdana, Geneva, sans-serif")) : ?>
<style type="text/css">body{font-family:<?php echo ($body_fontstyle); ?> }</style>
 
<?php elseif(($body_fontstyle != "Arial, Helvetica, sans-serif") || ($body_fontstyle != "Courier, monospace") || ($body_fontstyle != "Tahoma, Geneva, sans-serif") || ($body_fontstyle != "Garamond, serif") || ($body_fontstyle != "Georgia, serif") || ($body_fontstyle != "Impact, Charcoal, sans-serif") || ($body_fontstyle != "Lucida Console, Monaco, monospace") || ($body_fontstyle != "Lucida Sans Unicode, Lucida Grande, sans-serif") || ($body_fontstyle != "MS Sans Serif, Geneva, sans-serif") || ($body_fontstyle != "MS Serif, New York, sans-serif") || ($body_fontstyle != "Palatino Linotype, Book Antiqua, Palatino, serif") || ($body_fontstyle != "Times New Roman, Times, serif") || ($body_fontstyle != "Trebuchet MS, Helvetica, sans-serif") || ($body_fontstyle != "Verdana, Geneva, sans-serif")) : ?>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $body_fontstyle ?>" />
<style type="text/css">body{font-family:<?php echo ($body_fontstyle); ?> }</style>
<?php endif; ?>
 
<?php if(($articlehead_fontstyle == "Arial, Helvetica, sans-serif") || ($articlehead_fontstyle == "Courier, monospace") || ($articlehead_fontstyle == "Tahoma, Geneva, sans-serif") || ($articlehead_fontstyle == "Garamond, serif") || ($articlehead_fontstyle == "Georgia, serif") || ($articlehead_fontstyle == "Impact, Charcoal, sans-serif") || ($articlehead_fontstyle == "Lucida Console, Monaco, monospace") || ($articlehead_fontstyle == "Lucida Sans Unicode, Lucida Grande, sans-serif") || ($articlehead_fontstyle == "MS Sans Serif, Geneva, sans-serif") || ($articlehead_fontstyle == "MS Serif, New York, sans-serif") || ($articlehead_fontstyle == "Palatino Linotype, Book Antiqua, Palatino, serif") || ($articlehead_fontstyle == "Times New Roman, Times, serif") || ($articlehead_fontstyle == "Trebuchet MS, Helvetica, sans-serif") || ($articlehead_fontstyle == "Verdana, Geneva, sans-serif")) : ?>
<style type="text/css">h2{font-family:<?php echo ($articlehead_fontstyle); ?> }</style>
 
<?php elseif(($articlehead_fontstyle != "Arial, Helvetica, sans-serif") || ($articlehead_fontstyle != "Courier, monospace") || ($articlehead_fontstyle != "Tahoma, Geneva, sans-serif") || ($articlehead_fontstyle != "Garamond, serif") || ($articlehead_fontstyle != "Georgia, serif") || ($articlehead_fontstyle != "Impact, Charcoal, sans-serif") || ($articlehead_fontstyle != "Lucida Console, Monaco, monospace") || ($articlehead_fontstyle != "Lucida Sans Unicode, Lucida Grande, sans-serif") || ($articlehead_fontstyle != "MS Sans Serif, Geneva, sans-serif") || ($articlehead_fontstyle != "MS Serif, New York, sans-serif") || ($articlehead_fontstyle != "Palatino Linotype, Book Antiqua, Palatino, serif") || ($articlehead_fontstyle != "Times New Roman, Times, serif") || ($articlehead_fontstyle != "Trebuchet MS, Helvetica, sans-serif") || ($articlehead_fontstyle != "Verdana, Geneva, sans-serif")) : ?>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $articlehead_fontstyle ?>" />
<style type="text/css">h2{font-family:<?php echo ($articlehead_fontstyle); ?> }</style>
<?php endif; ?>
 
<?php if(($modulehead_fontstyle == "Arial, Helvetica, sans-serif") || ($modulehead_fontstyle == "Courier, monospace") || ($modulehead_fontstyle == "Tahoma, Geneva, sans-serif") || ($modulehead_fontstyle == "Garamond, serif") || ($modulehead_fontstyle == "Georgia, serif") || ($modulehead_fontstyle == "Impact, Charcoal, sans-serif") || ($modulehead_fontstyle == "Lucida Console, Monaco, monospace") || ($modulehead_fontstyle == "Lucida Sans Unicode, Lucida Grande, sans-serif") || ($modulehead_fontstyle == "MS Sans Serif, Geneva, sans-serif") || ($modulehead_fontstyle == "MS Serif, New York, sans-serif") || ($modulehead_fontstyle == "Palatino Linotype, Book Antiqua, Palatino, serif") || ($modulehead_fontstyle == "Times New Roman, Times, serif") || ($modulehead_fontstyle == "Trebuchet MS, Helvetica, sans-serif") || ($modulehead_fontstyle == "Verdana, Geneva, sans-serif")) : ?>
<style type="text/css">.module h3, .module_menu h3{font-family:<?php echo ($modulehead_fontstyle); ?> }</style>
 
<?php elseif(($modulehead_fontstyle != "Arial, Helvetica, sans-serif") || ($modulehead_fontstyle != "Courier, monospace") || ($modulehead_fontstyle != "Tahoma, Geneva, sans-serif") || ($modulehead_fontstyle != "Garamond, serif") || ($modulehead_fontstyle != "Georgia, serif") || ($modulehead_fontstyle != "Impact, Charcoal, sans-serif") || ($modulehead_fontstyle != "Lucida Console, Monaco, monospace") || ($modulehead_fontstyle != "Lucida Sans Unicode, Lucida Grande, sans-serif") || ($modulehead_fontstyle != "MS Sans Serif, Geneva, sans-serif") || ($modulehead_fontstyle != "MS Serif, New York, sans-serif") || ($modulehead_fontstyle != "Palatino Linotype, Book Antiqua, Palatino, serif") || ($modulehead_fontstyle != "Times New Roman, Times, serif") || ($modulehead_fontstyle != "Trebuchet MS, Helvetica, sans-serif") || ($modulehead_fontstyle != "Verdana, Geneva, sans-serif")) : ?>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $modulehead_fontstyle ?>" />
<style type="text/css">.module h3, .module_menu h3{font-family:<?php echo ($modulehead_fontstyle); ?> }</style>
<?php endif; ?>
 
<?php if(($hornav_fontstyle == "Arial, Helvetica, sans-serif") || ($hornav_fontstyle == "Courier, monospace") || ($hornav_fontstyle == "Tahoma, Geneva, sans-serif") || ($hornav_fontstyle == "Garamond, serif") || ($hornav_fontstyle == "Georgia, serif") || ($hornav_fontstyle == "Impact, Charcoal, sans-serif") || ($hornav_fontstyle == "Lucida Console, Monaco, monospace") || ($hornav_fontstyle == "Lucida Sans Unicode, Lucida Grande, sans-serif") || ($hornav_fontstyle == "MS Sans Serif, Geneva, sans-serif") || ($hornav_fontstyle == "MS Serif, New York, sans-serif") || ($hornav_fontstyle == "Palatino Linotype, Book Antiqua, Palatino, serif") || ($hornav_fontstyle == "Times New Roman, Times, serif") || ($hornav_fontstyle == "Trebuchet MS, Helvetica, sans-serif") || ($hornav_fontstyle == "Verdana, Geneva, sans-serif")) : ?>
<style type="text/css">#hornav{font-family:<?php echo ($hornav_fontstyle); ?> }</style>
 
<?php elseif(($hornav_fontstyle != "Arial, Helvetica, sans-serif") || ($hornav_fontstyle != "Courier, monospace") || ($hornav_fontstyle != "Tahoma, Geneva, sans-serif") || ($hornav_fontstyle != "Garamond, serif") || ($hornav_fontstyle != "Georgia, serif") || ($hornav_fontstyle != "Impact, Charcoal, sans-serif") || ($hornav_fontstyle != "Lucida Console, Monaco, monospace") || ($hornav_fontstyle != "Lucida Sans Unicode, Lucida Grande, sans-serif") || ($hornav_fontstyle != "MS Sans Serif, Geneva, sans-serif") || ($hornav_fontstyle != "MS Serif, New York, sans-serif") || ($hornav_fontstyle != "Palatino Linotype, Book Antiqua, Palatino, serif") || ($hornav_fontstyle != "Times New Roman, Times, serif") || ($hornav_fontstyle != "Trebuchet MS, Helvetica, sans-serif") || ($hornav_fontstyle != "Verdana, Geneva, sans-serif")) : ?>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $hornav_fontstyle ?>" />
<style type="text/css">#hornav{font-family:<?php echo ($hornav_fontstyle); ?> }</style>
<?php endif; ?>
 
<?php if(($logo_fontstyle == "Arial, Helvetica, sans-serif") || ($logo_fontstyle == "Courier, monospace") || ($logo_fontstyle == "Tahoma, Geneva, sans-serif") || ($logo_fontstyle == "Garamond, serif") || ($logo_fontstyle == "Georgia, serif") || ($logo_fontstyle == "Impact, Charcoal, sans-serif") || ($logo_fontstyle == "Lucida Console, Monaco, monospace") || ($logo_fontstyle == "Lucida Sans Unicode, Lucida Grande, sans-serif") || ($logo_fontstyle == "MS Sans Serif, Geneva, sans-serif") || ($logo_fontstyle == "MS Serif, New York, sans-serif") || ($logo_fontstyle == "Palatino Linotype, Book Antiqua, Palatino, serif") || ($logo_fontstyle == "Times New Roman, Times, serif") || ($logo_fontstyle == "Trebuchet MS, Helvetica, sans-serif") || ($logo_fontstyle == "Verdana, Geneva, sans-serif")) : ?>
<style type="text/css">h1.logo-text a{font-family:<?php echo ($logo_fontstyle); ?> }</style>
 
<?php elseif(($logo_fontstyle != "Arial, Helvetica, sans-serif") || ($logo_fontstyle != "Courier, monospace") || ($logo_fontstyle != "Tahoma, Geneva, sans-serif") || ($logo_fontstyle != "Garamond, serif") || ($logo_fontstyle != "Georgia, serif") || ($logo_fontstyle != "Impact, Charcoal, sans-serif") || ($logo_fontstyle != "Lucida Console, Monaco, monospace") || ($logo_fontstyle != "Lucida Sans Unicode, Lucida Grande, sans-serif") || ($logo_fontstyle != "MS Sans Serif, Geneva, sans-serif") || ($logo_fontstyle != "MS Serif, New York, sans-serif") || ($logo_fontstyle != "Palatino Linotype, Book Antiqua, Palatino, serif") || ($logo_fontstyle != "Times New Roman, Times, serif") || ($logo_fontstyle != "Trebuchet MS, Helvetica, sans-serif") || ($logo_fontstyle != "Verdana, Geneva, sans-serif")) : ?>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $logo_fontstyle ?>" />
<style type="text/css">h1.logo-text a{font-family:<?php echo ($logo_fontstyle); ?> }</style>
<?php endif; ?>
<?php /*?>End Set Google font choices to body, articleheads, moduleheads and hornav menu<?php */?>

<?php if($this->direction == 'rtl') : ?>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template?>/css/template_rtl.css" type="text/css" />
<?php endif; ?>


<style type="text/css">
/*--Set Logo Image position and locate logo image file--*/ 
h1.logo a {left:<?php echo ($logo_x); ?>px}
h1.logo a {top:<?php echo ($logo_y); ?>px}

<?php if($this->params->get('logoimagefile') == '') : ?>
h1.logo a {background: url(<?php echo $defaultlogoimage; ?>) no-repeat; z-index:1;}

<?php elseif($this->params->get('logoimagefile') != '') : ?>
h1.logo a {background: url(<?php echo $this->baseurl ?>/<?php echo $logoimagefile; ?>) no-repeat; z-index:1;}
<?php endif; ?>
/*--End Set Logo Image position and locate logo image file--*/ 

/*--Body font size--*/
body{font-size: <?php echo ($body_fontsize); ?>}

/*--Text Colors for Module Heads and Article titles--*/ 
h2, h2 a:link, h2 a:visited, .content_header, .articleHead {color: <?php echo ($articletitle_font_color); ?> }
.module h3, .module_menu h3 {color: <?php echo ($modulehead_font_color); ?> }
a {color: <?php echo ($content_link_color); ?> }

/*--Text Colors for Logo and Slogan--*/ 
h1.logo-text a {color: <?php echo ($logo_font_color); ?> }
p.site-slogan {color: <?php echo ($slogan_font_color); ?> }

/*--Hornav Ul text color and dropdown background color--*/
#hornav ul li a{color: <?php echo ($hornav_font_color); ?> }
#subMenusContainer ul, #subMenusContainer ol{background-color: <?php echo ($hornav_ddbackground_color); ?> }

/*--Start Style Side Column and Content Layout Divs--*/
/*--Get Side Column widths from Parameters--*/
#sidecol_a {width: <?php echo ($sidecola_width); ?>px }
#sidecol_b {width: <?php echo ($sidecolb_width); ?>px }

/*--Check and see what modules are toggled on/off then take away columns width, margin and border values from overall width*/
<?php if($this->countModules( 'sidecol-a') >= 1 && $this->countModules('sidecol-b') >= 1) : ?>
#content_remainder {width:<?php echo 888 - ($sidecola_width + $sidecolb_width) ?>px }

<?php elseif($this->countModules('sidecol-a') >= 1 && $this->countModules('sidecol-b') == 0) : ?>
#content_remainder {width:<?php echo 888 - ($sidecola_width) ?>px }

<?php elseif($this->countModules('sidecol-a') == 0 && $this->countModules('sidecol-b') >= 1) : ?>
#content_remainder {width:<?php echo 890 - ($sidecolb_width) ?>px }

<?php endif; ?>

/*Style Side Column A, Side Column B and Content Divs layout*/
<?php if($this->params->get('column_layout') == 'SCOLA-SCOLB-COM') : ?>
	#sidecol_a {float:left;}
	#sidecol_b {float:left;}
	#content_remainder {float:left;}

/*Style Content, Side Column A, Side Column B Divs layout*/	
<?php elseif($this->params->get('column_layout') == 'COM-SCOLA-SCOLB') : ?>
	#content_remainder {float:left;}
	#sidecol_a {float:right;}
	#sidecol_b {float:right;}

/*Style Side Column A, Content, Side Column B Divs layout*/
<?php elseif($this->params->get('column_layout') == 'SCOLA-COM-SCOLB') : ?>  
	#sidecol_a {float:left;}
	#sidecol_b {float:right;}
	#content_remainder {float:left;}
<?php endif; ?>
/*--End Style Side Column and Content Layout Divs--*/

/*--Load Custom Css Styling--*/
<?php echo ($custom_css); ?>
</style>




