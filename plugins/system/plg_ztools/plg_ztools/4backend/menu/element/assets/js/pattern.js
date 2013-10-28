// JavaScript Document
var LadyPopup = new Class({
	options: {
		id: 'lady_popup',
		position: ''
	},
	
	initialize: function(el, options) {
		this.element = $(el);
		this.setOptions(options);
		this.layout = $(this.options.id);
		this.OverlayEvents();
		this.element.addEvent('click', function(e) { this.toggle(e); }.bind(this));
		this.hide();
		
		this.doAction();
	},
	
	toggle: function() {
		this[this.visible ? 'hide' : 'show']();
	},
	
	show: function() {		
		this.layout.setStyle('display', 'block');
		this.layout.setStyle('z-index', '9999');
		this.visible = true;
	},
	
	hide: function() {
		this.layout.setStyles({'display': 'none'});
		this.visible = false;
	},
	
	OverlayEvents: function() {
		document.addEvent('click', function() { 
			if(this.visible) this.hide(this.layout); 
		}.bind(this));
		
		[this.element, this.layout].each(function(el) {
			el.addEvents({
				'click': function(e) { new Event(e).stop(); },
				'keyup': function(e) {
					e = new Event(e);
					if(e.key == 'esc' && this.visible) this.hide(this.layout);
				}.bind(this)
			}, this);
		}, this);
	},
	
	doAction: function() {
		var lady = $$("#"+this.options.id+" div");
		lady.each(function(item) {
			item.addEvent('click', function(){
				var old    = this.element.getProperty('class').replace('pattern-active ', '');
				var cclass = item.getProperty('class').replace('lady_item ', '');				
				
				this.element.removeClass(old);
				this.element.addClass(cclass);
				
				$(this.options.position).setProperty('value', cclass);
			}.bind(this));
		}.bind(this));
	}
});
LadyPopup.implement(new Options);
LadyPopup.implement(new Events);