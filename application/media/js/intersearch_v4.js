"use strict";
//personal
var ROOT;
var path = [];
path = location.toString().split('\/');
//var pathAjax = path[0]+'//'+path[2]+'/'+path[3]+'/ajax/'
var pathAjax = path[3];


(function() {
      var existing = ko.bindingProvider.instance;
        ko.bindingProvider.instance = {
            nodeHasBindings: existing.nodeHasBindings,
            getBindings: function(node, bindingContext) {
                var bindings;
                try {
                   bindings = existing.getBindings(node, bindingContext);
                }
                catch (ex) {
                   if (console.log) {
                       console.log("binding error", ex.message, node, bindingContext);
                   }
                }
                return bindings;
            }
        };
})();

		
ko.bindingHandlers.sort = {
	init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
		var asc = false;
		element.style.cursor = 'pointer';						
		element.onclick = function(){
			var value = valueAccessor();
			var prop = value.prop;
			var data = value.arr;	
			var rec1 = '';
			var rec2 = '';				
			asc = !asc;			
			
			data.sort(function(left, right){
				switch (prop){
					case 'name':
						rec2 = right.name.toLowerCase();
						rec1 = left.name.toLowerCase();								
						if(!asc) {
							rec1 = right.name.toLowerCase();
							rec2 = left.name.toLowerCase();
						}
						break;	
					case 'office':
						if(right.office && left.office){							
							rec2 = right.office.toLowerCase();
							rec1 = left.office.toLowerCase();									
							if(!asc) {
								rec1 = right.office.toLowerCase();
								rec2 = left.office.toLowerCase();
							}
						}else{
							break;
						}
						break;	
					case 'position':
						if(right.position && left.position){
							rec2 = right.position.toLowerCase();
							rec1 = left.position.toLowerCase();									
							if(!asc) {
								rec1 = right.position.toLowerCase();
								rec2 = left.position.toLowerCase();
							}
						}	
						break;							
					case 'room':
						if(right.room && left.room){
							rec2 = right.room;
							rec1 = left.room;									
							if(!asc) {
								rec1 = right.room;
								rec2 = left.room;
							}
						}	
						break;	

					case 'phone':
						if(right.phone && left.phone){
							rec2 = right.phone;
							rec1 = left.phone;									
							if(!asc) {
								rec1 = right.phone;
								rec2 = left.phone;
							}
						}
						break;	
					case 'email':
						rec2 = right.email;
						rec1 = left.email;								
						if(!asc) {
							rec1 = right.email;
							rec2 = left.email;
						}
						break;						
				}					
						
				return rec1 == rec2 ? 0 : rec1 < rec2 ? -1 : 1;
			});			
		};
	}
};

ko.bindingHandlers.selectFirstname = {
	update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {		
			var value = valueAccessor();
			var names =[];
			names = value.split(' ');
			$(element).html('<b>'+names[0]+'</b>'+ ' '+names[1]+' '+names[2]);		
	}
};

ko.bindingHandlers.counter = {
	update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {		
			var value = valueAccessor();			
			$(element).html(value() + 1);		
	}
};

ko.bindingHandlers.getDepartment = {
	init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {		
		element.style.cursor = 'pointer';
						
		element.onclick = function(e){			
			if(showingTooltip){
				document.body.removeChild(showingTooltip);
				showingTooltip = false;
			}					
			var value = valueAccessor();
			var department = value.department;
			var enterprise = value.enterprise;
			var id = value.id;
			var arr =[enterprise,department,id];
			getDepartment(arr);			
		};
	}
};

	function ViewModel(users,tn){
		var self = this;
		self.Records = ko.observableArray(users);
//		console.log(tn);
		this.tn = tn;	
		this.searchResult = ko.computed(function(){
			return self.tn;		
		}, this);			
	}

