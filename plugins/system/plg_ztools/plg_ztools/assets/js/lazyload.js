/*
# ------------------------------------------------------------------------
# LazyLoad for Joomla 1.7
# ------------------------------------------------------------------------
# Copyright(C) 2008-2011 www.zootemplate.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: ZooTemplate
# Websites: http://www.zootemplate.com
# ------------------------------------------------------------------------
*/

var LazyLoad = new Class({
	
	Implements: [Options,Events],
	
	options: {
		range: 200,
		image: 'blank.gif',
		resetDimensions: true,
		elements: 'img',
		container: window
	},
	
	initialize: function(options) {
		
		this.setOptions(options);
		this.container = $(this.options.container);
		this.elements = $$(this.options.elements);
		this.containerHeight = this.container.getSize().y;
		this.start = 0;
	
		this.elements = this.elements.filter(function(el) {
			if(el.getPosition().y < this.containerHeight + this.options.range) {
				if(el.getProperty('osrc'))
				{
					el.setProperty('src', el.getProperty('osrc'));
					new Fx.Elements(el, {duration:1500, transition: Fx.Transitions.linear}).start({'0':{'opacity' : [0, 1]}});
				}
				return false;
			}
			return true;
		},this);
		
		var action = function() {
			var cpos = this.container.getScroll().y;
			if(cpos > this.start) {
				this.elements = this.elements.filter(function(el) {
					if((this.container.getScrollHeight() + this.options.range + this.containerHeight) >= el.getPosition().y)
					{
						if(el.getProperty('osrc'))
						{
							el.setProperty('src', el.getProperty('osrc'));
							new Fx.Elements(el, {duration:1500, transition: Fx.Transitions.linear}).start({'0':{'opacity' : [0, 1]}});							
						}
						this.fireEvent('load',[el]);
						return false;
					}
					return true;
				}, this);
				this.start = cpos;
			}
			this.fireEvent('scroll');
			
			if(!this.elements.length) {
				this.container.removeEvent('scroll',action);
				this.fireEvent('complete');
			}
		}.bind(this);
		
		this.container.addEvent('scroll',action);
	}
});