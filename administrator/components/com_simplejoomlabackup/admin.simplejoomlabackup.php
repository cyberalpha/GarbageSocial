<?php
/**
 * @version		$Id: simplejoomlabackup.php 1 2010-03-20$
 * @author-name Ribamar FS
 * @copyright	Copyright (C) 2010 Ribamar FS.
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 * simplejoomlabackup is free and open source software. This version may have been modified 
 * pursuant to the GNU General Public License, and as distributed it includes or is 
 * derivative of works licensed under the GNU General Public License or other free or 
 * open source software licenses. 
 */

defined('_JEXEC') or die('Restricted access');

$ver =  phpversion();

jimport('joomla.filesystem.archive');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

ini_set('memory_limit','512M');
ini_set('max_execution_time', 480); // Pode ser '120'

// Scan directory and delete all files with extension
// Example: remove_ext($file='/home/ribafs/teste.zip', $ext='zip')
function remove_ext($file, $ext){
	$handle = opendir($file);

	//$name = JFile::stripExt($portal2);
	/* This is the correct way to loop over the directory. */
	while (false !== ($file2 = readdir($handle))) {
		$ext2 =  JFile::getExt($file2);

		if($ext2 == $ext && $file2 != '.' && $file2 != '..') {
			unlink($file.DS.$file2);
		}
	}
	closedir($handle);
}

remove_ext(JPATH_ROOT.DS.'tmp', 'sql');
remove_ext(JPATH_ROOT.DS.'tmp', 'zip');

$lang =& JFactory::getLanguage();
$lang = $lang->getName();

if(substr($lang,0,6)=='Portug'){
	$win = './components/com_simplejoomlabackup/leiame.html';
}else{
	$win = './components/com_simplejoomlabackup/readme.html';
}

if(!is_writable(JPATH_ROOT.DS.'administrator')){
	JFactory::getApplication()->enqueueMessage( JText::_('DIR_ADMIN'),'error');
}

if(!is_writable(JPATH_ROOT.DS.'tmp')){
	JFactory::getApplication()->enqueueMessage( JText::_('DIR_TMP'),'error');
}

$date = date('d-m-Y_H-i');

// Pre-Load configuration
require_once( JPATH_CONFIGURATION.DS.'configuration.php' );

class backup{
		
    // Constructor
 	function __construct($dbhost,$database,$dbUser ,$dbPass ,$tables="*" ) {

		$config =& JFactory::getApplication(); 
		$name = $config->getCfg('db');

 	   //let me collact all data before we start	
		$date = date('d-m-Y_H-i');
		$this->host = $dbhost;
 		$this->database = $database;
 		$this->user = $dbUser;
 		$this->pass = $dbPass ;
 		$this->file = '../tmp/'.$name . '_'. $date . '.sql';
 		$this->tables =$tables;
	    $this->msg='';
 	}
			
	// Connnect
	private function Connect() {
 		 mysql_connect($this->host, $this->user, $this->pass) or die(mysql_error());
		 mysql_select_db($this->database) or die(mysql_error());
		mysql_query("SET NAMES 'utf8';");
 	}
	
	//Backup
	public function backup(){

		$this->Connect();    
		//get list of the tables
		if($this->tables == '*')  {
			$this->tables = array();
			$result = mysql_query('SHOW TABLES');
			while($row = mysql_fetch_row($result)){
				$this->tables[] = $row[0];
			}
		} else  {
			$this->tables = is_array($this->tables) ? $this->tables : explode(',',$this->tables);
		}

        //processs each
		$return="";
		foreach($this->tables as $table)  {
		$result = @mysql_query('SELECT * FROM '.$table);
		$num_fields = @mysql_num_fields($result);    
		$row2 = @mysql_fetch_row(@mysql_query('SHOW CREATE TABLE '.$table));		
	    $return .= "\n\n".$row2[1].";\n\n";
	   
    
			while($row = @mysql_fetch_row($result))	{
		    $return .= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++){
				  $row[$j] = addslashes($row[$j]);
				  if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
				  if ($j<($num_fields-1)) { $return.= ','; }		 
				}
				$return .= ");\n";
			}
 
		    $return.="\n\n\n";
		}

