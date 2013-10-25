 /**
 * @version: $Id: tree.js 904 2011-03-02 20:15:56Z Radek Suski $
 * @package: SobiPro Library
 * ===================================================
 * @author
 * Name: Sigrid Suski & Radek Suski, Sigsiu.NET GmbH
 * Email: sobi[at]sigsiu.net
 * Url: http://www.Sigsiu.NET
 * ===================================================
 * @copyright Copyright (C) 2006 - 2011 Sigsiu.NET GmbH (http://www.sigsiu.net). All rights reserved.
 * @license see http://www.gnu.org/licenses/lgpl.html GNU/LGPL Version 3.
 * You can use, redistribute this file and/or modify it under the terms of the GNU Lesser General Public License version 3
 * ===================================================
 * $Date: 2011-03-02 21:15:56 +0100 (Wed, 02 Mar 2011) $
 * $Revision: 904 $
 * $Author: Radek Suski $
 * File location: components/com_sobipro/lib/js/tree.js $
 */
 // Created at Thu Jan 17 23:14:36 ART 2013 by Sobi Pro Component

var sobiCats_stmcid = 0;
var sobiCats_stmLastNode = 147;
var sobiCats_stmImgs = new Array();
var sobiCats_stmImgMatrix = new Array();
var sobiCats_stmParents = new Array();
var sobiCats_stmSemaphor = 0;
var sobiCats_stmPid = 0;
var sobiCats_stmWait = 'http://localhost/SocialGarbage/media/sobipro/styles/spinner.gif';

sobiCats_stmImgs[ 'root' ] = 'http://localhost/SocialGarbage/media/sobipro/tree/base.gif';
sobiCats_stmImgs[ 'join' ] = 'http://localhost/SocialGarbage/media/sobipro/tree/join.gif';
sobiCats_stmImgs[ 'joinBottom' ] = 'http://localhost/SocialGarbage/media/sobipro/tree/joinbottom.gif';
sobiCats_stmImgs[ 'plus' ] = 'http://localhost/SocialGarbage/media/sobipro/tree/plus.gif';
sobiCats_stmImgs[ 'plusBottom' ] = 'http://localhost/SocialGarbage/media/sobipro/tree/plusbottom.gif';
sobiCats_stmImgs[ 'minus' ] = 'http://localhost/SocialGarbage/media/sobipro/tree/minus.gif';
sobiCats_stmImgs[ 'minusBottom' ] = 'http://localhost/SocialGarbage/media/sobipro/tree/minusbottom.gif';
sobiCats_stmImgs[ 'folder' ] = 'http://localhost/SocialGarbage/media/sobipro/tree/folder.gif';
sobiCats_stmImgs[ 'disabled' ] = 'http://localhost/SocialGarbage/media/sobipro/tree/disabled.gif';
sobiCats_stmImgs[ 'folderOpen' ] = 'http://localhost/SocialGarbage/media/sobipro/tree/folderopen.gif';
sobiCats_stmImgs[ 'line' ] = 'http://localhost/SocialGarbage/media/sobipro/tree/line.gif';
sobiCats_stmImgs[ 'empty' ] = 'http://localhost/SocialGarbage/media/sobipro/tree/empty.gif';;

sobiCats_stmImgMatrix[ 149 ] = new Array( 'joinBottom' );
sobiCats_stmImgMatrix[ 150 ] = new Array( 'joinBottom' );
sobiCats_stmImgMatrix[ 148 ] = new Array( 'joinBottom' );
sobiCats_stmImgMatrix[ 147 ] = new Array( 'join' );;
//__PARENT_ARR__

function sobiCats_stmExpand( catid, deep, pid ) 
{
	try { SP_id( "sobiCats_imgFolder" + catid ).src = sobiCats_stmWait; } catch( e ) {}	
	sobiCats_stmcid = catid;
	sobiCats_stmPid = pid;
	url = "index.php?option=com_sobipro&task=category.chooser&sid=146&out=xml&expand=" + sobiCats_stmcid + "&pid=" + sobiCats_stmPid + "&tmpl=component&format=raw";
	sobiCats_stmMakeRequest( url, deep, catid );	
}