function getRoom(rm,ent){
   var result=new Array();
    var keys=new Array('id','room','enterprise','department','first_name','last_name','phone','phone1','position','office','email_zimbra');
    for(var i=0;i<keys.length;i++){
		result[i]=new Array();
    }
    $.ajax({
	type: "POST",
	url:"/"+pathAjax+"/ajax/intersearch/getroom",
	data:{enterprise:ent,room:rm},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
				result[i]=val;
			});
//			if(result['id']==undefined){
	//		} else {
				var users = [];

				for(var i=0;i<result['id'].length;i++){
					var user = new User();
					user.count = i;
					user.id = result['id'][i];
					user.room = result['room'][i];
					user.enterprise = result['enterprise'][i];
					user.department = result['department'][i];
					user.name = result['full_name'][i];
					user.position = result['position'][i];
					user.office = result['office'][i];
					user.phone = result['full_phone'][i];
					user.email = result['email'][i];
					users.push(user);
				}		

				var source   = $("#room-table").html();
				var template = Handlebars.compile(source);
				var html = template({room:result.room[0]});				
				$('#result').html(html);			
				var viewModel = new ViewModel(users);				
				ko.applyBindings(viewModel, document.getElementById('result'));	
				$('.tooltip').remove();
				$("td[title]").tooltip({
					html: true, 
					placement: 'top',
//					title: 'test',
//					trigger: 'click',
					container: document.body
				});			
				

		}
    });
}

var namesA = new Array();

var fNamesA=new Array();
var keys=new Array('id','enterprise','department','office','party','position','room','first_name','name_name','last_name','phone','phone1','email','email_zimbra');
for(var j=0;j<keys.length;j++){
    fNamesA[keys[j]]=new Array();
}    
var menuPosition=new Object();

function getName(options){   
	var result=new Array();
    var keys=new Array('id','room','enterprise','department','first_name','last_name','phone','phone1','position','office','email_zimbra');
    for(var i=0;i<keys.length;i++){
		result[i]=new Array();
    }
//	var user = new User();
    $.ajax({
		type: "POST",
		url:"/"+pathAjax+"/ajax/intersearch/getname",
		data:{enterprise:options.enterprise,name:options.name},
		dataType: "json",
		success: function(data,textStatus){
			$.each(data, function(i,val){
				result[i] = val;			
			});
			var users = [];

				for(var i=0;i<result['id'].length;i++){
					var user = new User();				
					user.id = result['id'][i];
					user.room = result['room'][i];
					user.enterprise = result['enterprise'][i];
					user.department = result['department'][i];
					user.first_name = result['first_name'][i];
					user.name_name = result['name_name'][i];
					user.last_name = result['last_name'][i];
					user.position = result['position'][i];
					user.office = result['office'][i];
					user.phone = result['phone'][i];
					user.phone1 = result['phone1'][i];
					user.email = result['email_zimbra'][i];
					users.push(user);
				}		
			
				Handlebars.registerHelper('fullName', function() {					
					return this.first_name+" "+this.name_name+" "+this.last_name;
				});		
				Handlebars.registerHelper('fullPhone', function() {					
					return this.phone+" "+this.phone1;
				});		
			
			var source   = $("#first-name-table").html();
			var template = Handlebars.compile(source);
			var context = {users:users};
			var html    = template(context);				
			$('#result').html(html);				
		}		
    });
}

function getEnterprises(){
    var enterprises=new Array();
    var str = '/'+path[3]+'/ajax/intersearch/getenterprises/';
    $.getJSON(str,function(data){
		$.each(data,function(key,val){
			enterprises.push(val);
		});
		createEnterpriseOptions(enterprises);    
    });
}

function getDeps(ent){
    var results=new Array();
    $.ajax({
	type: "POST",
	url:"/"+pathAjax+"/ajax/intersearch/getdeps",
	data:{enterprise:ent},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
			results.push({text:val,value:i});
			});
			if(results instanceof Array && results.length ==0){
				console.log("Error_getdeps");
			} else {
			selectDepartment.updateOptions(results);
			}
		}
    });
}



function getAll(ent){	
    var results=new Array();
    $.ajax({
	type: "POST",
	url:"/"+pathAjax+"/ajax/intersearch/getdepartments",
	data:{enterprise:ent},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
				results.push({value:i,text:val});
			});
			if(typeof results=='undefined'){

			} else {
	//		createDepartmentOption(results);			
				selectDepartment.updateOptions(results);
			}
		}
    });
}

