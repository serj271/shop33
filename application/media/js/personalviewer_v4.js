"use strict";
//personal

window.onload=inter_init;

function inter_init(){
	var path =[];	
	path = location.href.toString().split('\/');
	var url = location.href.toString();
	var e_url = '';//edited url
	var p = 0;//position
	var p2 = 0;//position 2
	p = url.indexOf("//");
	e_url = url.substring(p+2);
	var root = 'http://' + e_url.split('/').slice(0,2).join('/')+ '/';

	var selectedNavigation = $('#navigation option:selected').val();				
	setPopover(selectedNavigation);
	$('#job').popover();
	$('#job').on('blur', function(){
		$('#job').popover('hide');		
	});

	$('#header ul#menu li').find('a[href="'+'/'+path[3]+'/'+path[4]+'"]').parent().addClass('on');

	$('#result').on('click','.full_name',onDataClick);
//    $('#job').css('display','none');

		if($('.control-panel input:radio:checked').attr('value')=='show_select'){
			$('label[for=navigation]').replaceWith('<label for="navigation">Поиск</label>');
				$('#job').css('visibility','visible');
			$('#job').focus();
	//	    createCookie('region','show_select',5);
		} else {	
			$('label[for=navigation]').replaceWith('<label for="navigation">Сортировка</label>');
			$('#job').css('visibility','hidden');
	//	    createCookie('region','show_all',5);
		}

    
    $('.control-panel :radio').click(function(){
	//	var checked=this;
	//	$('#job').css('display',checked ? 'block':'none');
		if($('input:radio:checked').attr('value')=='show_select'){
			$('label[for=navigation]').replaceWith('<label for="navigation">Поиск</label>');
				$('#job').css('visibility','visible');
			var selectedNavigation = $('#navigation option:selected').val();				
			setPopover(selectedNavigation);
			$('#job').popover();
			$('#job').focus();
	//	    createCookie('region','show_select',5);
		} else {	
			$('label[for=navigation]').replaceWith('<label for="navigation">Сортировка</label>');
			$('#job').css('visibility','hidden');
	//	    createCookie('region','show_all',5);
		}
    });   

    $('#restrict input[type=checkbox]').on('click', function(){
		if($(this).attr('checked')=='checked'){
			$('#result table td.room').each(function(){
				if(!$(this).html().match(/^[0-9]/)){
					$(this).parent().addClass('hidden');
				}
			});
		} else {
			$('#result table td.room').each(function(){
				if(!$(this).html().match(/^[0-9]/)){
					$(this).parent().removeClass('hidden');
				}
			});
		}
		
    });
}

function onSearchClick(e){
    concur($(e.target));
}

function concur(elem){  //sovpadenie
    var value = elem.html();
    $("#result table td:contains("+value+")").css('background','yellow');
}

function changeEnterprise(){
//    createCookie('navigatorEnterprise',$('#navigatorEnterprise').val(),10);
}
function changeNavigation(){
//    createCookie('navigation',$('#navigation').val(),10);
	var selectedNavigation = $('#navigation option:selected').val();
	setPopover(selectedNavigation);
	$('#job').popover('hide');
}

function setPopover(selectedNavigation){
	switch(selectedNavigation){
		case 'id':
		$('#job').attr('data-content','Табельный номер - от 4 до 7 знаков');
		break;
		case 'dp':
		$('#job').attr('data-content','Департамент - буквы');
		break;
		case 'rm':
		$('#job').attr('data-content','Комната - от 2 до 5 знаков');
		break;
		case 'ph':
		$('#job').attr('data-content','Телефон в формате XX-XX, XXXXX - цифры и дефисы');
		break;
		case 'em':
		$('#job').attr('data-content','Email');
		break;
		case 'fn':
		$('#job').attr('data-content','Фамилия - буквы');
		break;		
	}	
	
}


function onDataClick(e){
    markDate($(e.target));
}