function sobiCats_stmCatData( node, val )
{
	return node.getElementsByTagName( val ).item( 0 ).firstChild.data;
}

function sobiCats_stmAddSubcats( XMLDoc, deep, ccatid ) 
{
	var categories = XMLDoc.getElementsByTagName( 'category' );
	var subcats = "";
	deep++;
	for( i = 0; i < categories.length; i++ ) {
		var category 	= categories[ i ];
		var catid 		= sobiCats_stmCatData( category, 'catid' );
		var name 		= sobiCats_stmCatData( category, 'name' );
		var introtext 	= sobiCats_stmCatData( category, 'introtext' );
		var parentid 	= sobiCats_stmCatData( category, 'parentid' );
		var url 		= sobiCats_stmCatData( category, 'url' );
		var childs 		= sobiCats_stmCatData( category, 'childs' );
		var join 		= "<img src='" + sobiCats_stmImgs['join'] + "' alt=''/>";
		var margin 		= "";
		var childContainer = "";		
		name 			= name.replace( "\\", "" );
		introtext 		= introtext.replace( "\\", "" );
		url 			= url.replace( "\\\\", "" );
		
		for( j = 0; j < deep; j++ ) {
			if( sobiCats_stmImgMatrix[ parentid ][ j ] ) {
				switch( sobiCats_stmImgMatrix[ parentid ][ j ] ) 
				{
					case 'plus':
					case 'minus':
					case 'line':
						image = 'line';
						break;
					default:
						image = 'empty';
						break;
				}
			}
			else {
				image = 'empty';
			}
			if( !sobiCats_stmImgMatrix[ catid ] ) {
				catArray = new Array();
				catArray[ j ]  = image;
				sobiCats_stmImgMatrix[ catid ] = catArray;
			}
			else {
				sobiCats_stmImgMatrix[ catid ][ j ] = image;
			}
			margin = margin + "<img src='"+ sobiCats_stmImgs[ image ] +"' style='border-style:none;' alt=''/>";
		}
		if( childs > 0 ) {
			join = "<a href='javascript:sobiCats_stmExpand( " + catid + ", " + deep + ", " + sobiCats_stmPid + " );' id='sobiCats_imgUrlExpand" + catid + "'><img src='"+ sobiCats_stmImgs['plus'] + "' id='sobiCats_imgExpand" + catid + "'  style='border-style:none;' alt='expand'/></a>";
			sobiCats_stmImgMatrix[catid][j] = 'plus';
		}
		if( sobiCats_stmcid == sobiCats_stmLastNode ) {
			line = "<img src='"+sobiCats_stmImgs['empty']+"' alt=''>";
		}
		if( i == categories.length - 1 ) {
			if( childs > 0 ) {
				join = "<a href='javascript:sobiCats_stmExpand( " + catid + ", " + deep + ", " + sobiCats_stmPid + " );' id='sobiCats_imgUrlExpand" + catid + "'><img src='"+ sobiCats_stmImgs[ 'plusBottom' ] + "' id='sobiCats_imgExpand" + catid + "'  style='border-style:none;' alt='expand'/></a>";
				sobiCats_stmImgMatrix[ catid ][ j ] = 'plusBottom';
			}
			else {
				join = "<img src='" + sobiCats_stmImgs[ 'joinBottom' ] + "' style='border-style:none;' alt=''/>";
				sobiCats_stmImgMatrix[ catid ][ j ] = 'joinBottom';
			}
		}
		subcats = subcats + "<div class='sigsiuTreeNode' id='sobiCatsstNode" + catid + "'>" + margin  + join + "<a id='sobiCats" + catid + "' href=\"" + url + "\"><img src='" + sobiCats_stmImgs[ 'folder' ] + "' id='sobiCats_imgFolder" + catid + "' alt=''></a><a class = 'treeNode' id='sobiCats_CatUrl" + catid + "' href=\"" + url + "\">" + name + "</a></div>";
		if( childs > 0 ) {
			subcats = subcats + "<div class='clip' id='sobiCats_childsContainer" + catid + "' style='display: block;  display:none;'></div>"
		}
	}
	var childsCont = "sobiCats_childsContainer" + ccatid;
	SP_id( childsCont ).innerHTML = subcats;
}

