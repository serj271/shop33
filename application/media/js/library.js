function fixPageXY(e){
    if(e.pageX == null && e.clientX != null){
	var html = document.documentElement;
	var body = document.body;
	
	e.pageX = e.clientX + (html.scrollLeft || body && body.scrollLeft || 0);
	e.pageX -= html.clientLeft || 0;

	e.pageY = e.clientY + (html.scrollTop || body && body.scrollTop || 0);
	e.pageY -= html.clientTop || 0;
    }
}

function fixEvent(e,_this){
    s = e | window.event;
    if(!e.currnetTarget) e.currentTarget = _this;
    if(!e.target) e.target = e.srcElement;
    if(e.relatedTarget){
	if(e.type == 'mouseover') e.relatedTarget = e.fromElement;
	if(e.type == 'mouseout') e.relatedTarget = e.toElement;
    } 
    if(e.pageX == null && e.clientX != null){
	var html = document.documentElement;
	var body = document.body;
	
	e.pageX = e.clientX + (html.scrollLeft || body && body.scrollLeft || 0);
	e.pageX -= html.clientLeft || 0;

	e.pageY = e.clientY + (html.scrollTop || body && body.scrollTop || 0);
	e.pageY -= html.clientTop || 0;
    }
    if(!e.which && e.button){
	e.wich = e.button & 1 ? 1 : (e.button & 2 ? 3 : (e.button & 4 ? 2 : 0) );
    }
    return e;
}


function addClass(el,cls){
    var c = el.className.split(' ');
    for(var i=0;i<c.length;i++){
	if(c[i]==cls) return;
    }
    c.push(cls);
    el.className=c.join(' ');
}
function removeClass(el,cls){
    var c = el.className.split(' ');
    for(var i=0;i<c.length;i++){
	if(c[i]==cls) c.splice(i--,1);
    }
    el.className=c.join(' ');
}
function hasClass(el,cls){
    var c = el.className.split(' ');
    for(var i=0;i<c.length;i++){
	if(c[i]==cls) return true;
    }
    return false;
}

function getChar(event){
    if(event.which == null){
	if(event.keyCode < 32) return null;
	return String.fromCharCode(event.keyCode);
    }
    if(event.which != 0 && event.charCode !=0){
	if(event.which < 32) return null;
	return String.fromCharCode(event.which);
    }
    return  null;
}	

function getCoords(elem){
    var box = elem.getBoundingClientRect();
    var body = document.body;
    var docEl = document.documentElement;
    var scrollTop = window.pageYoffset || docEl.scrollTop || body.scrollTop;
    var scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;
    var clientTop = docEl.clientTop || body.clientTop || 0;
    var clientLeft = docEl.clientLeft || body.clientLeft || 0;
    var top = box.top + scrollTop - clientTop;
    var left = box.left + scrollLeft - clientLeft;
    return {top: Math.round(top), left: Math.round(left)};
}
function getPageScroll(){
    if(window.pageXOffset != undefined){
	return {
	    left: pageXOffset,
	    top: pageYOffset
	}
    }    
    var html = document.documentElement;
    var body = document.body;
    var top = html.scrollTop || body && body.scrollTop || 0;
    top -= html.clientTop;
    var left = html.scrollLeft || body && body.scrollLeft || 0;
    left -= html.cleintLeft;
    return {
	top: top,
	left: left
    };
}
function getStyle(elem,styleProp){
    if(elem.currentStyle){
	return  elem.currentStyle[styleProp];
    } else {
	return document.defaultView.getComputedStyle(elem,null).getPropertyValue(styleProp);
    }	
}

/* use elem.onmouseout = handleMouseLeave(function(e) {..}) */ 
function handleMouseLeave(handler){
    return function(e){
	e = e || event;
	var toElement = e.relatedTarget || e.toElement;
	while(toElement && toElement  !== this){
	    toElement = toElement.parentNode;
	}
	if(toElement == this){
	    return;
	}
	return handler.call(this, e);
    };
} 

function handleMouseOut(handler){
    return function(e){
	e = e || event;
	var toElement = e.relatedTarget || e.srcElement;
	while(toElement && toElement  !==this) {
	    toElement = toElement.parentNode;
	}
	if(toElement == this){
	    return;
	}    
	return handler.call(this, e);
    };
}

if(!Array.prototype.filter){
    Array.prototype.filter = function(fun /* thisp */){
	"use strict";
//	if(this === void 0 this === null)
//	    throw new TypeError();
	var t = Object(this);
	var len = t.length >>> 0;
	if(typeof fun !== "function")
	    throw new Error();
	
	var res = [];
	var thisp = arguments[1];
	for( var i =0 ;i<len; i++){
	    if(i in t){
		var val = t[i]; //in case fun mutates this
		if(fun.call(thisp, val, i, t)){
		    res.push(val);
		}
	    }
	}
	return res;
    };
}

if(!Array.prototype.indexOf){
    Array.prototype.indexOf=function(searchElement /* fromIndex */)
    {
	"use strict";
	if(this==void 0 || this === null)
	    throw new TypeError();
	var  t=Object(this);
	var len=t.length >>> 0;
	if(len===0)
	    return -1;
	var n=0;
	if(arguments.length >0 ){
	    n = Number(arguments[1]);
	    if(n!==n) //for verify NaN
		n=0;
	    else if (n !==0 && n !==(1/0) && n!==-(1/0))
		n=(n> 0 ||-1) * Math.floor(Math.abs(n));
	}
	if(n>= len)
	    return -1;
	var k=n >=0 ? n : Math.max(len -Math.abs(n),0);
	for(;k<len;k++){
	if(k in t && t[k] === searchElement)
	    return k;
	} return -1;
    };
}

function readCookie(name){
    var nameEQ=name+"=";
    var ca = document.cookie.split(';');
    for (var i=0;i<ca.length;i++) {
	var c = ca[i];
	while (c.charAt(0)==' ') c = c.substring(1,c.length);
	if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function createCookie(name,value,days){
    if(days){
	var date=new Date();
	date.setTime(date.getTime()+(days*24*60*60*1000));
	var expires = "; expires="+date.toGMTString();
    } else var expires="";
    document.cookie=name+"="+value+expires+"; path=/";
}

function moveCaretToEnd(inputObject){
    if(typeof TextRange=='object'){
	var r = inputObject.createTextRange();
	r.collapse(false);
	r.select();
    } else if(typeof setSelectionRange){
	var end=inputObject.value.length;
	inputObject.setSelectionRange(end,end);
	inputObject.focus(); 
    }
}

function cloneObject(source){
    for(var i in source){
	if(typeof source[i] == 'source'){
	    this[i] = new cloneObject[i];
	} else {
	    this[i] = source[i];
	}
    }
}

