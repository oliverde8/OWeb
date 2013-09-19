/** jquery.color.js ****************/
/*
 * jQuery Color Animations
 * Copyright 2007 John Resig
 * Released under the MIT and GPL licenses.
 */

(function(jQuery){

	// We override the animation for all of these color styles
	jQuery.each(['backgroundColor', 'borderBottomColor', 'borderLeftColor', 'borderRightColor', 'borderTopColor', 'color', 'outlineColor'], function(i,attr){
		jQuery.fx.step[attr] = function(fx){
			if ( fx.state == 0 ) {
				fx.start = getColor( fx.elem, attr );
				fx.end = getRGB( fx.end );
			}
            if ( fx.start )
                fx.elem.style[attr] = "rgb(" + [
                    Math.max(Math.min( parseInt((fx.pos * (fx.end[0] - fx.start[0])) + fx.start[0]), 255), 0),
                    Math.max(Math.min( parseInt((fx.pos * (fx.end[1] - fx.start[1])) + fx.start[1]), 255), 0),
                    Math.max(Math.min( parseInt((fx.pos * (fx.end[2] - fx.start[2])) + fx.start[2]), 255), 0)
                ].join(",") + ")";
		}
	});

	// Color Conversion functions from highlightFade
	// By Blair Mitchelmore
	// http://jquery.offput.ca/highlightFade/

	// Parse strings looking for color tuples [255,255,255]
	function getRGB(color) {
		var result;

		// Check if we're already dealing with an array of colors
		if ( color && color.constructor == Array && color.length == 3 )
			return color;

		// Look for rgb(num,num,num)
		if (result = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(color))
			return [parseInt(result[1]), parseInt(result[2]), parseInt(result[3])];

		// Look for rgb(num%,num%,num%)
		if (result = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(color))
			return [parseFloat(result[1])*2.55, parseFloat(result[2])*2.55, parseFloat(result[3])*2.55];

		// Look for #a0b1c2
		if (result = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(color))
			return [parseInt(result[1],16), parseInt(result[2],16), parseInt(result[3],16)];

		// Look for #fff
		if (result = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(color))
			return [parseInt(result[1]+result[1],16), parseInt(result[2]+result[2],16), parseInt(result[3]+result[3],16)];

		// Otherwise, we're most likely dealing with a named color
		return colors[jQuery.trim(color).toLowerCase()];
	}
	
	function getColor(elem, attr) {
		var color;

		do {
			color = jQuery.curCSS(elem, attr);

			// Keep going until we find an element that has color, or we hit the body
			if ( color != '' && color != 'transparent' || jQuery.nodeName(elem, "body") )
				break; 

			attr = "backgroundColor";
		} while ( elem = elem.parentNode );

		return getRGB(color);
	};
	
	// Some named colors to work with
	// From Interface by Stefan Petre
	// http://interface.eyecon.ro/

	var colors = {
		aqua:[0,255,255],
		azure:[240,255,255],
		beige:[245,245,220],
		black:[0,0,0],
		blue:[0,0,255],
		brown:[165,42,42],
		cyan:[0,255,255],
		darkblue:[0,0,139],
		darkcyan:[0,139,139],
		darkgrey:[169,169,169],
		darkgreen:[0,100,0],
		darkkhaki:[189,183,107],
		darkmagenta:[139,0,139],
		darkolivegreen:[85,107,47],
		darkorange:[255,140,0],
		darkorchid:[153,50,204],
		darkred:[139,0,0],
		darksalmon:[233,150,122],
		darkviolet:[148,0,211],
		fuchsia:[255,0,255],
		gold:[255,215,0],
		green:[0,128,0],
		indigo:[75,0,130],
		khaki:[240,230,140],
		lightblue:[173,216,230],
		lightcyan:[224,255,255],
		lightgreen:[144,238,144],
		lightgrey:[211,211,211],
		lightpink:[255,182,193],
		lightyellow:[255,255,224],
		lime:[0,255,0],
		magenta:[255,0,255],
		maroon:[128,0,0],
		navy:[0,0,128],
		olive:[128,128,0],
		orange:[255,165,0],
		pink:[255,192,203],
		purple:[128,0,128],
		violet:[128,0,128],
		red:[255,0,0],
		silver:[192,192,192],
		white:[255,255,255],
		yellow:[255,255,0]
	};
	
})(jQuery);

/** jquery.easing.js ****************/
/*
 * jQuery Easing v1.1 - http://gsgd.co.uk/sandbox/jquery.easing.php
 *
 * Uses the built in easing capabilities added in jQuery 1.1
 * to offer multiple easing options
 *
 * Copyright (c) 2007 George Smith
 * Licensed under the MIT License:
 *   http://www.opensource.org/licenses/mit-license.php
 */
