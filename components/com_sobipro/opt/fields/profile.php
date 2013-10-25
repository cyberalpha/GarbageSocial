<?php
/**
 * @version: $Id: profile.php 2679 2012-08-24 07:26:23Z Radek Suski $
 * @package: SobiPro Profile Field Application
 * ===================================================
 * @author
 * Name: Sigrid Suski & Radek Suski, Sigsiu.NET GmbH
 * Email: sobi[at]sigsiu.net
 * Url: http://www.Sigsiu.NET
 * ===================================================
 * @copyright Copyright (C) 2006 - 2012 Sigsiu.NET GmbH (http://www.sigsiu.net). All rights reserved.
 * @license see http://www.gnu.org/licenses/gpl.html GNU/GPL Version 3.
 * You can use, redistribute this file and/or modify it under the terms of the GNU General Public License version 3
 * ===================================================
 * $Date: 2012-08-24 09:26:23 +0200 (Fr, 24 Aug 2012) $
 * $Revision: 2679 $
 * $Author: Radek Suski $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadClass( 'opt.fields.inbox' );
/**
 * @author Radek Suski
 * @version 1.0
 * @created 06-Sep-2011 12:43:13
 */
class SPField_Profile extends SPFieldType implements SPFieldInterface
{
	/**
	 * @var string
	 */
	protected $cssClass = '';
	/**
	 * @var int
	 */
	protected $unameField = 0;
	/**
	 * @var int
	 */
	protected $nameField = 0;
	/**
	 * @var int
	 */
	protected $emailField = 0;
	/**
	 * @var array
	 */
	protected $userGroup = array();
	/**
	 * @var int
	 */
	protected $autoApp = 0;
	/**
	 * @var int
	 */
	protected $minPass = 5;
	/**
	 * @var int
	 */
	protected $width = 30;
	/**
	 * @var bool
	 */
	public $isOutputOnly = 0;
	/**
	 * @var int
	 */
	protected $targetSection = 0;
	/**
	 * @var bool
	 */
	protected $admOutField = 0;

	const defPassCtrlStr = 'PASS_SET';
	/**
	 * @var bool
	 */
	protected $passFullData = false;
	/**
	 * @var array
	 */
	protected $outSections = array();
	/**
	 * @var bool
	 */
	protected $associated = true;
	/**
	 * @var array
	 */
	protected static $switchIO = array( 'entry.edit', 'entry.add', 'entry.save', 'entry.apply', 'entry.clone' );

	private $_uid = 0;

	/**
	 * Returns the parameter list
	 * @return array
	 */
	protected function getAttr()
	{
		$attr = get_class_vars( __CLASS__ );
		return array_keys( $attr );
	}

	public function __construct( &$field )
	{
		parent::__construct( $field );
		SPLang::load( 'SpApp.profile' );
		if ( defined( 'SOBIPRO_ADM' ) && $this->isOutputOnly && in_array( SPRequest::task(), self::$switchIO ) ) {
			$this->isOutputOnly = false;
			$this->admOutField = true;
		}
	}


	protected function admField( $return )
	{
		$selected = $this->getRaw();
		if ( strlen( $selected ) ) {
			try {
				$selected = SPConfig::unserialize( $selected );
				$sid = ( int )$selected[ 'sid' ];
				$author = $selected[ 'author' ];
			} catch ( SPException $x ) {
			}
		}
		else {
			$sid = 0;
			$author = Sobi::Txt( 'AFP_OVERRIDE_AUTHOR_TYPE' );
		}
		$jQUiTheme = Sobi::Cfg( 'jquery.ui_theme', 'smoothness.smoothness' );
		$settings = array(
			'input' => $author,
			'section' => $this->targetSection
		);
		SPFactory::header()
				->addJsFile( array( 'jquery', 'jquery-ui' ) )
				->addJsFile( 'profile_adm', true )
				->addJsCode( 'var spProfileAutocomplete = ' . json_encode( $settings ) . ';' )
				->addCssFile( array( 'jquery-ui.' . $jQUiTheme ) );
		$params = array( 'id' => $this->nid . '_author', 'size' => $this->width, 'class' => 'inputbox spProfileAutocomplete', 'autocomplete' => 'off' );
		$field = SPHtml_Input::text( $this->nid . '_author', $author, $params );
		$field .= SPHtml_Input::text( $this->nid . '_author_sid', $sid, array( 'id' => $this->nid . '_author_sid', 'size' => 5, 'class' => 'inputbox spCfgNumberSelectList', 'readonly' => 'readonly' ) );
		if ( !$return ) {
			echo $field;
		}
		else {
			return $field;
		}
	}