function markDate(elem){
    var color = markerColor.get();
    color = '#ccc';
//    var background = elem.parent().css('background');
//    if(background ==''){
//	elem.parent().css('background', color);
//    }
    var dataColor =  elem.parent().attr('data-color');
    if(!dataColor){
		elem.parent().attr('data-color', color);
		elem.parent().css('background', color);
    } else {
		elem.parent().removeAttr('data-color');
		elem.parent().css('background','');
    }
}

function createEnterpriseOption(ar){
    var objSelectD=document.getElementById('navigatorEnterprise');
//    removeAllOptions(objSelectD);
    for(var i=0;i<ar.length;i++){
		var optn=document.createElement('option');
		optn.text=ar[i];
		optn.value=i;
		objSelectD.options.add(optn);        
    }
    var selectEnterprise=readCookie('navigatorEnterprise');
    if(selectEnterprise){
		for(var i=0;i<objSelectD.options.length;i++){
			if(objSelectD.options[i].value==selectEnterprise){
			objSelectD.options[i].selected=true;
			}
		}
    }
//    changeEnterprise();
}

function  MarkerColor(){
    var markerColor; 
    this.set = function(value){
		markerColor = value;
    };
    this.get = function(){
		return markerColor;
    };
} 
/*    
function Menu(options){
    var elem = options.elem;
    elem.on('mousedown selectstart', false);
//    elem.append('<li>маркер</li>');
    var ar=['silver','cyan','moccasin','orange','yellow','aquamarine','lime','plum','lightpink'];    
    elem.append("<ul class='menu-items'></ul>");
    elem.addClass('menu-open');
    $.each(ar, function(index, value){
		elem.find('ul').append('<li>'+value+'</li>');
	
    });
    elem.children('ul').children().each(function(){
		var color = $(this).html();
		$(this).css('background',color);
		$(this).addClass('menu-item');
    });
    var self = this;
    
    this.open = function(){
		elem.removeClass('menu-close');
        elem.addClass('menu-open');
    };
    this.close = function(){
		elem.removeClass('menu-open');
		elem.addClass('menu-close');
    }
    elem.on('click','.menu-item', onItemClick);
    function onItemClick(e){
		setColor($(e.target).html());
    }
    function setColor(color){
		markerColor.set(color);
		elem.children('span').eq(1).css('background',color);
		createCookie('markColor',color);
    }
    this.init = function(){
		var defaultColor = readCookie('markColor');
		if(defaultColor){
			setColor(defaultColor);
		} else {
			setColor('silver');
		}
    }

    
    
    elem.on('click','.menu-title',onTitleClick);
    
    function onLiMouseout(){
	self.close();
	
    }
    function onTitleClick(e){
		if(elem.hasClass('menu-open')){
			self.close();
		}  else {
			self.open();
		}
    }
         
}
*/
var markerColor = new MarkerColor();

function createColorLi(){
    var menu = new Menu({
	elem: $('#colorSelect')
	
    });
    menu.init();
    menu.close();
}

function deleteLi(id){
    var lis=document.getElementsByTagName('li');
    while(id.childNodes[1]){
		id.removeChild(ulSearch.childNodes[1]);        
    }
}


function changeColor(color){
//    var liSelect=document.getElementById('liSelect');
//    var colorArray=['cyan','silver','moccasin','orange','yellow','aquamarine','lime','plum','lightpink'];
//    liSelect.style.backgroundColor=color;
//    createCookie('markerColor',color,1);
    var color = markerColor.get();
//    $('#colorSelect li').first().css('background', color);
}

