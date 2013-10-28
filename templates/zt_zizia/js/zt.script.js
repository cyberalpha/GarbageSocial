window.addEvent ('load', function() {
	if($('ztbacktotop')) {
		var winScroller = new Fx.Scroll(window);
		$('ztbacktotop').addEvent('click', function(e) {
			e = new Event(e).stop();
			winScroller.toTop();
		});
	}
});