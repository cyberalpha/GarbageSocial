/**
 * Main JavaScript file
 *
 * @package         Cache Cleaner
 * @version         3.1.2
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2012 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

var cachecleaner_delay = false;

window.addEvent('domready', function()
{
	document.getElements('a.cachecleaner_cleancache').each(function(el)
	{
		el.addEvent('click', function()
		{
			cachecleaner_load(0);
			return false;
		});
	});

	document.getElements('a.cachecleaner_purgecache').each(function(el)
	{
		el.addEvent('click', function()
		{
			cachecleaner_load('purge');
			return false;
		});
	});


	new Element('span', {
		'id': 'cachecleaner_msg',
		'styles': { 'opacity': 0 }
	}).inject(document.body).addEvent('click', function() { cachecleaner_show_end() });
	cachecleaner_delay = false;
});

var cachecleaner_load = function(task)
{
	var params = 'cleancache=1&break=1';
	if (task == 'purge') {
		params += '&purge=1';
	}
	var d = new Date();
	params += '&time=' + d.toISOString();

	cachecleaner_show_start(task);
	var myXHR = new Request({
		method: 'get',
		url: cachecleaner_base + '/index.php',
		onSuccess: function(data)
		{
			if (data.length > 100) {
				document.getElement('#cachecleaner_msg').addClass('failure').set('html', cachecleaner_msg_inactive);
				cachecleaner_show_end(4000);
			} else {
				if (data.charAt(0) == '+') {
					data = data.substring(1, data.length);
					document.getElement('#cachecleaner_msg').addClass('success');
				} else {
					document.getElement('#cachecleaner_msg').addClass('warning');
				}
				document.getElement('#cachecleaner_msg').set('html', data);
				cachecleaner_show_end(2000);
			}
		},
		onFailure: function()
		{
			document.getElement('#cachecleaner_msg').addClass('failure').set('html', cachecleaner_msg_failure);
			cachecleaner_show_end(2000);
		}
	});
	myXHR.send(params);
};

var cachecleaner_show_start = function(task)
{
	var msg = cachecleaner_msg_clean;
	if (task == 'purge') {
		msg = cachecleaner_msg_purge;
	}

	document.getElement('#cachecleaner_msg')
		.set('html', '<img src="' + cachecleaner_root + 'media/cachecleaner/images/loading.gif" alt=\"\" /> ' + msg)
		.removeClass('success').removeClass('warning').removeClass('failure').addClass('visible');

	clearInterval(cachecleaner_delay);
	document.getElement('#cachecleaner_msg').fade(0.8);
};

var cachecleaner_show_end = function(delay)
{
	if (delay) {
		cachecleaner_delay = ( function() { cachecleaner_show_end(); } ).delay(delay);
	} else {
		clearInterval(cachecleaner_delay);
		document.getElement('#cachecleaner_msg').fade(0);
	}
};