function checkForm(){
//	debugger;
	return true;
    var navigatorForm = document.forms.navigator;
    var ragion = navigatorForm.ragion[1].checked; //0 - true => all if 1 - true =>select
    var navigation = navigatorForm.navigation.value;//id dp rm fn ph em 
    var text = navigatorForm.job.value;
    if(navigation=='id'){
	if(text.length<7){
	    var missString = 7 - text.length;
	    var issue = '0000000';
	    var str = issue.substring(0, missString)+ text;
	    navigatorForm.job.value = str;
	    text = str;
	}
    }
    
    if(navigation=='ph'){
	var temp = text.replace(/-/g,'');
	navigatorForm.job.value = temp;
    }

	var checkInhibit=new RegExp('[\<\>\,\'\"\;\:]','g');
	var checkEmail=new RegExp('^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z]{2,6})$');
//		    var checkEmail=new RegExp('^([a-z0-9_\-]+\.)*[a-z0-9_\-]+(@chel.elektra.ru)$');
	var checkRoom=/^(\d){1,3}([а-я]*)$/;
	
//	var checkSpace=/^(\s)+|(\s)+$/;
	var checkPhone=/(\d)+\-*/;
	var checkId=/^(\d{7})$/;
	var goodtogo=new Boolean(true);
	var check={'ph':[checkPhone,'ErrPhone'],'id':[checkId,'ErrId'],
	    'rm':[checkRoom,'ErrRoom'],'em':[checkEmail,'ErrEmail']};
	if(ragion){
		try{
			if(text ==''){
			    goodtogo=false;
			    throw("ErrNull");
			}
//			if(checkSpace.test(text)){
//			    goodtogo=false;
//			    throw("ErrSpace");
//    			}	
			if(checkInhibit.test(text)){
			    goodtogo=false;
			    throw("ErrInhibit");
			}
			if(text.length>128){
			    goodtogo=false;
			    throw("ErrLength");
			}
			for(var i in check){
			    if(i==navigation){
					if(!check[i][0].test(text)){
						goodtogo=false;
						throw(check[i][1]);
					}
			    }
			}
		}
		catch(e){
			if(e=='ErrNull'){
	    		    alert("null");
			}
			if(e=='ErrInhibit'){
	    		    alert("err: "+text);
//			    input.value=text.replace(checkInhibit,'');
//			    moveCaretToEnd(input);
			}
			if(e=="ErrLength"){
	    		    alert("long: "+text.length);
//			    input.value=text.replace(/[^(\d)]/g,'');
//			    moveCaretToEnd(input);
			}
			if(e=='ErrCount'){
			    alert("more once: "+text);
//			    input.value=tempA[0];
			}
			if(e=='ErrId'){
			    alert("err id: "+text);
//			    input.value=text.replace(/[^(\d)]/g,'');
//			    moveCaretToEnd(input);
			}
			if(e=="ErrSpace"){
			    alert("err space: "+text);
//			    input.value=text.replace(/^\s+|\s+$/g,'');
			}
			if(e=='ErrEmail'){
			    alert("err email: "+text);
//			    moveCaretToEnd(input);
			}
			if(e=='ErrDep'){
			    alert("err dep: "+text);
//			    moveCaretToEnd(input);
			}
			if(e=='ErrName'){
			    alert("err: "+text);
//			    moveCaretToEnd(input);
			}
			if(e=='ErrPhone'){
			    alert("err phone: "+text);
//			    moveCaretToEnd(input);
			}
			if(e=='ErrRoom'){
			    alert("err room: "+text);
//			    moveCaretToEnd(input);
			}
		}
		    if(goodtogo==true){
				return true;
			} else {
				return false;
		    }
	} else {
	    return true;
	}
}

function ScrollTop(options){
    var self = this;
    var elem = options.elem;
    elem.on('click',onScrollTop);
    function onScrollTop(){
//	console.log("L");
	$('html, body').animate({scrollTop: 0}, 500);
//	window.scrollTo(0,0);
    }
}

$(document).ready(function(){
    if(document.getElementById('controlScrollTop')){
	var scrollTop = new ScrollTop({
	    elem: $('#controlScrollTop')
	});
	window.onscroll = function(){
	    var pageScroll = getPageScroll().top;
	    if(pageScroll >300){
		$('#controlScrollTop').fadeIn('slow');
//		document.getElementById('controlScrollTop').style.display = 'block';
	    } else {
		$('#controlScrollTop').fadeOut('slow');
//		document.getElementById('controlScrollTop').style.display = 'none';	
	    }	
	};
    }
});



