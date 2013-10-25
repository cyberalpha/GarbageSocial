<?php
/**
 * Random 10 Media Module for MediaLibrary
 * @version 1.5
 * @package Medialibrary
 * @copyright 2009 Andrey Kvasnevskiy-OrdaSoft(akbet@mail.ru); Rob de Cleen(rob@decleen.com); 
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted access' );
$database = JFactory::getDBO();

if( !function_exists( 'sefreltoabs')) {
  function sefRelToAbs( $value ) {
    //Need check!!!

    // Replace all &amp; with & as the router doesn't understand &amp;
    $url = str_replace('&amp;', '&', $value);
    if(substr(strtolower($url),0,9) != "index.php") return $url;
    $uri    = JURI::getInstance();
    $prefix = $uri->toString(array('scheme', 'host', 'port'));
    return $prefix.JRoute::_($url);
  }
}

//Common parameters
$sort_top_by    = $params->def('sort_by_top', 0);        //Get how to sort the top items
$show_published    = $params->def('only_published', 1);    //Get if we only show published items
$show_covers     = $params->def('covers', 0 );             //Get if we show covers
$cover_height    = $params->def('cover_height', "50");     //Get Cover Height 
$show_extra        = $params->def('extras', 1 );             //Get if we show second column with additional info
$show_ranking    = $params->def('ranking', 0 );             //Get if we show the ranking next to them
//Individual parameters
$count_book = intval($params->def('books',1)); 
$count_game = intval($params->def('games',1));
$count_music = intval($params->def('musics',1));
$count_video = intval($params->def('videos',1));

//Definition of Sorts
switch($sort_top_by) 
{
    case 0:
        $sql_sort_top = "hits";
        break;
    case 1:
        $sql_sort_top = "date";
        break;
    case 2:
        $sql_sort_top = "rating";
        break;
}

 
//Check if only display published items
if ($show_published==1) {
    $sql_published = "AND m.published=1 ";
} else {
    $sql_published = "";
}


if($count_book!='' && $count_book!=0) {
    $selectstring = "SELECT a.title, a.imageURL, b.id, m.hits, b.catid FROM #__medialibrary_book AS a, #__medialibrary AS m, #__medialibrary_categories AS b  ". 
                    "WHERE m.media_type='book' AND m.id=b.mediaid AND m.media_id=a.id ".$sql_published.
                    "\nORDER BY ".$sql_sort_top." DESC LIMIT 0,$count_book;";
    $database->setQuery($selectstring);
    $rows_books = $database->loadObjectList();

}

if($count_game!='' && $count_game!=0) {
    $selectstring = "SELECT a.title, a.imageURL, b.id, m.hits, b.catid FROM #__medialibrary_game AS a, #__medialibrary_categories AS b, #__medialibrary AS m ". 
                    "WHERE m.media_type='game' AND m.id=b.mediaid AND m.media_id=a.id ".$sql_published.
                    "\nORDER BY ".$sql_sort_top." DESC LIMIT 0,$count_game;";
    $database->setQuery($selectstring);
    $rows_games = $database->loadObjectList();

}

if($count_music!='' && $count_music!=0) {
    $selectstring = "SELECT a.title, a.imageURL, b.id, m.hits, b.catid FROM #__medialibrary_music AS a, #__medialibrary_categories AS b, #__medialibrary AS m ". 
                    "WHERE m.media_type='music' AND m.id=b.mediaid AND m.id=b.mediaid AND m.media_id=a.id ".$sql_published.
                    "\nORDER BY ".$sql_sort_top." DESC LIMIT 0,$count_music;";
    $database->setQuery($selectstring);
    $rows_musics = $database->loadObjectList();

}

if($count_video!='' && $count_video!=0) {
    $selectstring = "SELECT a.title, a.imageURL, b.id, m.hits, b.catid FROM #__medialibrary_video AS a, #__medialibrary_categories AS b, #__medialibrary AS m ". 
                    "WHERE m.media_type='video' AND m.id=b.mediaid AND m.media_id=a.id ".$sql_published.
                    "\nORDER BY ".$sql_sort_top." DESC LIMIT 0,$count_video;";
    $database->setQuery($selectstring);
    $rows_videos = $database->loadObjectList();
}



    $selectstring = "SELECT id FROM #__menu WHERE link='index.php?option=com_medialibrary'";
    $database->setQuery($selectstring);
    $ItemId_tmp = $database->loadResult();
    

function Display_ML_top($rows, $name, $show_ranking, $show_covers, $show_extra, $cover_height, $ItemId_tmp) {
 global $doc,$my, $mosConfig_live_site, $mainframe,$medialibrary_configuration;
     //$doc->addStyleSheet( $mosConfig_live_site.'/components/com_medialibrary/includes/custom.css' ); 	

        $rank_count = 0;
        $span=0;
        if($show_ranking!=0) $span++;
        if($show_covers!=0) $span++;
        if($show_extra!=0) $span++;
    ?>   
	<style type="text/css">
	table.basictable tr,table.basictable td,table.basictable { border:0 none; }
	a img{
		border:0 !important;
	}
</style>
         <h4><?php echo $name;?></h4>
         <table cellpadding="0" cellspacing="0" class="basictable" width="100%" border="0">          
         
    <?php foreach ($rows as $row) {
    $rank_count = $rank_count + 1;    //start ranking
    $link1 = "index.php?option=com_medialibrary&amp;task=view&amp;catid=".$row->catid."&amp;id=".$row->id."&amp;Itemid=".$ItemId_tmp;
    //for local images
        $imageURL = $row->imageURL;
        if($imageURL != '' && substr($imageURL,0,4) != "http")
        {
            $imageURL = JURI::base() . $row->imageURL;;
        }
        if($imageURL == ''){
            $imageURL = "./components/com_medialibrary/images/no-img_eng.gif";
        }     
    ?>
        <tr>
            <?php if($show_ranking==1) { echo "<td>".$rank_count.":&nbsp;</td>"; } //Add Column for Ranking if param set ?>
            <?php if ($show_covers==1) {?>
            <td>
            <img src="<?php echo $imageURL; ?>" alt="<?php echo $row->title; ?>" hspace="2" vspace="2" border="0" height="<?php echo $cover_height; ?>" />
            </td><?php 
                } ?>
            <td width="160" <?php if($span!=0)  echo "colspan='$span'";?>>
                <a href="<?php echo sefRelToAbs( $link1 ); ?>" target="_self""><?php echo $row->title; ?></a>
            </td>
            <?php if($show_extra==1) {?>
            <td align="right">
                     <font class='small'>(<?php echo $row->hits; ?>)</font>
            </td>
        </tr>
           <?php } ?>
<?php } ?>
        </table>
<?php
}    
?>

   
<?php 
if(count($rows_books)) { Display_ML_top($rows_books, "Top Books", $show_ranking, $show_covers, $show_extra,$cover_height, $ItemId_tmp); }
if(count($rows_games)) { Display_ML_top($rows_games, "Top Games", $show_ranking, $show_covers, $show_extra,$cover_height, $ItemId_tmp); }      
if(count($rows_musics)) { Display_ML_top($rows_musics, "Top Music", $show_ranking, $show_covers, $show_extra,$cover_height, $ItemId_tmp); }      
if(count($rows_videos)) { Display_ML_top($rows_videos, "Top Video", $show_ranking, $show_covers, $show_extra,$cover_height, $ItemId_tmp); }      
?>
<br>
<div style="text-align: center;"><a href="http://ordasoft.com" style="font-size: 10px;">Powered by OrdaSoft!</a></div>
