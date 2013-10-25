<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.12
	* Creation date: MArs 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die();

class GMapFPsControllerEditLieux extends GMapFPsController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add', 'edit' );
	}

	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'editlieux' );
		JRequest::setVar( 'layout', 'edit_form'  );

		parent::display();
	}

	function soumission()
	{
		JRequest::setVar( 'view', 'editlieux' );
		JRequest::setVar( 'layout', 'soumission'  );

		parent::display();
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$post	= JRequest::get('post');
		$model = $this->getModel('editlieux');
		$returnid=$model->store($post);
		if ($returnid>0) {
			$msg = JText::_( 'GMAPFP_SAVED' );
		} else {
			$msg = JText::_( 'GMAPFP_SAVED_ERROR' );
		}

		$link = JRoute::_('index.php?option=com_gmapfp&view=gestionlieux&controller=gestionlieux&task=view');
		// Check the table in so it can be edited.... we are done with it anyway
		$this->setRedirect($link, $msg);
	}

	/**
	 * soumettre un enregistrement (and redirect to main page)
	 * @return void
	 */
	function submit()
	{
		$post	= JRequest::get('post');
		//die(print_r($post));

		$itemid   =@ $post[itemid];
		$model    = $this->getModel('editlieux');
		$returnid = $model->store($post);
		if ($returnid>0) {
			$msg = JText::_( 'GMAPFP_SUBMIT' );
		} else {
			$msg = JText::_( 'GMAPFP_SUBMIT_ERROR' );
		}

		$link = JRoute::_('index.php?option=com_gmapfp&view=editlieux&layout=soumission&Itemid='.$itemid,false);
		$this->setRedirect($link, $msg);
	}

	/**
	 * save a record (and not redirect to main page)
	 * @return void
	 */
	function apply()
	{
		$post	= JRequest::get('post');
		$model = $this->getModel('editlieux');
		$returnid=$model->store($post);
		if ($returnid>0) {
			$msg = JText::_( 'GMAPFP_SAVED' );
		} else {
			$msg = JText::_( 'GMAPFP_SAVED_ERROR' );
		}

		$link = JRoute::_('index.php?option=com_gmapfp&view=editlieux&layout=edit_form&controller=editlieux&task=edit&cid='.(int)$returnid, false);
		$this->setRedirect($link, $msg);
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( JRoute::_('index.php?option=com_gmapfp&view=gestionlieux&controller=gestionlieux&task=view'), $msg );
	}

	function edit_upload()
	{
		JRequest::setVar( 'view', 'editlieux' );
		JRequest::setVar( 'layout', 'upload_form'  );

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
                        window.opener.addphoto("<?php echo strtolower($file['name']);?>");
						window.opener.changeDisplayImage("<?php echo JURI::base().$config->get('gmapfp_chemin_img');?>");
                        window.close();
                    </script> <?php
			}
		}
    }

}
?>
