var ZTFancy = new Class({
	Implements: Options,
	initialize: function(menu, options){
		this.setOptions(this.getOptions(), options);
		this.menu = $(menu), this.current = this.menu.getElement('li[class$=active]');
		this.menu.getElements('li').each(function(item){
			if(item.getProperty('class').split(' ')[0] != 'mega-li')
			{
				item.addEvent('mouseover', function(){this.moveBg(item);}.bind(this));
				item.addEvent('mouseout', function(){this.moveBg(this.current);}.bind(this));
			}
		}.bind(this));
		this.wback = 0;
		this.back = new Element('li').addClass('fancy').adopt(new Element('div').addClass('fancy-center').adopt(new Element('div').addClass('fancy-left')).adopt(new Element('div').addClass('fancy-right'))).injectInside(this.menu);
		this.back.fx 	= new Fx.Morph(this.back, this.options);
		if(this.current) this.setCurrent(this.current);
	},

	setCurrent: function(el, effect){
		xPos 	= el.offsetLeft;
		wPos	= el.offsetWidth;
		tempEl 	= el.offsetParent;
		while(tempEl != null) {
			xPos 	+= tempEl.offsetLeft;
			tempEl 	 = tempEl.offsetParent;
		}
		this.back.setStyles({left: (xPos)+'px', width: (wPos)+'px'});
		(effect) ? this.back.fx = new Fx.Morph(this.back, this.options).set({'opacity': [0, 1]}) : this.back.fx.set({'opacity': 1});
		this.current = el;
	},

	getOptions: function(){
		return {
			transition: Fx.Transitions.sineInOut,
			duration: 500, wait: false,
			xOffset:0,
			onClick: Class.empty
		};
	},

	clickItem: function(event, item) {
		if(!this.current) this.setCurrent(item, true);
		this.current = item;
		this.options.onClick(new Event(event), item);
	},

	moveBg: function(to) {		
		if(!this.current) return;
		this.back.fx.pause();
		
		xPos 	= to.offsetLeft;
		wPos	= to.offsetWidth;
		tempEl 	= to.offsetParent;
		
		while(tempEl != null) {
			xPos 	+= tempEl.offsetLeft;
			tempEl 	 = tempEl.offsetParent;
		}
		if(this.wback == 0) this.wback = this.back.offsetWidth;
		this.back.fx.start({
			'left': [this.back.offsetLeft, xPos],
			'width': [this.wback, wPos]
		});
		this.wback = this.back.offsetWidth;		
	}
});