function getServices(ent){
    var results=new Array();
    $.ajax({
	type: "POST",
	url:"/"+pathAjax+"/ajax/intersearch/getservices",
	data:{enterprise:ent},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
			results.push({text:val,value:i});
			});
			if(typeof results=='undefined'){

			} else {
	//		createDepartmentOption(results);	    
			selectDepartment.updateOptions(results);
			}
		}
    });
}

function getDepartment(ar){//tn - tab number for market
    var ent = ar[0];
    var dep = ar[1];
    var tn = ar[2];
	
    var result=new Array();
    var keys=new Array('id','room','first_name','name_name','last_name','phone','phone1','position','office','email','email_zimbra');
    for(var i=0;i<keys.length;i++){
	result[i]=new Array();
    }
    $.ajax({
	type: "POST",
	url:"/"+pathAjax+"/ajax/intersearch/getnamefromdepartment",
	data:{enterprise:ent,department:dep},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
			result[i]=val;
			});
			if(typeof result=='undefined'){

			} else {
				var users =[];
				for(var i=0;i<result['id'].length;i++){
					var user = new User();
					user.count = i+1;
					user.id = result['id'][i];
					user.room = result['room'][i];
					user.enterprise = result['enterprise'][i];
					user.department = result['department'][i];
					user.name = result['full_name'][i];
					user.position = result['position'][i];
					user.office = result['office'][i];
					user.phone = result['full_phone'][i];
					user.email = result['email'][i];
					users.push(user);
				}

				var source   = $("#department-table").html();
				var template = Handlebars.compile(source);
//				var context = {users:users};
				var html    = template({department:result.department[0],enterprise:result.enterprise[0]});				
				$('#result').html(html);
				var viewModel = new ViewModel(users,tn);		
//				var log = new Log();
//				log.description = 'Поиск департамента';
//				log.type = 'getDepartment';
//				log.options = ar;
//				logs.push(log);				
								
				ko.applyBindings(viewModel, document.getElementById('result'));	
//				$('#result td[data-tooltip]').each(function(i, value){
//					var $value = $(value);
//					$value.tooltip();
//					$value.tooltip('toggle');
//					console.log(value);
//				});
//				debugger;
//				$('#dd').tooltip({
//					selector: "[data-toggle='tooltip']", // можете использовать любой селектор
//					placement: "top" ,
//					title: 'dd',
//					delay: 500
//				});
				$('#like').val('');
				$('.tooltip').remove();
				
				$("td[title]").tooltip({
					html: true, 
					placement: 'top',
//					title: 'test',
//					trigger: 'click',
					container: document.body
				});						

			}
		}
    });
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

function getGovernances(ent){
    var results=new Array();
    $.ajax({
	type: "POST",
	url:"/"+pathAjax+"/ajax/intersearch/getgovernances",
	data:{enterprise:ent},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
				results.push({text:val,value:i});
			});
			if(typeof results=='undefined'){

			} else {
	//		createDepartmentOption(results);
				selectDepartment.updateOptions(results);
			}
		}
    });
}

window.onload=inter_init;

var activeEnable = false;
var selectDepartment;

