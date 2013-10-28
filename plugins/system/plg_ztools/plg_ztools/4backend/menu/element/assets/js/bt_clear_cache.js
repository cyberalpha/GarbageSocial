window.addEvent('load', function(){
	if($('module-status')!=null){
		$('module-status').setStyle('background', 'none');
		var request = {'a':'hong'};
		var span = new Element('span', {'class':'ztools-clearcache', 'style':'background: url(../plugins/system/plg_ztools/plg_ztools/4backend/menu/element/assets/images/zt.png) no-repeat'}).injectTop($('module-status'));
		var bttclear = new Element('a', {
							'href':'javascript:void(0)',
							'events': {
								'click': function(){
									var linkurl = '../index.php?action=clearCache&type=plugin';
									new Request({url: linkurl, method:'post', 
										onSuccess: function(result){
												alert(result);
										}
									}).send();
								}
							} 
						}).inject(span);
		bttclear.set('text', 'ZTools Clean Cache');
	}
});