	/**
	 * Shows the field in the edit entry or add entry form
	 * @param bool $return return or display directly
	 * @return string
	 */
	public function field( $return = false )
	{
		if ( $this->admOutField ) {
			return $this->admField( $return );
		}
		/**
		 * check if editing - if no - check if not already exist
		 */
		$uid = Sobi::My( 'id' );
		if ( SPRequest::task() == 'entry.add' && $uid && !( defined( 'SOBIPRO_ADM' ) ) ) {
			$sid = SPFactory::db()
					->select( 'sid', 'spdb_field_data', array( 'fid' => $this->id, 'section' => Sobi::Section(), 'createdBy' => Sobi::My( 'id' ) ) )
					->loadResult();
			if ( $sid ) {
				Sobi::Redirect( Sobi::Url( array( 'task' => 'entry.edit', 'sid' => $sid ) ), Sobi::Txt( 'AFP_NO_MULTI_PROFILE_ALLOWED' ), SPC::ERROR_MSG );
			}
		}
		$class = $this->required ? $this->cssClass . ' required' : $this->cssClass;
		$selected = $this->getRaw();
		$noUserMode = false;
		if ( strlen( $selected ) ) {
			try {
				$selected = SPConfig::unserialize( $selected );
				$uid = ( int )$selected[ 'uid' ];
				$noUserMode = isset( $selected[ 'nouser' ] ) ? $selected[ 'nouser' ] : false;
			} catch ( SPException $x ) {
			}
		}
		else {
			$selected = null;
		}
		$this->minPass = $this->minPass ? $this->minPass : 1;
		// create params for the JavaScript file
		$entry = SPFactory::Model( 'entry' );
		$entry->loadFields( Sobi::Section() );
		$params = array();
		$params[ 'REQUEST_URL' ] = Sobi::Url( array( 'task' => 'profile.check', 'out' => 'json' ), true, false, true );
		$params[ 'FIELD_EMAIL' ] = $entry->getField( ( int )$this->emailField )->get( 'nid' );
		if ( $entry->getField( ( int )$this->emailField )->get( 'type' ) == 'email' ) {
			$params[ 'FIELD_EMAIL' ] .= '_url';
		}
		$params[ 'FIELD_UNAME' ] = $entry->getField( ( int )$this->unameField )->get( 'nid' );
		$params[ 'PASS_LENGTH' ] = ( int )$this->minPass;
		$params[ 'PASS' ] = $this->nid;
		$params[ 'TS_MSG' ] = Sobi::Txt( 'AFP_PASS_TOO_SHORT' );
		$params[ 'NM_MSG' ] = Sobi::Txt( 'AFP_PASS_NOT_IDENT' );
		$jQUiTheme = Sobi::Cfg( 'jquery.ui_theme', 'smoothness.smoothness' );
		$this->set( 'label', null );
		SPFactory::header()
				->addJsFile( array( 'jquery', 'profile', 'jquery-ui' ) )
				->addJsVarFile( 'profile_settings', md5( serialize( $params ) . ' ' ), $params )
				->addCssFile( array( 'jquery-ui.' . $jQUiTheme ) )
				->addJsCode( 'var SpProUid = ' . $uid . ';' );

		if ( $selected ) {
			$selected = self::defPassCtrlStr;
		}
		else {
			$selected = '';
		}
		$msgCont = "
			<div style=\"display:none;\">
				<div class=\"ui-state-error ui-corner-all\" id=\"{$this->nid}_msg\" style=\"font-size:14px; min-height:60px;\">
					<span class=\"ui-icon ui-icon-alert\" style=\"float: left; margin-right: .7em;\"></span>
				</div>
			</div>";
		$params = array( 'id' => $this->nid, 'size' => $this->width, 'class' => $class, 'autocomplete' => 'off' );
		$field = SPHtml_Input::text( $this->nid, $selected, $params );
		$field = str_replace( 'type="text"', 'type="password"', $field );

		$params = array( 'id' => $this->nid . '_repeat', 'size' => $this->width, 'class' => $class, 'autocomplete' => 'off' );
		$field2 = SPHtml_Input::text( $this->nid . '_repeat', $selected, $params );
		$field2 = str_replace( 'type="text"', 'type="password"', $field2 );

		$label = Sobi::Txt( 'AFP_IN_PASS' );
		$label = '<div>' . $label . '</div>';

		$label2 = Sobi::Txt( 'AFP_REPEAT_PASS' );
		$label2 = '<div>' . $label2 . '</div>';

		if ( defined( 'SOBIPRO_ADM' ) ) {
			// special case - do not create user
			$params = array( 'id' => $this->nid . '_skip', 'class' => 'required' );
			$field3 = SPHtml_Input::states( $this->nid . '_skip', $noUserMode, $this->nid . '_skip', 'yes_no' );
			$label3 = Sobi::Txt( 'AFP_SKIP_CREATION' );
			$label3 = '<div style="float:left; margin-right:5px;">' . $label3 . '</div>';
			$field = '<div style="margin:5px">' . $label3 . $field3 . '</div>' . $label . $field . $label2 . $field2 . $msgCont;
		}
		else {
			$field = $label . $field . $label2 . $field2 . $msgCont;
		}
		if ( !$return ) {
			echo $field;
		}
		else {
			return $field;
		}
	}

