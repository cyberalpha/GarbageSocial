<?php defined('_JEXEC') or die('Restricted access'); ?>

function lookupGeoData()
{
	myGeoPositionGeoPicker(
	{
		startAddress     : 'Corralejo, Fuerteventura',
		returnFieldMap   :
		{
			'jform_metadata_xreference' : '<LAT>, <LNG>'
		}
	}
	);
}

window.addEvent('domready',function()
{
	var xref_field = document.id('jform_metadata_xreference');
	// If we are on frontend editing, xreference field doesn't exist. Avoid javascript error which block execution of other js
	if (!xref_field) return;

	var picker = new Element('button',{'id':'contentmap_picker','class':'contentmap_picker','type':'button','onclick':'lookupGeoData();','html':'<img src="../media/contentmap/images/map-16.png" />'});
	picker.inject(xref_field,'after');

	document.getElementById('jform_metadata_xreference-lbl').innerHTML = 'ContentMap';
	document.getElementById('jform_metadata_xreference-lbl').title = 'ContentMap';
}
);