		//Lets Write A file
		if (file_exists($this->file)) unlink($this->file);
		$handle = fopen($this->file,'w+');
		fwrite($handle,$return);
		fclose($handle);
	}// function
}//class

// Adapted from: http://buffernow.com/2012/06/backup-and-restore-mysql-database-using-php-script/ by Rohit

$config =& JFactory::getApplication(); 

$host = $config->getCfg('host');
$user = $config->getCfg('user');
$pass = $config->getCfg('password');
$name = $config->getCfg('db');

$portal2 = '../tmp/'.$name. '_'. $date . '.zip';

?>
<h1>Simple Joomla Backup</h1>
<h1><a href="<?php print $win;?>" target="_blank"><?php echo JText::_( 'HELP' );?></a></h1>
<p><strong><?php echo JText::_( 'CLEAR' );?></strong></p>

<form action="" method="post" name="adminForm" id="adminForm">
	<strong><?php echo JText::_( 'EXCLUDE_DIR' );?></strong><br><br>
	<input type="text" name="delete" value="down">&nbsp;&nbsp;
	<input type="submit" name="send" value="<?php echo JText::_( 'START' );?>">
</form>

<?php

/**
 * Copy a file, or recursively copy a folder and its contents
 * @param       string   $source    Source path
 * @param       string   $dest      Destination path
 * @param       string   $permissions New folder creation permissions
 * @return      bool     Returns true on success, false on failure
 * @author xaguilars - http://stackoverflow.com/questions/2050859/copy-entire-contents-of-a-directory-to-another-using-php
 */
$delete = JRequest::getVar('delete');

function Zip($source, $destination, $delete)
{
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true){
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file){
            $file = str_replace('\\', '/', realpath($file));

            if (is_dir($file) === true){
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            }else if (is_file($file) === true){
                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
            }
        }
    }else if (is_file($source) === true){
        $zip->addFromString(basename($source), file_get_contents($source));
    }

	if($zip->open($destination)===TRUE){      //zip file name
		for($i=0;$i<$zip->numFiles;$i++){
		    $entry_info = $zip->statIndex($i);
		    if(substr($entry_info["name"],0,strlen($delete.'/'))==$delete.'/'){
		        $zip->deleteIndex($i);
		    }
		}
	}

    return $zip->close();
	// Original: http://stackoverflow.com/questions/1334613/how-to-recursively-zip-a-directory-in-php
}

if(JRequest::getVar('clear')){
	remove_ext(JPATH_ROOT.DS.'tmp', 'sql');
	remove_ext(JPATH_ROOT.DS.'tmp', 'zip');
	JFactory::getApplication()->enqueueMessage( JText::_('DELETED'),'message');
}

if(JRequest::getVar('send')){
	//require('backup.class.php');
	$config =& JFactory::getApplication(); 
	$dbhost = $config->getCfg('host');
	$dbuser = $config->getCfg('user');
	$dbpass = $config->getCfg('password');
	$database = $config->getCfg('db');

	$newImport = new backup($dbhost,$database,$dbuser,$dbpass,'*');

	//call of backup function
	$message=$newImport->backup();
	$sql = $newImport->file;
	echo $message;

	Zip("..".DS, $portal2, $delete);

		JFactory::getApplication()->enqueueMessage( JText::_('SUCCESS'),'message');
	?> 
	<br><h2>Download</h2>
	<h3><a href="<?php print $sql;?>"><?php print JText::_('DATABASE');?> (sql)</a></h3>
	<h3><a href="<?php print $portal2;?>"><?php print JText::_('FILES');?>(zip)</a></h3>

	<form action="" method="post" name="adminForm" id="adminForm">
		<input type="submit" name="clear" value="<?php echo JText::_( 'CLEARBACKUP' );?>">
	</form>
	<?php
}
?>