	/**
	 * @param SPEntry $entry
	 * @param string $request
	 * @return string
	 */
	private function verify( $entry, $request )
	{
		$pass = SPRequest::search( $this->nid );
		$userData = array();
		$userData[ 'userName' ] = trim( $entry->getField( ( int )$this->nameField )->getRaw() );
		$userData[ 'uName' ] = $entry->getField( ( int )$this->unameField )->getRaw();
		$userData[ 'email' ] = $entry->getField( ( int )$this->emailField )->getRaw();
		$userData[ 'pass' ] = $pass[ $this->nid ];
		$userData[ 'nouser' ] = false;
		if ( is_array( $userData[ 'email' ] ) && isset( $userData[ 'email' ][ 'url' ] ) ) {
			$userData[ 'email' ] = $userData[ 'email' ][ 'url' ];
		}
		if ( $pass[ $this->nid ] != self::defPassCtrlStr && $pass[ $this->nid ] != $pass[ $this->nid . '_repeat' ] ) {
			throw new SPException( SPLang::e( 'AFP_PASS_NOT_IDENT' ) );
		}
		array_walk( $userData, 'trim' );
		/**
		 * @todo check pass
		 * @todo check if user/mail exist
		 */
		$data = SPRequest::raw( $this->nid, null, $request );
		$dexs = strlen( $data );
		/* check if it was required */
		if ( $this->required && !( $dexs ) ) {
			throw new SPException( SPLang::e( 'FIELD_REQUIRED_ERR', $this->name ) );
		}

		if ( $dexs < $this->minPass ) {
			throw new SPException( SPLang::e( 'AFP_PASS_TOO_SHORT' ) );
		}

		/* check if there was an adminField */
		if ( $this->adminField && $dexs ) {
			if ( !( Sobi:: Can( 'entry.adm_fields.edit' ) ) ) {
				throw new SPException( SPLang::e( 'FIELD_NOT_AUTH', $this->name ) );
			}
		}

		/* check if it was free */
		if ( !( $this->isFree ) && $this->fee && $dexs ) {
			SPFactory::payment()->add( $this->fee, $this->name, $entry->get( 'id' ), $this->fid );
		}

		/* check if it was editLimit */
		if ( $this->editLimit == 0 && !( Sobi::Can( 'entry.adm_fields.edit' ) ) && $dexs ) {
			throw new SPException( SPLang::e( 'FIELD_NOT_AUTH_EXP', $this->name ) );
		}
		/* check if it was editable */
		if ( !( $this->editable ) && !( Sobi::Can( 'entry.adm_fields.edit' ) ) && $dexs && $entry->get( 'version' ) > 1 ) {
			throw new SPException( SPLang::e( 'FIELD_NOT_AUTH_NOT_ED', $this->name ) );
		}
		if ( !( $dexs ) ) {
			$data = null;
		}
		$this->setData( $data );
		return $userData;
	}