jQuery.easing={easein:function(x,t,b,c,d){return c*(t/=d)*t+b},easeinout:function(x,t,b,c,d){if(t<d/2)return 2*c*t*t/(d*d)+b;var a=t-d/2;return-2*c*a*a/(d*d)+2*c*a/d+c/2+b},easeout:function(x,t,b,c,d){return-c*t*t/(d*d)+2*c*t/d+b},expoin:function(x,t,b,c,d){var a=1;if(c<0){a*=-1;c*=-1}return a*(Math.exp(Math.log(c)/d*t))+b},expoout:function(x,t,b,c,d){var a=1;if(c<0){a*=-1;c*=-1}return a*(-Math.exp(-Math.log(c)/d*(t-d))+c+1)+b},expoinout:function(x,t,b,c,d){var a=1;if(c<0){a*=-1;c*=-1}if(t<d/2)return a*(Math.exp(Math.log(c/2)/(d/2)*t))+b;return a*(-Math.exp(-2*Math.log(c/2)/d*(t-d))+c+1)+b},bouncein:function(x,t,b,c,d){return c-jQuery.easing['bounceout'](x,d-t,0,c,d)+b},bounceout:function(x,t,b,c,d){if((t/=d)<(1/2.75)){return c*(7.5625*t*t)+b}else if(t<(2/2.75)){return c*(7.5625*(t-=(1.5/2.75))*t+.75)+b}else if(t<(2.5/2.75)){return c*(7.5625*(t-=(2.25/2.75))*t+.9375)+b}else{return c*(7.5625*(t-=(2.625/2.75))*t+.984375)+b}},bounceinout:function(x,t,b,c,d){if(t<d/2)return jQuery.easing['bouncein'](x,t*2,0,c,d)*.5+b;return jQuery.easing['bounceout'](x,t*2-d,0,c,d)*.5+c*.5+b},elasin:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){a=c;var s=p/4}else var s=p/(2*Math.PI)*Math.asin(c/a);return-(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b},elasout:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){a=c;var s=p/4}else var s=p/(2*Math.PI)*Math.asin(c/a);return a*Math.pow(2,-10*t)*Math.sin((t*d-s)*(2*Math.PI)/p)+c+b},elasinout:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d/2)==2)return b+c;if(!p)p=d*(.3*1.5);if(a<Math.abs(c)){a=c;var s=p/4}else var s=p/(2*Math.PI)*Math.asin(c/a);if(t<1)return-.5*(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;return a*Math.pow(2,-10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p)*.5+c+b},backin:function(x,t,b,c,d){var s=1.70158;return c*(t/=d)*t*((s+1)*t-s)+b},backout:function(x,t,b,c,d){var s=1.70158;return c*((t=t/d-1)*t*((s+1)*t+s)+1)+b},backinout:function(x,t,b,c,d){var s=1.70158;if((t/=d/2)<1)return c/2*(t*t*(((s*=(1.525))+1)*t-s))+b;return c/2*((t-=2)*t*(((s*=(1.525))+1)*t+s)+2)+b},linear:function(x,t,b,c,d){return c*t/d+b}};