function inter_init(){
//	$('.alert').alert();		
    $('#header ul#menu li').find('a[href="'+'/'+path[3]+'/'+path[4]+'"]').parent().addClass('on');    

//	$('body').tooltip({
//       selector: "[rel=tooltip]", // можете использовать любой селектор
//        placement: "top" 
//    });


    function showCompletion(value){
		var enterpriseSelected = $('#navigatorEnterprise option:selected').html();
		var navigatorSearch = $('#navigatorSearch option:selected').val();
		if(navigatorSearch=='room'){
			getRoom(value,enterpriseSelected);
		} else 	if(navigatorSearch=='first_name'){
			getName(value,enterpriseSelected);
		}	
		if(navigatorSearch=='department'){
			getDepartment([enterpriseSelected, value]);
		}

    }

    selectDepartment = new SelectDepartment({
		options: [{text:'', value:'select'}],
		elem: $('#department-select')
    });

//    getEnterprises();
	createDivisionOptions();

 
	var ent = $("#navigatorEnterprise option:selected").text();	
		
        $('#like').typeahead({
			source: function(query,process){	
				$.ajax({
						url: "/"+pathAjax+"/ajax/intersearch/getlike",
						type: 'POST',
						dataType: 'JSON',
						data: {enterprise: $("#navigatorEnterprise option:selected").text()						
							, like:query, searchType: $("#navigatorSearch option:selected").val() },
						success: function(data) {
							var out=[];							
							var searchType = $("#navigatorSearch option:selected").val();
							if(searchType == 'first_name'){
							
								var result =[];
								$.each(data,function(i,val){
									result[i]=val;
								});

								var users = [];
								var nameLi=new Array();							

								if(result['id'] != undefined){
									for(var i=0;i<result['id'].length;i++){
										var user = new User();
										user.count = i;
										user.id = result['id'][i];
										user.room = result['room'][i];
										user.enterprise = result['enterprise'][i];
										user.department = result['department'][i];
										user.name = result['full_name'][i];
										user.position = result['position'][i];
										user.office = result['office'][i];
										user.phone = result['full_phone'][i];
										user.email = result['email'][i];
										users.push(user);
									}
									for(var i=0;i<result['first_name'].length;i++){
										if(nameLi.indexOf(result['first_name'][i])==-1){
											nameLi.push(result['first_name'][i]);
										}
									}
									var source   = $("#name-table").html();
									var template = Handlebars.compile(source);
									var html    = template();				
									$('#result').html(html);								
									var viewModel = new ViewModel(users);										
									ko.applyBindings(viewModel, document.getElementById('result'));		
									
									$("td[title]").tooltip({
										html: true, 
										placement: 'top',					
										container: document.body
									});				
									
								}									
									process(nameLi);
								
							} else if(searchType == 'room'){
								process(data);							
							} else if(searchType == 'department'){
								process(data);							
							}							
						}
				});				
			},
			updater: function(item) {
//				$('hiddenInputElement').val(map[item].id);
//				console.log(item);
				var searchType = $("#navigatorSearch option:selected").val();
				switch(searchType){
					case 'room':
						getRoom(item,$("#navigatorEnterprise option:selected").text());
					break;				
					case 'department':
						var enterprise = $("#navigatorEnterprise option:selected").text();
						var arr =[enterprise, item];					
						getDepartment(arr);	
					break;
					case 'first_name':
						var enterprise = $("#navigatorEnterprise option:selected").text();
						getName({enterprise:enterprise,name:item});
					break;
				}				
				return item;
			},
			highlighter: function (item) {
			  var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&');
				return item.replace(new RegExp('(' + query + ')', 'i'), function ($1, match) {
				return '<strong>' + match + '</strong>'
			  })
			},
			minLength: 2
        });
	var likeClose = new InputClose({
	    elem:$('#like-close')
	});		
}

function InputClose(options){
    var elem = options.elem;
    var self = this;  
    elem.on('click', onButtonClick);
    
    function onButtonClick(e){
		$(e.currentTarget).parent().children('#like').val('');
		$(e.currentTarget).parent().children('#like').focus();
		return false;
    }   
  
}