	/**
	 * Gets the data for a field and save it in the database
	 * @param SPEntry $entry
	 * @return bool
	 */
	public function saveData( &$entry, $request = 'POST' )
	{
		if ( !( $this->enabled ) ) {
			return false;
		}
		$skipCreation = false;
		$uid = 0;
		if ( $this->isOutputOnly || $this->admOutField ) {
			// this is only in case that the author is being overwritten manually
			// if there was no data - just leave here
			// these data can be completed when the data is being displayed in the details view
			$userData = $this->saveAuthor();
			if ( !( $userData ) ) {
				return true;
			}
		}
		else {
			// in administrator area (atm) administrator can skip user creation
			$skipCreation = SPRequest::bool( $this->nid . '_skip' );
			$selected = $this->getRaw();
			if ( strlen( $selected ) ) {
				try {
					$selected = SPConfig::unserialize( $this->getRaw() );
					$uid = ( int )$selected[ 'uid' ];
				} catch ( SPException $x ) {
				}
			}
			// if first entry but we are not in administrator area
			elseif ( $entry->get( 'version' ) == 1 && !( defined( 'SOBIPRO_ADM' ) ) ) {
				$uid = Sobi::My( 'id' );
			}
			// otherwise we are in administrator area but the owner of the entry has been assigned so this is the user
			elseif ( defined( 'SOBIPRO_ADM' ) && $entry->get( 'owner' ) && $entry->get( 'owner' ) != Sobi::My( 'id' ) ) {
				$uid = $entry->get( 'owner' );
			}
			// otherwise we are probably going to create new user
			else {
				$uid = 0;
			}
			if ( !( $skipCreation ) ) {
				$userData = $this->verify( $entry, $request );
			}
			else {
				$userData = array( 'nouser' => true, 'uid' => Sobi::My( 'id' ) );
			}
			$db =& SPFactory::db();
			if ( !( $skipCreation ) ) {
				if ( !( $uid ) ) {
					$this->createNewUser( $userData, $uid, ( int )( $entry->get( 'approved' ) || $this->autoApp ) );
					$entry->set( 'owner', $uid );
					$db->update( 'spdb_object', array( 'owner' => $uid ), array( 'id' => $entry->get( 'id' ) ) );
				}
				else {
					$this->updateUser( $userData, $uid );
				}
			}
		}
		$this->storeData( $userData, $entry, $uid, $skipCreation );
	}

