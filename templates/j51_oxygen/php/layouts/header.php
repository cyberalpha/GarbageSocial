<div id ="header" class="block_holder">  
	<div id="header_items">
        <div id="socialmedia">
            <ul id="navigation">
            <?php if($this->params->get('nav_rssfeed_sw') == '1') : ?>
                <li class="nav_rssfeed"><a href="<?php echo $this->params->get('nav_rssfeed'); ?>" title="RSS Feed"></a></li>
            <?php endif; ?>
            <?php if($this->params->get('nav_twitter_sw') == '1') : ?>
                <li class="nav_twitter"><a href="<?php echo $this->params->get('nav_twitter'); ?>" title="Twitter"></a></li>
            <?php endif; ?>
            <?php if($this->params->get('nav_facebook_sw') == '1') : ?>
                <li class="nav_facebook"><a href="<?php echo $this->params->get('nav_facebook'); ?>" title="Facebook"></a></li>
            <?php endif; ?>
            <?php if($this->params->get('nav_myspace_sw') == '1') : ?>
                <li class="nav_myspace"><a href="<?php echo $this->params->get('nav_myspace'); ?>" title="MySpace"></a></li>
            <?php endif; ?>
            <?php if($this->params->get('nav_blogger_sw') == '1') : ?>
                <li class="nav_blogger"><a href="<?php echo $this->params->get('nav_blogger'); ?>" title="Blogger"></a></li>
            <?php endif; ?>
            <?php if($this->params->get('nav_stumble_sw') == '1') : ?>
                <li class="nav_stumble"><a href="<?php echo $this->params->get('nav_stumble'); ?>" title="StumbleUpon"></a></li>
            <?php endif; ?>
            <?php if($this->params->get('nav_google_sw') == '1') : ?>
                <li class="nav_google"><a href="<?php echo $this->params->get('nav_google'); ?>" title="Google"></a></li>
            <?php endif; ?>
            <?php if($this->params->get('nav_flickr_sw') == '1') : ?>
                <li class="nav_flickr"><a href="<?php echo $this->params->get('nav_flickr'); ?>" title="Flickr"></a></li>
            <?php endif; ?>
            <?php if($this->params->get('nav_linkedin_sw') == '1') : ?>
                <li class="nav_linkedin"><a href="<?php echo $this->params->get('nav_linkedin'); ?>" title="LinkedIn"></a></li>
            <?php endif; ?>
            </ul>
    </div>	

<?php if ($this->countModules( 'headermodule' )) : ?>
<div id="headermodule" class="block_holder"><div class="module_margin">
    <jdoc:include type="modules" name="headermodule" />
</div></div>
<?php endif; ?>

<?php if($search_onoff == "1") : ?>
    <div id="search">
        <?php echo $search; ?>
    </div>
<?php endif; ?>
 
<div id="logo">
    <div class="logo_container">		
        <?php if($this->params->get('logoImage') == '1') : ?>
        <h1 class="logo"> <a href="index.php" title="<?php echo $siteName; ?>"><span>
          <?php echo $siteName; ?> 
          </span></a> </h1>
            <?php else : ?>

        <h1 class="logo-text"> <a href="index.php" title="<?php echo $this->params->get('siteName'); ?>"><span>
          <?php echo $this->params->get('logoText'); ?>
          </span></a> </h1>
            <p class="site-slogan"><?php echo $this->params->get('sloganText'); ?></p>
        <?php endif; ?>
    </div>
</div>
<div class="clear"></div>
</div>

<div id="hornav">
    <?php echo $hornav; ?>
</div>

<div class="clear"></div>
</div>