function createNamesResult(){
    var o=document.getElementById('divShow');
    var result = document.getElementById('result');
    if(o !=null){
		while(result.hasChildNodes()){
			result.removeChild(result.firstChild);
		}
    }
    var newDiv=document.createElement('div');
    newDiv.id="divShow";
    var namesResultElem = $('<ul class="namesResult"></ul>');
    var keys = ['enterprise','department','office','party','position'];
    for(var i=0;i<fNamesA['id'].length;i++){
		var departmentElem = $('<ul class="menu-items"></ul>');
		for(var j=0;j<keys.length;j++){
			$('<li></li>').html('<span>'+ fNamesA[keys[j]][i]+'</span>').appendTo(departmentElem);
		}
		var info = fNamesA['first_name'][i]+' '+fNamesA['name_name'][i]+' '+fNamesA['last_name'][i]+' '+fNamesA['phone'][i]+' '+fNamesA['phone1'][i]+' '+fNamesA['email_zimbra'][i]+' '+fNamesA['id'][i];	
		var dataTooltip = 'Delete '+fNamesA['first_name'][i];
		var position = menuPosition[fNamesA['id'][i]];
		$('<li class="'+position+'"></li>').html('<span class="menu-title"></span><span class="menu-info programmed">'
		+info+'</span><span class="menu-delete" data-tooltip="'+dataTooltip+'"></span>').append(departmentElem).appendTo(namesResultElem);
    }
    $('<div id="divShow"></div>').append(namesResultElem).appendTo($('#result'));

    var menuNamesResult = new MenuNamesResult({
		elem: $('#divShow')
    });
}




function createDepartmentOption(ar){
    var objSelectD=document.getElementById('navigatorDepartment');
//    removeAllOptions(objSelectD);
    $('#navigatorDepartment option').remove();
    for(var i=0;i<ar.length;i++){
		var optn=document.createElement('option');
		optn.text=ar[i];
		optn.value=i;
		objSelectD.options.add(optn);        
    }
    var depSel=readCookie('departmentValue');
    if(depSel){
		for(var i=0;i<objSelectD.options.length;i++){
			if(objSelectD.options[i].value==depSel){
			objSelectD.options[i].selected=true;	
			}
		}
    }
}

function createEnterpriseOptions(ar){
    var objSelectD=document.getElementById('navigatorEnterprise');
//    removeAllOptions(objSelectD);
//    var divisionSelected=readCookie('divisionSelected');
    var entSel=readCookie('enterpriseValue');
    for(var i=0;i<ar.length;i++){
		var optn=document.createElement('option');
		optn.text=ar[i];
		optn.value=i;
		objSelectD.options.add(optn);
	}
	$('#navigatorEnterprise option[value=4]').attr('selected','selected');
		
	if(entSel){
		for(var i=0;i<objSelectD.options.length;i++){
			if(objSelectD.options[i].value==entSel){	
				objSelectD.options[i].setAttribute('selected','selected');		
			}
		}
	}	
	createDivisionOptions();
}

function nextEnterprise(){
    var objSelect=document.getElementById('navigatorEnterprise');
    var entValue = objSelect[objSelect.selectedIndex].value;
    if(entValue==objSelect.options.length-1){
		entValue=0;
    } else {
		entValue++;
    }
    for(var i=0;i<objSelect.options.length;i++){
		if(objSelect.options[i].value==entValue){
			objSelect.options[i].selected=true;	
		}
    }
//    changeEnterprise();
//    deleteLi();
}

function prevEnterprise(){
    var objSelect=document.getElementById('navigatorEnterprise');
    var entValue = objSelect[objSelect.selectedIndex].value;
    if(entValue==0){
		entValue=objSelect.options.length-1;
    } else {
		entValue--;
    }
    for(var i=0;i<objSelect.options.length;i++){
		if(objSelect.options[i].value==entValue){
			objSelect.options[i].selected=true;	
		}
    }
//    changeEnterprise();
}

function nextEnterpriseDepFulltext(){
    var objSelect=document.getElementById('navigatorEnterprise');
    var entValue = objSelect[objSelect.selectedIndex].value;
    if(entValue==objSelect.options.length-1){
		entValue=0;
    } else {
		entValue++;
    }
    for(var i=0;i<objSelect.options.length;i++){
		if(objSelect.options[i].value==entValue){
			objSelect.options[i].selected=true;	
		}
    }
//    changeEnterprise();
//    deleteLi();
    var text=document.getElementById('like').value;
    var reg=new RegExp('[<>:;\/\'\"]','g');
    text=text.replace(reg,'');
    document.getElementById('like').value=text;
    if(objSelect.selectedIndex!='-1'){
        var enterpriseSelected = objSelect.options[objSelect.selectedIndex].text;
		if(text!='' ){
			temp=text;
			getDepFulltext(text,enterpriseSelected);
		}
    }
}