	protected function storeData( $userData, &$entry, $uid = 0, $skipCreation = false )
	{
		$db = SPFactory::db();
		$time = SPRequest::now();
		$IP = SPRequest::ip( 'REMOTE_ADDR', 0, 'SERVER' );
		$userData[ 'checksum' ] = md5( serialize( $userData ) );
		/* collect the needed params */
		$params = array();
		$params[ 'publishUp' ] = $entry->get( 'publishUp' );
		$params[ 'publishDown' ] = $entry->get( 'publishDown' );
		$params[ 'fid' ] = $this->fid;
		$params[ 'sid' ] = $entry->get( 'id' );
		$params[ 'section' ] = Sobi::Reg( 'current_section' );
		$params[ 'lang' ] = Sobi::Lang();
		$params[ 'enabled' ] = ( int )$entry->get( 'state' );
		$params[ 'params' ] = null;
		$params[ 'options' ] = isset( $userData[ 'sid' ] ) ? $userData[ 'sid' ] : '';
		$params[ 'baseData' ] = $db->escape( SPConfig::serialize( $userData ) );
		$params[ 'approved' ] = ( int )$entry->get( 'approved' );
		$params[ 'confirmed' ] = ( int )$entry->get( 'confirmed' );
		/* if it is the first version, it is new entry */
		if ( $entry->get( 'version' ) == 1 ) {
			$params[ 'createdTime' ] = $time;
			$params[ 'createdIP' ] = $IP;
			$params[ 'createdBy' ] = $uid;
		}
		if ( $skipCreation == 1 ) {
			$params[ 'createdBy' ] = 0;
		}
		$params[ 'updatedTime' ] = $time;
		$params[ 'updatedBy' ] = Sobi::My( 'id' );
		$params[ 'updatedIP' ] = $IP;
		$params[ 'copy' ] = ( int )!( $entry->get( 'approved' ) );
		if ( Sobi::My( 'id' ) == $entry->get( 'owner' ) ) {
			--$this->editLimit;
		}
		if ( isset( $userData[ 'associated' ] ) && $userData[ 'associated' ] ) {
			$params[ 'createdBy' ] = $userData[ 'associated' ];
			$params[ 'options' ] = '';
		}
		elseif ( isset( $userData[ 'uid' ] ) && $userData[ 'uid' ] ) {
			$params[ 'createdBy' ] = $userData[ 'uid' ];
		}
		$params[ 'editLimit' ] = $this->editLimit;

		/* save it */
		try {
			$db->insertUpdate( 'spdb_field_data', $params );
		} catch ( SPException $x ) {
			Sobi::Error( __CLASS__, SPLang::e( 'CANNOT_SAVE_DATA', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
		}
	}

	protected function saveAuthor()
	{
		if ( SPRequest::int( $this->nid . '_author_sid' ) ) {
			$selected = array();
			$selected[ 'sid' ] = SPRequest::int( $this->nid . '_author_sid' );
			$selected[ 'author' ] = SPRequest::string( $this->nid . '_author' );
			$user = SPFactory::Entry( $selected[ 'sid' ] );
			$master = SPFactory::db()
					->select( 'nid', 'spdb_field', array( 'fieldType' => 'profile', 'section' => $this->targetSection ) )
					->loadResult();
			try {
				$master = SPConfig::unserialize( $user->getField( $master )->getRaw() );
			} catch ( SPException $x ) {
			}
			if ( !( isset( $master[ 'nouser' ] ) ) ) {
				$selected[ 'associated' ] = $master[ 'uid' ];
			}
			else {
				$selected[ 'associated' ] = 0;
			}
			return $selected;
		}
		else {
			return false;
		}
	}

	private function updateUser( &$data, $uid )
	{
		$selected = $this->data();
		if ( strlen( $selected ) ) {
			$selected = SPConfig::unserialize( $selected );
			$uid = ( int )$selected[ 'uid' ];
			/**
			 * Check data - if checksum is not changed - nothing to update
			 */
			if ( md5( serialize( $data ) ) == $selected[ 'checksum' ] ) {
				return true;
			}
		}
		$id = SPFactory::db()->select( 'id', '#__users', array( 'username' => $data[ 'uName' ], '!id' => $uid ) )->loadResult();
		if ( $id > 0 ) {
			throw new SPException( SPLang::e( 'AFP_USERNAME_EXIST' ) );
		}
		$id = SPFactory::db()->select( 'id', '#__users', array( 'email' => $data[ 'email' ], '!id' => $uid ) )->loadResult();
		if ( $id > 0 ) {
			throw new SPException( SPLang::e( 'AFP_EMAIL_EXIST' ) );
		}
		$user = JUser::getInstance( ( int )$uid );
		//		if( SOBI_CMS == 'joomla15' ) {
		//			$user->set( 'usertype', 'Registered' );
		//			$user->set( 'gid', JFactory::getACL()->get_group_id( '', 'Registered', 'ARO' ) );
		//		}
		if ( SOBI_CMS != 'joomla15' ) {
			$groups = array_merge( $this->userGroup, $user->get( 'groups' ) );
			$user->set( 'groups', $groups );
		}
		// if password has been changed
		if ( $data[ 'pass' ] != self::defPassCtrlStr ) {
			$data[ 'password' ] = $data[ 'password2' ] = $data[ 'pass' ];
			$user->bind( $data );
		}
		$user->set( 'name', $data[ 'userName' ] );
		$user->set( 'username', $data[ 'uName' ] );
		$user->set( 'email', $data[ 'email' ] );

		if ( !$user->save() ) {
			throw new SPException( JText::_( $user->getError() ) );
		}
		$data[ 'uid' ] = $uid;
		$data[ 'pass' ] = sha1( md5( $user->get( 'password' ) ) );
		$data[ 'groups' ] = $user->get( 'groups' );
		unset( $data[ 'password2' ] );
	}

	private function createNewUser( &$data, &$uid, $active )
	{
		// should be cought already in the form - but in case it wasn't
		$id = SPFactory::db()->select( 'id', '#__users', array( 'username' => $data[ 'uName' ] ) )->loadResult();
		if ( $id > 0 ) {
			throw new SPException( SPLang::e( 'AFP_USERNAME_EXIST' ) );
		}
		$id = SPFactory::db()->select( 'id', '#__users', array( 'email' => $data[ 'email' ] ) )->loadResult();
		if ( $id > 0 ) {
			throw new SPException( SPLang::e( 'AFP_EMAIL_EXIST' ) );
		}
		$user = clone( JFactory::getUser() );
		$user->set( 'id', 0 );
		if ( SOBI_CMS == 'joomla15' ) {
			$user->set( 'usertype', 'Registered' );
			$user->set( 'gid', JFactory::getACL()->get_group_id( '', 'Registered', 'ARO' ) );
		}
		else {
			$user->set( 'groups', $this->userGroup );
		}
		$data[ 'password' ] = $data[ 'password2' ] = $data[ 'pass' ];
		$user->bind( $data );
		$user->set( 'name', $data[ 'userName' ] );
		$user->set( 'username', $data[ 'uName' ] );
		$user->set( 'email', $data[ 'email' ] );
		$user->set( 'activation', !( $active ) );
		$user->set( 'block', !( $active ) );
		$user->set( 'registerDate', JFactory::getDate()->toMySQL() );

		if ( !$user->save() ) {
			throw new SPException( JText::_( $user->getError() ) );
		}
		$this->_uid = $user->get( 'id' );
		$data[ 'uid' ] = $this->_uid;
		$data[ 'pass' ] = sha1( md5( $user->get( 'password' ) ) );
		$data[ 'groups' ] = $user->get( 'groups' );
		unset( $data[ 'password2' ] );
	}

	public function approve( $sid )
	{
		if ( !( $this->isOutputOnly ) ) {
			parent::approve( $sid );
			$data = $this->data();
			if ( strlen( $data ) ) {
				$data = SPConfig::unserialize( $data );
			}
			/**
			 * this is in case of auto-approve when existing user is creating an entry
			 * The field is not fully initialised so there is no data yet
			 * But in this case the user is for sure logged in
			 */
			elseif ( Sobi::My( 'id' ) ) {
				return true;
			}
			elseif ( $this->_uid ) {
				$data = array( 'uid' => $this->_uid );
			}
			else {
				// @todo huston .....
				throw new SPException( 'Something went terribly wrong :( ' . basename( __FILE__ ) . ':' . __LINE__ );
			}
			$user = JUser::getInstance( ( int )$data[ 'uid' ] );
			//$user->load( $data[ 'uid' ] );
			$user->set( 'activation', 0 );
			$user->set( 'block', 0 );
			$user->save();
		}
	}

	private function sendActivationLink()
	{
	}

	public function provide( $action )
	{
		return $action == 'EntryViewDetails';
	}

	public function EntryViewDetails( &$attr )
	{
		SPLoader::loadClass( 'mlo.profile_helper' );
		SPProfile::Entries( $attr, $this->associated, $this->outSections );
	}

	/**
	 * @return bool
	 */
	public function searchString( $data, $section )
	{
		return true;
	}

	public function searchData( $request, $section )
	{
		return true;
	}

	public function submit( &$entry, $tsid = null, $request = 'POST' )
	{
		return true;
	}

	public function searchForm( $return = false )
	{
		return true;
	}

	protected function determineAuthor( $entry )
	{
		$author = $entry->get( 'owner' );
		$sid = 0;
		// determine field id
		$fid = SPFactory::db()
				->select( 'fid', 'spdb_field', array( 'fieldType' => 'profile', 'section' => $this->targetSection ) )
				->loadResult();
		if ( $author && $fid ) {
			// determine entry id
			$sid = SPFactory::db()
					->select( 'sid', 'spdb_field_data', array( 'fid' => $fid, 'section' => $this->targetSection, 'createdBy' => $author ) )
					->loadResult();
		}
		return $sid;
	}

	/**
	 * @return array
	 */
	public function struct()
	{
		// this is the output in the members section
		if ( !( $this->isOutputOnly ) ) {
			$selected = $this->getRaw();
			$this->associated = 1;
			if ( strlen( $selected ) ) {
				try {
					$selected = SPConfig::unserialize( $this->getRaw() );
					if ( isset( $selected[ 'nouser' ] ) && $selected[ 'nouser' ] ) {
						$this->associated = 0;
					}
				} catch ( SPException $x ) {
				}
			}
			Sobi::RegisterHandler( 'entry.details', $this );
			return array(
				'_complex' => 1,
				'_data' => null,
				'_attributes' => array( 'associated' => $this->associated )
			);
		}
		// this is output for the non-members sections
		$selected = $this->getRaw();
		if ( strlen( $selected ) ) {
			try {
				$selected = SPConfig::unserialize( $selected );
				$sid = ( int )$selected[ 'sid' ];
			} catch ( SPException $x ) {
			}
		}
		else {
			$entry = SPFactory::Entry( $this->sid );
			$sid = $this->determineAuthor( $entry );
		}
		if ( $sid ) {
			$options = array();
			$user = SPFactory::Entry( $sid );
			if ( isset( $entry ) ) {
				//                $master = SPFactory::db()
				//                        ->select( 'nid', 'spdb_field', array( 'fieldType' => 'profile', 'section' => $this->targetSection ) )
				//                        ->loadResult();
				//                try {
				//                    $master = SPConfig::unserialize( $user->getField( $master )->getRaw() );
				//                } catch ( SPException $x ) {SPConfig::debOut($x->getMessage());}
				$this->storeData( array( 'sid' => $sid, 'author' => $user->get( 'name' ) ), $entry, $user->get( 'owner' ) );
			}
			if ( $user->get( 'name' ) ) {
				$this->cssClass = $this->cssClass . ' ' . $this->nid;
				$this->cleanCss();
				$attributes = array( 'href' => $user->get( 'url' ), 'class' => $this->cssClass );
				$data = array(
					'_complex' => 1,
					'_data' => SPLang::clean( $user->get( 'name' ) ),
					'_attributes' => $attributes
				);
				if ( $this->passFullData ) {
					$options = SPFactory::view( 'profile' )->parseEntry( $sid );
				}
				return array(
					'_complex' => 1,
					'_data' => array( 'a' => $data ),
					'_options' => $options,
				);
			}
		}
	}
}