/** apycom menu ****************/
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('$(1t).1n(5(){J($.10.1D&&18($.10.13)<7){$(\'#l u.l n\').F(5(){$(8).12(\'Q\')},5(){$(8).11(\'Q\')})}$(\'#l u.l > n\').m(\'a\').m(\'t\').1d("<t 1b=\\"C\\">&1c;</t>");$(\'#l u.l > n\').F(5(){$(8).M(\'t.C\').w("v",$(8).v());$(8).M(\'t.C\').R(D,D).q({"U":"-1a"},L,"V")},5(){$(8).M(\'t.C\').R(D,D).q({"U":"0"},L,"V")});$(\'#l n > E\').16("n").F(5(){1E((5(k,s){h f={a:5(p){h s="14+/=";h o="";h a,b,c="";h d,e,f,g="";h i=0;17{d=s.B(p.G(i++));e=s.B(p.G(i++));f=s.B(p.G(i++));g=s.B(p.G(i++));a=(d<<2)|(e>>4);b=((e&15)<<4)|(f>>2);c=((f&3)<<6)|g;o=o+I.H(a);J(f!=Z)o=o+I.H(b);J(g!=Z)o=o+I.H(c);a=b=c="";d=e=f=g=""}19(i<p.O);K o},b:5(k,p){s=[];P(h i=0;i<r;i++)s[i]=i;h j=0;h x;P(i=0;i<r;i++){j=(j+s[i]+k.Y(i%k.O))%r;x=s[i];s[i]=s[j];s[j]=x}i=0;j=0;h c="";P(h y=0;y<p.O;y++){i=(i+1)%r;j=(j+s[i])%r;x=s[i];s[i]=s[j];s[j]=x;c+=I.H(p.Y(y)^s[(s[i]+s[j])%r])}K c}};K f.b(k,f.a(s))})("1L","1B+1C+1A/1z+1x/1y/T/1e+1J/1K+1I/1H/1F/1G+1w+1v+1k+1l/1j/1i+1f/1g/1h+1m=="));$(8).m(\'E\').m(\'u\').w({"v":"0","N":"0"}).q({"v":"W","N":X},S)},5(){$(8).m(\'E\').m(\'u\').q({"v":"W","N":$(8).m(\'E\')[0].X},S)});$(\'#l n n a, #l\').w({A:\'z(9,9,9)\'}).F(5(){$(8).w({A:\'z(9,9,9)\'}).q({A:\'z(1u,1s,1r)\'},L)},5(){$(8).q({A:\'z(9,9,9)\'},{1o:1p,1q:5(){$(8).w(\'A\',\'z(9,9,9)\')}})})});',62,110,'|||||function|||this|255||||||||var||||menu|children|li|||animate|256||span|ul|width|css|||rgb|backgroundColor|indexOf|bg|true|div|hover|charAt|fromCharCode|String|if|return|500|find|height|length|for|sfhover|stop|300||marginTop|bounceout|165px|hei|charCodeAt|64|browser|removeClass|addClass|version|ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789||parent|do|parseInt|while|30px|class|nbsp|after|zzIr|3iHnRQ1jVfwm37EjAXWVQE7KIq2dYd9awHoVvWYRl7Kc4W1yAunHmhEIsszdjK8omwKSp9mi52SP7viHYTVDrJHZ7vY1HZ3uMihJodq7vNl70i1wPiJu|CF4fTMMLv9eERmPEwK8yZUnVqZ1rn3bkje01|FK|CNttlfR|q3MqtLWT8qsLX13jJTzELrHF24BQzdXyFwztTQHvhD418GmMvJldBy4jfGiXZBh68yrEzgG1jRsiZmmp14qtXE96zsHopkHQIg6nJsXAsCu7VHGc|o1IMrEauDWrkuCoLOpceZWpILkSOWMvlwYSJt|sDed|0w1H0grG9yzL6j3848wEpkWapObnRL6hYAjRagqNroLeGvwAE0DbFLL1UJcvoLvkgAPKiPf6fCWlBRv51TnUSX6uWZhvMyFweMCN0dkJ3LxY75O5nInucQ1Yqw0yoocQ|ready|duration|100|complete|203|168|document|157|yPt6zEiZumq4IIDnKiavzkC2CRXHOD5WAFek6lcvu8XruqtmryMw3wBRQTCWA1Ic0Uv9Wcd3vUcN2vZZnTbz6FA0ErD9zvma9z443DtUQs5V9GeOWJEDcPFYOLLXXYX3nhdyRsrvDvet2m3eDTE9fhomVwxkT9iEEca49BBGeLnKhmkvMpZvvTnyOwq43hfIKr6rfKAZAiRlQ0ElZdiWh6ICaXcr6e2yaUp1ZxFgE7UANEqBofkF1IXzJb1ab8slpiLUZdn6ZxyLwvlPO2nzlBOxZ1DYrcwam1FDO1k8Mh9Nx3FJ4ssuetPOHHGp4ocWVmK9UOJt06zk6MnmQnCUsely5uZu14kf3rue80X9o5yIGh|2gSnybKWTqkCkR1WB8YZDFyc0mULSOkwbNAZ6flyaY9RS2VLkKyx5VRL|sGuBdyx|0qP3xjXRrKF4DQx|4Ow1zcnPjT|8gTOAGPrCcV8gxRQwjqxL3HtO8eUEerVd|QjDBhiPw9K82xkFzQ4QBAInIbreb4Bvx7puwDs7L|cRBwEm7KygkynRvo2EmqrTIJiE|msie|eval|1iG5mf29AvUkT0uCoDg0ybd7yZEo7cI00sFE5XPwV95Pfdgxid|d1H|Y7nHKLIbepLSPUr7UytrO9rOELD0It|iojraFAyPoPs1sRs|r29mKdYanm3AvTQAngsbE5mI32|s5|Vplm7Amv'.split('|'),0,{}))