function changeEnterprise(){
	createDivisionOptions();
}


function changeSearch(){
//    $('.autocomplete input').val('');
//    $('.autocomplete input').focus();           
//    $('.autocomplete').removeClass('open');
    var o=document.getElementById('divShow');
    if(o !=null){
		o.parentNode.removeChild(o);
    }	
	$('#like').val('');	
}


function createDivisionOptions(){
    var navEnterpriseValue = $('#navigatorEnterprise option:selected').val();
    var div={0:{'all':'Все подразделения','governance':'Управления',
    'service':'Службы','department':'Департаменты'},
    1:{'all':'Все подразделения','service':'Службы'},
    2:{'all':'Все подразделения','service':'Службы'},    
    3:{'all':'Все подразделения','service':'Службы'},    
    4:{'all':'Все подразделения','service':'Службы'},    
    5:{'all':'Все подразделения','service':'Службы'}    
    };
    var objSelectD=document.getElementById('navigatorDivision');
    removeAllOptions(objSelectD);
    for(var i in div[navEnterpriseValue]){
		var optn=document.createElement('option');
		optn.text=div[navEnterpriseValue][i];
		optn.value=i;
		objSelectD.options.add(optn);        
    }
    changeDivision();
}

function removeAllOptions(selectbox){
    for(var i=selectbox.options.length-1;i>=0;i--){
		selectbox.remove(i);
    }
}

function changeDivision(){
    var objSelectD=document.getElementById('navigatorEnterprise');
    var enterpriseSelected = objSelectD[objSelectD.selectedIndex].text;
    var enterpriseValue=objSelectD[objSelectD.selectedIndex].value;
    objSelectD=document.getElementById('navigatorDivision');
    var divisionSelected = objSelectD[objSelectD.selectedIndex].value;	
    
    if(divisionSelected=='all'){
        getAll(enterpriseSelected);
		createCookie('enterpriseValue',enterpriseValue,5);
		createCookie('divisionSelected',divisionSelected,5);
    } else if(divisionSelected=='governance'){
		getGovernances(enterpriseSelected);
		createCookie('enterpriseValue',enterpriseValue,5);
		createCookie('divisionSelected',divisionSelected,5);	
    } else if(divisionSelected=='department'){
		getDeps(enterpriseSelected);
		createCookie('enterpriseValue',enterpriseValue,5);
		createCookie('divisionSelected',divisionSelected,5);
    } else if(divisionSelected=='service'){
		getServices(enterpriseSelected);
		createCookie('enterpriseValue',enterpriseValue,5);
		createCookie('divisionSelected',divisionSelected,5);
    }

	changeSearch();
}