function sobiCats_stmMakeRequest( url, deep, catid ) 
{
	var sobiCats_stmHttpRequest;
    if ( window.XMLHttpRequest ) {
        sobiCats_stmHttpRequest = new XMLHttpRequest();
        if ( sobiCats_stmHttpRequest.overrideMimeType ) {
            sobiCats_stmHttpRequest.overrideMimeType( 'text/xml' );
        }
    }
    else if ( window.ActiveXObject ) {
        try { sobiCats_stmHttpRequest = new ActiveXObject( "Msxml2.XMLHTTP" ); }
        catch ( e ) { try { sobiCats_stmHttpRequest = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) {} }
    }
    if ( !sobiCats_stmHttpRequest ) {
//        alert( 'AJAX_FAIL' );
        return false;
    }
    sobiCats_stmHttpRequest.onreadystatechange = function() { sobiCats_stmGetSubcats( sobiCats_stmHttpRequest,deep,catid ); };
    sobiCats_stmHttpRequest.open( 'GET', url, true );
    sobiCats_stmHttpRequest.send( null );
}
function sobiCats_stmGetSubcats( sobiCats_stmHttpRequest, deep, catid ) 
{
	if ( sobiCats_stmHttpRequest.readyState == 4 ) {
		if ( sobiCats_stmHttpRequest.status == 200 ) {
			if( SP_id( "sobiCats_imgFolder" + catid )  == undefined ) {
				window.setTimeout( function() { sobiCats_stmGetSubcats( sobiCats_stmHttpRequest, deep, catid ); } , 200 );
			}
			else {
				SP_id( "sobiCats_imgFolder" + catid ).src = sobiCats_stmImgs[ 'folderOpen' ];
	        	 if ( sobiCats_stmcid == sobiCats_stmLastNode ) {
	        	 	SP_id( "sobiCats_imgExpand" + catid ).src = sobiCats_stmImgs[ 'minusBottom' ];
	        	 }
	        	 else {
	        		 if( SP_id( "sobiCats_imgExpand" + catid ).src == sobiCats_stmImgs[ 'plusBottom' ] ) {
	        			 SP_id( "sobiCats_imgExpand" + catid ).src = sobiCats_stmImgs[ 'minusBottom' ];
	        		 }
	        		 else {
	        			 SP_id( "sobiCats_imgExpand" + catid ).src = sobiCats_stmImgs[ 'minus' ];
	        		 }
	        	 }
	        	 SP_id( "sobiCats_imgUrlExpand" + catid ).href = "javascript:sobiCats_stmColapse( " + catid + ", " + deep + " );";
	        	 SP_id( "sobiCats_childsContainer" + catid ).style.display = "";
	        	 sobiCats_stmAddSubcats( sobiCats_stmHttpRequest.responseXML, deep, catid );
			}
        }
        else {
//            SobiPro.Alert( 'AJAX_FAIL' );
        }
    }
}
function sobiCats_stmColapse( id, deep ) 
{
	SP_id( "sobiCats_childsContainer" + id ).style.display = "none";
	SP_id( "sobiCats_imgFolder" + id ).src = sobiCats_stmImgs[ 'folder' ];
	if( id == sobiCats_stmLastNode ) {
		SP_id( "sobiCats_imgExpand" + id ).src = sobiCats_stmImgs[ 'plusBottom' ];
	}
   	else if(SP_id( "sobiCats_imgExpand" + sobiCats_stmcid ).src == sobiCats_stmImgs[ 'minusBottom' ] ){
	 	SP_id( "sobiCats_imgExpand" + sobiCats_stmcid ).src = sobiCats_stmImgs[ 'plusBottom' ];
	}
	else {
		SP_id( "sobiCats_imgExpand" + id ).src = sobiCats_stmImgs[ 'plus' ];
	}
	SP_id( "sobiCats_imgUrlExpand" + id ).href = "javascript:sobiCats_stmExpand( " + id + ", " + deep + ", " + sobiCats_stmPid + " );";
}