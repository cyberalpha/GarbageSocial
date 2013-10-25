<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.11
	* Creation date: Mars 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die();

class GMapFPsControllerGMapFP extends GMapFPsController
{

	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add', 'edit' );
		$this->registerTask( 'unpublish', 	'publish');
	}

	function edit()
	{
		JRequest::setVar( 'view', 'gmapfp' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}

	function view()
	{
		JRequest::setVar( 'view', 'gmapfps' );
		JRequest::setVar( 'layout', 'default'  );

		parent::display();
	}

	function save()
	{
		$post	= JRequest::get('post');
		$model = $this->getModel('gmapfp');
		$returnid=$model->store($post);
		if ($returnid>0) {
			$msg = JText::_( 'GMAPFP_SAVED' );
		} else {
			$msg = JText::_( 'GMAPFP_SAVED_ERROR' );
		}

		$link = 'index.php?option=com_gmapfp&controller=gmapfp&task=view';
		// Check the table in so it can be edited.... we are done with it anyway
		$this->setRedirect($link, $msg);
	}

	function apply()
	{
		$post	= JRequest::get('post');
		$model = $this->getModel('gmapfp');
		$returnid=$model->store($post);
		if ($returnid>0) {
			$msg = JText::_( 'GMAPFP_SAVED' );
		} else {
			$msg = JText::_( 'GMAPFP_SAVED_ERROR' );
		}

		$link = 'index.php?option=com_gmapfp&controller=gmapfp&task=edit&cid[]='.(int)$returnid;
		// Check the table in so it can be edited.... we are done with it anyway
		$this->setRedirect($link, $msg);
	}

	function remove()
	{
		$model = $this->getModel('gmapfp');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or more GMapFPs could not be Deleted' );
		} else {
			$msg = JText::_( 'GMapFP(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_gmapfp&controller=gmapfp&task=view', $msg );
	}

	function publish()
	{
		$this->setRedirect( 'index.php?option=com_gmapfp&controller=gmapfp&task=view' );

		// Initialize variables
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task		= JRequest::getCmd( 'task' );
		$publish	= ($task == 'publish');
		$n			= count( $cid );

		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}

		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );

		$query = 'UPDATE #__gmapfp'
		. ' SET published = ' . (int) $publish
		. ' WHERE id IN ( '. $cids .' )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning( 500, $row->getError() );
		}
		$this->setMessage( JText::sprintf( $publish ? 'Items published' : 'Items unpublished', $n ) );

	}

	function copy()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$this->setRedirect( 'index.php?option=com_gmapfp&controller=gmapfp&task=view' );

		$cid	= JRequest::getVar( 'cid', null, 'post', 'array' );
		$db		=& JFactory::getDBO();
		$model = $this->getModel('gmapfp');
		$table	=$model->getTable('GMapFP', 'GMapFPTable');
		$user	= &JFactory::getUser();
		$n		= count( $cid );

		if ($n > 0)
		{
			foreach ($cid as $id)
			{
				if ($table->load( (int)$id ))
				{
					$table->id			= 0;
					$table->nom			= '('.JText::_( 'GMAPFP_COPIE_DE').') ' . $table->nom;
					$table->alias		= '';
					$table->published	= 0;
					$table->userid 		= $user->get('id');
			
					if (!$table->store()) {
						return JError::raiseWarning( $table->getError() );
					}
				}
				else {
					return JError::raiseWarning( 500, $table->getError() );
				}
			}
		}
		else {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		$table->reorder();
		$this->setMessage( JText::sprintf( 'Items copied', $n ) );
	}
	
	function user()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		JRequest::setVar( 'view', 'auteur' );
		JRequest::setVar( 'layout', 'default'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}
	
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_gmapfp&controller=gmapfp&task=view', $msg );
	}

	function edit_upload()
	{
		JRequest::setVar( 'view', 'gmapfp' );
		JRequest::setVar( 'layout', 'upload_form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}

	function upload_image() {
		$mainframe = &JFactory::getApplication(); 
		$config =& JComponentHelper::getParams('com_gmapfp');

		$data = JRequest::get( 'post' );
        $type_image = array(".gif",".jpg",".jpeg",".png",".bmp"); 
		$loaderror = false;
        $file = $_FILES['image1'];
        $file_name = $_FILES['image1']['name'];

        $ext = strrchr($file_name,'.');
        $ext = strtolower($ext);
        if (!in_array( $ext, $type_image )) 
        {
            echo "<script> alert('".JText::_( 'GMAPFP_BAD_EXT')."'); window.history.go(-1); </script>";
            exit();
        }

        $file['name'] = str_replace(" ","_",$file['name']);
		if ((substr($config->get('gmapfp_chemin_img'), 0, 1) != '/') and (substr($config->get('gmapfp_chemin_img'), 0, 1) != '\\'))
			$config->set('gmapfp_chemin_img', '/'.$config->get('gmapfp_chemin_img'));

        if (strlen($_FILES['image1']['tmp_name']) > 0 and $_FILES['image1']['name'] != "none"){	
			//si je n'ai pas déjà ce fichier, je le copi		
            if(!is_file(JPATH_SITE.$config->get('gmapfp_chemin_img').strtolower($file['name'])))
            	copy ($file['tmp_name'], JPATH_SITE.$config->get('gmapfp_chemin_img').strtolower($file['name']));
			else $loaderror=true;				
			if($loaderror) {?>
					<script type="text/javascript" language="javascript">
						alert('<?php echo JText::_( 'GMAPFP_UPLOAD_NOK').' => '.strtolower($file['name']).JText::_( 'GMAPFP_EXIST');?>');
                        window.history.go(-1);
                    </script> <?php
			} else { ?>
					<script type="text/javascript" language="javascript">
						alert('<?php echo JText::_( 'GMAPFP_UPLOAD_OK');?>');
                        window.opener.addphoto("<?php echo strtolower($file['name']);?>", "<?php echo strtolower($file['name']);?>");
						window.opener.changeDisplayImage("<?php echo JURI::base().'..'.$config->get('gmapfp_chemin_img');?>");
                        window.close();
                    </script> <?php
			}
		}
    }
			
}
?>