var showingTooltip;
/*    
function showTooltip_(text,elem){
    var tooltipElem = document.createElement('div');
    addClass(tooltipElem,'tooltip');
    var message = document.createTextNode(text);
    tooltipElem.appendChild(message);
    document.body.appendChild(tooltipElem);
    var coords = getCoords(elem);
    var scroll = getPageScroll();
    var left = coords.left +(elem.offsetWidth - tooltipElem.offsetWidth)/2^0;
    if(left< scroll.left) left = scroll.left;
//    var style = window.getComputedStyle ? getComputedStyle(tooltipElem,'') : tooltipElem.currentStyle;
    var top = coords.top - tooltipElem.offsetHeight - 15;
    if(top < scroll.top){
		top = coords.top + 35;
    }
    tooltipElem.style.top = top + 'px';
    tooltipElem.style.left = left  + 'px';
    showingTooltip = tooltipElem;

    return tooltipElem;
};
*/
function validate(text,chk){
	return text;
	var checkInhibit=new RegExp('[\<\>\,\'\"\;\:]','g');
	var checkEmail=new RegExp('^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9\-]*[a-z0-9]\.)+ [a-z]{2,4}$/');
//		    var checkEmail=new RegExp('^([a-z0-9_\-]+\.)*[a-z0-9_\-]+(@chel.elektra.ru)$');
	var checkRoom=/^(\d){1,3}([a-z]*)$/;

	
//	var checkSpace=/^(\s)+|(\s)+$/;
	var checkPhone=/^(\d)+\-*(\d)+$/;
	var checkId=/^(\d{7})$/;
	var message;
	var check={'ph':[checkPhone,'ErrPhone'],'id':[checkId,'ErrId'],
	    'rm':[checkRoom,'ErrRoom'],'dp':[checkDep,'ErrDep'],
	    'fn':[checkName,'ErrName'],'em':[checkEmail,'ErrEmail']};
		    try{
				if(text ==''){
					throw("ErrNull");
				}
	//			if(checkSpace.test(text)){
	//			    goodtogo=false;
	//			    throw("ErrSpace");
	//    			}	
				if(checkInhibit.test(text)){
					throw("ErrInhibit");
				}
				if(text.length>128){
					throw("ErrLength");
				}
					if(chk){
						if(!check[chk][0].test(text)){
							throw(check[chk][1]);
						}
					}
		    }
		    catch(e){
				if(e=='ErrNull'){
						message ="input empty";
				}
				if(e=='ErrInhibit'){
						message = "input error: "+text;
	//			    moveCaretToEnd(input);
				}
				if(e=="ErrLength"){
						message = "long string: "+text.length;
	//			    moveCaretToEnd(input);
				}
				if(e=='ErrCount'){
					message ="input more one: "+text;
				}
				if(e=='ErrId'){
					message = "incor id: "+text;
	//			    moveCaretToEnd(input);
				}
				if(e=="ErrSpace"){
					message = "input space: "+text;
				}
				if(e=='ErrEmail'){
					message = "error email: "+text;
	//			    moveCaretToEnd(input);
				}
				if(e=='ErrDep'){
					message = "error dep: "+text;
	//			    moveCaretToEnd(input);
				}
				if(e=='ErrName'){
					message = "error name: "+text;
	//			    moveCaretToEnd(input);
				}
				if(e=='ErrPhone'){
					message = "оerro phone: "+text;
	//			    moveCaretToEnd(input);
				}
				if(e=='ErrRoom'){
					message = "error room: "+text;
	//			    moveCaretToEnd(input);
				}
		    }
		if(message){
			return message;
		} else {
			return false;
		}
}

function SelectDepartment(options){
    var self = this;
    this.elem = options.elem;
    var screenHeight = Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
    this.selected = ko.observable('');
    this.isOpen = ko.observable(false);

    this.options = ko.observableArray(options.options);
    this.value = ko.observable('');
    this.currentIndex = ko.observable(0);

    var elemOffsetTop =0;
    var elemOffsetTop1;


    this.getCurrentIndex = ko.computed(function(){
	    return self.currentIndex();
    }, this);

    this.onOptionClick = function(model, event){
		var event = event || window.event;
		var target = event.target || event.srcElement;
		var optionData = ko.dataFor(target);	
		
		self.currentIndex(optionData.value);
		self.value(self.options()[self.currentIndex()].value);

		elemOffsetTop = $('.custom-select-options li').eq(self.currentIndex()).offset().top;	    
		elemOffsetTop1 = $('.custom-select-options li').eq(0).offset().top;	    

		close();
		var ent = $('#navigatorEnterprise option:selected').text();
		var objSel = document.getElementById('navigatorEnterprise');
				
		var dep = self.getSelectedOption().text;
		getDepartment([ent,dep]);		
    };
//    this.getValue = function(){


    this.setActive = function(event){
        this.isOpen(false);
        var event = event || window.event;
        var target = event.target || event.srcElement;

        var optionData = ko.dataFor(target);
        var value = optionData.value;
        if(value == undefined) return;
        this.value(value);
    };
    
    this.getSelectedOption =  function(){
		var options = self.options();
		for(var i=0;i<options.length;i++){
			if(options[i].value == self.value()) {
			return options[i];
			}
		}
		//return {text:'',value:'select'};
		return options[0];
    };

    this.onTitleClick = function(event){
		toggle();
    };

    function open(){
        self.isOpen(true);
        $(document).on('click', function(e){
            if($(e.target).closest('.custom-select').length) return;
            close();
        });
	    $('#like').val('');
    }
    
    function close(){
        self.isOpen(false);
        $(document).off();
		window.scrollTo(0,0);
    }

    function toggle(){
        if(self.isOpen()){
            close();
        } else {
            open();	    
        }
        return false;
    };
    
    this.onOptionMouseOver  = function(model, event){
		var event = event || window.event;
		var target = event.target || event.srcElement;
		var optionData = ko.dataFor(target);
    };
    
    this.onOptionMouseOut = function(model, event){
    
    };

    this.onTitleKeyDown = function(model, event){
//	var screenHeight = Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
        var KEY_ARROW_UP = 38;
        var KEY_ARROW_RIGHT = 39;
        var KEY_ARROW_DOWN = 40;
        var KEY_ENTER = 13;
        var KEY_ESC = 27;
        var KEY_PAGEUP = 33;
        var KEY_PAGEDOWN = 34;
//	var delta;
        switch(event.keyCode){
            case KEY_ARROW_UP:
            if(!self.isOpen()){
                open();
            } else {				
                if(self.currentIndex() != 0){
            	    self.currentIndex(self.currentIndex()-1);					
                    if($('li.active').offset().top <  getPageScroll().top ){
                        var elemHeight = $('.custom-select-options li.active').outerHeight();
                        window.scrollBy(0,-elemHeight);
                    }
                }

            }
            return false;
            break;
            case KEY_ARROW_RIGHT:
            break;
            case KEY_ENTER:
            if(!self.isOpen()){
				open();
				var deltaDown = screenHeight  - $('li.active').offset().top;
		//
				var elemHeight = $('.custom-select-options li[value='+ self.currentIndex()+ ']').outerHeight();
				if( deltaDown < 0){
					window.scrollBy(0,-(deltaDown+elemHeight));
				}		
            } else {
                self.value(self.options()[self.currentIndex()].value);
				var ent = $('#navigatorEnterprise option:selected').text();
				var dep = self.getSelectedOption().text;
				getDepartment([ent,dep]);				
				
                close();
            }
            break;
            case KEY_ESC:
				 close();
			
            break;
            case KEY_ARROW_DOWN:
            if(!self.isOpen()){
                open();
            } else {
                if(self.currentIndex() != self.options().length-1){
            	    self.currentIndex(self.currentIndex()+1);
				}
				var deltaDown = screenHeight  - $('li.active').offset().top;
				var elemHeight = $('.custom-select-options li.active').outerHeight();
				if( deltaDown < 0){
					window.scrollBy(0,elemHeight);
				}		
            }
            return false;
            break;
            case KEY_PAGEUP:
		self.currentIndex(0);
	    	window.scrollTo(0,0);
            return false;
            break;
            case KEY_PAGEDOWN:
		self.currentIndex(self.options().length-1);
		var newY = $('li.active').offset().top+50;
		window.scrollTo(0,newY);
    	    return false;
            break;
        }
        return true;
    };
    this.updateOptions = function(options){
        self.options(options);
    };		

    ko.applyBindings(this, options.elem[0]);    
};

function ScrollTop(options){
    var self = this;
    var elem = options.elem;
    elem.on('click',onScrollTop);
    function onScrollTop(){
//		window.scrollTo(0,0);
	$('html, body').animate({scrollTop: 0}, 500);
    }
}


$(document).ready(function(){
    if(document.getElementById('control-scroll-top')){
		var scrollTop = new ScrollTop({
			elem: $('#control-scroll-top')
		});
		window.onscroll = function(){
			var pageScroll = getPageScroll().top;
			if(pageScroll >300){
				document.getElementById('control-scroll-top').style.display = 'block';
			} else {
				document.getElementById('control-scroll-top').style.display = 'none';	
			}	
		};
    }
});



function User(){	
	this.count;
	this.id;	
	this.room;
	this.enterprise;
	this.department;
	this.office;
	this.position;
	this.name;
	this.phone;
	this.email;
}

var logs =[];

function Log(){
	this.type;
	this.description;
	this.options;
}





