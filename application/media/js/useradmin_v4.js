"use strict";
//kohana

/* ---- Begin integration of Underscore template engine with Knockout. Could go in a separate file of course. ---- */
    ko.underscoreTemplateEngine = function () { }
    ko.underscoreTemplateEngine.prototype = ko.utils.extend(new ko.templateEngine(), {
        renderTemplateSource: function (templateSource, bindingContext, options) {
            // Precompile and cache the templates for efficiency
            var precompiled = templateSource['data']('precompiled');
            if (!precompiled) {
                precompiled = _.template("<% with($data) { %> " + templateSource.text() + " <% } %>");
                templateSource['data']('precompiled', precompiled);
            }
            // Run the template and parse its output into an array of DOM elements
            var renderedMarkup = precompiled(bindingContext).replace(/\s+/g, " ");
            return ko.utils.parseHtmlFragment(renderedMarkup);
        },
        createJavaScriptEvaluatorBlock: function(script) {
            return "<%= " + script + " %>";
        }
    });
    ko.setTemplateEngine(new ko.underscoreTemplateEngine());
/* ---- End integration of Underscore template engine with Knockout ---- */


ko.bindingHandlers.logger = {
        update: function(element, valueAccessor, allBindings) {
            //store a counter with this element
            var count = ko.utils.domData.get(element, "_ko_logger") || 0,
                data = ko.toJS(valueAccessor() || allBindings());

            ko.utils.domData.set(element, "_ko_logger", ++count);

            if (console && console.log) {
                console.log(count, element, data);
            }
        }
};


 ko.subscribable.fn.logIt = function(name) {
        this.triggeredCount = 0;
        this.subscribe(function(newValue) {
            if (console && console.log) {
                console.log(++this.triggeredCount, name + " triggered with new value", newValue);
            }
        }, this);

        return this;
    };




var ROOT = '/kohana/useradmin';
var path = [];
path = location.toString().split('\/');
//var pathAjax = path[0]+'//'+path[2]+'/'+path[3]+'/ajax/'


function getEnterpriseLike(ent){
    var results=new Array();
    $.ajax({
	type: "POST",
	url:"/kohana/ajax/useradmin/getenterpriselike",
	data:{enterpriseLike:ent},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
			results.push(val);
			});
//			debugger;
			$('body').triggerHandler({
			    type: 'updateList',
			    value: results
			});	
		}
    });
}

function getRoomLike(like,ent){
    var results=new Array();
    $.ajax({
	type: "POST",
	url:"/kohana/ajax/useradmin/getroomlike",
	data:{enterprise:ent,roomLike:like},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
				results.push(val);
			});
			
			$('body').triggerHandler({
				type: 'updateList',
				value: results
			});	
		}
    });
}

function getDepLike(like){
    var results=new Array();
    $.ajax({
	type: "POST",
	url:"/kohana/ajax/useradmin/getdeplike",
	data:{depLike:like},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
				results.push(val);
			});
			$('body').triggerHandler({
				type: 'updateList',
				value: results
			});	
		}
    });
}

function getOfficeLike(like){
    var results=new Array();
    $.ajax({
	type: "POST",
	url:"/kohana/ajax/useradmin/getofficelike",
	data:{ofLike:like},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
			results.push(val);
			});
//			debugger;
			$('body').triggerHandler({
				type: 'updateList',
				value: results
			});	
		}
    });
}
function getGroupLike(like){
    var results=new Array();
    $.ajax({
	type: "POST",
	url:"/kohana/ajax/useradmin/getgrouplike",
	data:{groupLike:like},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
				results.push(val);
			});
			$('body').triggerHandler({
				type: 'updateList',
				value: results
			});	
		}
    });
}
function getPositionLike(like){
    var results=new Array();
    $.ajax({
	type: "POST",
	url:"/kohana/ajax/useradmin/getposlike",
	data:{posLike:like},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
				results.push(val);
			});
	

			$('body').triggerHandler({
				type: 'updateList',
				value: results
			});	
		}
 
 });
}

function getNameLike(like){
    var results=new Array();
    $.ajax({
	type: "POST",
	url:"/kohana/ajax/useradmin/getnamelike",
	data:{nameLike:like},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
				results.push(val);
			});		
			$('body').triggerHandler({
				type: 'updateList',
				value: results
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




function getDepFulltext(t,ent){
    var results=new Array();
    $.ajax({
	type: "POST",
	url:"/kohana/ajax/useradmin/getdepfulltext",
	data:{enterprise:ent,text:t},
	dataType: "json",
        success: function(data,textStatus){
            $.each(data,function(i,val){
            results.push(val);
            });
            if(results.length==0){
            var o=document.getElementById('divShow');
            if(o !=null){
                o.parentNode.removeChild(o);
            }
    //		$('body').triggerHandler({
    //		    type: 'updateList',
    //		    value: results
    //		});
            } else {
            $('body').triggerHandler({
                type: 'updateListDep',
                value: results
                });
            }
        }
    });
}

function getEnterprises(){
    var enterprises=new Array();
//    var r = [];
//    r =  ROOT.split('\/');
    var str = '/'+path[3]+'/ajax/useradmin/getenterprises/';
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
	url:"/kohana/ajax/useradmin/getdeps",
	data:{enterprise:ent},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
			results.push({text:val,value:i});
			});
			if(typeof results=='undefined'){

			} else {
	//		createDepartmentOption(results);	    
//			selectEnterprise.updateOptions(results);
			}
		}
    });
}

function getLastNameLike(like){
    var results=new Array();
    $.ajax({
	type: "POST",
	url:"/kohana/ajax/useradmin/getlastname",
	data:{like:like},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
			results.push(val);
			});

			$('body').triggerHandler({
			    type: 'updateList',
			    value: results
			});	
		}
    });
}

function getAll(ent){	
    var results=new Array();
    $.ajax({
	type: "POST",
	url:"/kohana/ajax/useradmin/getdepartments",
	data:{enterprise:ent},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
				results.push({value:i,text:val});
			});
			if(typeof results=='undefined'){

			} else {
	//		createDepartmentOption(results);
				if(selectEnterprise){
					selectEnterprise.updateOptions(results);
				}
				
			}
		}
    });
}

function getServices(ent){
    var results=new Array();
    $.ajax({
	type: "POST",
	url:"/kohana/ajax/useradmin/getservices",
	data:{enterprise:ent},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
			results.push({text:val,value:i});
			});
			if(typeof results=='undefined'){

			} else {
	//		createDepartmentOption(results);	    
			selectEnterprise.updateOptions(results);
			}
		}
    });
}

function getDepartment_(ar){//tn - tab number for market
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
	url:"/kohana/ajax/useradmin/getnamebydepartment",
	data:{enterprise:ent,department:dep},
	dataType: "json",
		success: function(data,textStatus){
			console.log(data);
			$.each(data,function(i,val){
			result[i]=val;		
			
			});
			if(typeof result=='undefined'){

			} else {
			
			
			var namesA=[];
			var namesId=[];
			var namesName=[];
			var namesRoom=[];
			var namesPosition=[];
			var namesPhone=[];
			var namesEmail=[];
			var namesOffice=[];		
			for(var i=0;i<result['id'].length;i++){			
			namesId.push(result['id'][i]);
				namesName.push(result['first_name'][i]+' '+result['name_name'][i]+' '+result['last_name'][i]);
				namesPhone.push(result['phone'][i]);
				namesEmail.push(result['email_zimbra'][i]);
				namesPosition.push(result['position'][i]);
				namesOffice.push(result['office'][i]);
				namesRoom.push(result['room'][i]);
	//		    namesEnterprise.push(result['enterprise'][i]);
	//		    namesDepartment.push(result['department'][i]);
			}
//			createDepartmentTable(namesName,namesPosition,namesOffice,namesPhone,namesEmail,namesRoom,
//			namesId,dep,ent,tn);
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
	url:"/kohana/ajax/useradmin/getgovernances",
	data:{enterprise:ent},
	dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
			results.push({text:val,value:i});
			});
			if(typeof results=='undefined'){

			} else {
	//		createDepartmentOption(results);
			selectEnterprise.updateOptions(results);
			}
		}
    });
}

window.onload=inter_init;

var activeEnable = false;
var selectEnterprise;

function inter_init(){

    $('#header ul#menu li').find('a[href="'+ROOT+'"]').parent().addClass('on');
	
	function myViewModel(){
		this.people = ko.observableArray([{id:'i',name:'Jhon',position:'pp',
            enterprise:'e',department:'d',office:'o',phone:'p',group:'g',email:'e'}]),
        this.show = function(){
            alert('f');
        }
	}
/*
    var viewModel = {
        people: ko.observableArray([
            { name: 'Rod', age: 123 },
            { name: 'Jane', age: 125 },
        ]),
        show: function(){
            alert('f');
        }

    };
*/
//ko.applyBindings(viewModel,document.getElementById('divShow'));



//	ko.applyBindings(new myViewModel(), document.getElementById('divShow')	
	
    var autocomplete = new Autocomplete({
	elem: $('#search'),
	provider: dataProvider
    });
    $(autocomplete).on('changeAutocomplete',function(e){
		if(showingTooltip){    
			document.body.removeChild(showingTooltip);
			showingTooltip = null;
		}
		showCompletion(e.value);
    });
    function showCompletion(value){
		var enterpriseSelected = $('#navigatorEnterprise option:selected').html();
		var navigatorSearch = $('#navigatorSearch option:selected').val();
		if(navigatorSearch=='room'){
			getRoom(value,enterpriseSelected);
			} else 	if(navigatorSearch=='first_name'){
			getName(value,enterpriseSelected);
		}	
	
		if(navigatorSearch=='enterprise'){
//			getDepartment([enterpriseSelected, value]);
			$('#result td.enterprise input').val(value);
		}
		if(navigatorSearch=='department'){
//			getDepartment([enterpriseSelected, value]);			
			$('#result td.department input').val(value);
		}
		if(navigatorSearch=='office'){
//			getDepartment([enterpriseSelected, value]);
			$('#result td.office input').val(value);
		}
		if(navigatorSearch=='group'){
//			getDepartment([enterpriseSelected, value]);
			$('#result td.group input').val(value);
		}
		if(navigatorSearch=='position'){
//			getDepartment([enterpriseSelected, value]);
			$('#result td.position textarea').val(value);
		}
		if(navigatorSearch=='name_name'){
//			getDepartment([enterpriseSelected, value]);
			$('#result td.name_name input').val(value);
		}
		if(navigatorSearch=='last_name'){
//			getDepartment([enterpriseSelected, value]);
			$('#result td.last_name input').val(value);
		}
		
		
//	input.focus();
    }

	
    selectEnterprise = new Choice({
	options: [{text:'Select', value:'select'}],
	elem: $('#enterprise-select')
    });

//    getEnterprises();
   
    if(document.all  && document.querySelector ){ 
		activeEnable = true;
		document.onmouseout = function(e){
			if(showingTooltip){    
				document.body.removeChild(showingTooltip);
			showingTooltip = false;
			}
		};
		document.onmouseover = function(e){
			var e = e || event;
			var target = e.target || e.srcElement;
			while(target != this){
			var tooltip = target.getAttribute('data-tooltip');
			if(tooltip) break;
			target = target.parentNode;
			}
			if(!tooltip) return;
			showingTooltip = showTooltip(tooltip, target);
		};
    } else if(!document.all){ 
		activeEnable = true;
		document.onmouseout = function(e){
			var e = e || event;
			var target = e.target || e.srcElement;
			while(target != this){
				var tooltip = target.getAttribute('data-tooltip');
				if(tooltip) break;
				target = target.parentNode;
			}
			if(!tooltip) return;
			if(showingTooltip){
				document.body.removeChild(showingTooltip);
				showingTooltip = false;
			}

		};
		document.onmouseover = function(e){
			var e = e || event;
			var target = e.target || e.srcElement;
			while(target != this){
			var tooltip = target.getAttribute('data-tooltip');
			if(tooltip) break;
			target = target.parentNode;
			}
			if(!tooltip) return;
			if(!showingTooltip){
				showingTooltip = showTooltip(tooltip, target);
			}
		};
    }
    $('.autocomplete input').focus();
	
	
//	var source = $('#department-table').html();
//	var template = Handlebars.compile(source);
//	$('#divShow').html(template(data));

}

	var tooltipMessages ={name:'Сортировать по фамилии',
						position:'Сортировать по должности',
						office:'Сортировать по подразделению',
						phone:'Сортировать по номеру телефона',
						email:'Сортировать по Email',
						room:'Сортировать по номеру комнаты',
						id:'Сортировать по табельному номеру',
						department:'Сортировать по депертаменту'};
	

function createRoomTable(ids,rs,ents,deps,pos,ns,phs,ems){
//ids,rs,ents,deps,pos,ns,phs,ems
    $('#result').hide();
    var o=document.getElementById('divShow');
    if(o !=null){
	o.parentNode.removeChild(o);
    }
    var newDiv=document.createElement('div');
    newDiv.id="divShow";
    var tbl=document.createElement("table");
    tbl.setAttribute("border","2px");
    tbl.setAttribute("cellpadding","2px");
    tbl.setAttribute("cellspacing","2px");
    var tblBody=document.createElement("tbody");
    tblBody.id="tblBodyResult";
    
    row=document.createElement("tr");
    cell=document.createElement("th");
    cell.setAttribute('colSpan','6');
    var headValue=document.createTextNode(ents[0]);
    cell.appendChild(headValue);
    row.appendChild(cell);
    tblBody.appendChild(row);        
    
    row=document.createElement("tr");
    cell=document.createElement("th");
    cell.setAttribute('colSpan','6');
    headValue=document.createTextNode("лПНО "+rs[0]);
    cell.appendChild(headValue);
    row.appendChild(cell);
    tblBody.appendChild(row);    

    var row,cell,cellText,str,linktarget,el;
    row=document.createElement("tr");
    var names = ["name","position","department","phone", "email","N"];
//    var sizes=["160","160","160","130","80","160","50"];
    var actions = ['name','position','department','phone','email','id'];
    //var tooltipMessages =["sort by first_name","sort by position",
    //"sort by department", "sort by phone","sort by Email",
    //"sort by id"];  
    for(var i=0;i<names.length;i++){
		cell=document.createElement("td");
		cellText=document.createTextNode(names[i]);
		cell.appendChild(cellText);
		addClass(cell,'sortCell');
		if(actions[i]){
			cell.setAttribute('data-action',actions[i]);
		}
		cell.setAttribute('data-tooltip',tooltipMessages[i]);
		row.appendChild(cell);
    }
    row.className='columnHeader';
    tblBody.appendChild(row);
    tblBody.appendChild(row);
    tbl.appendChild(tblBody);
    newDiv.appendChild(tbl);
    document.getElementById('result').appendChild(newDiv);

    var tblBody=document.getElementById('tblBodyResult');
    for(var i=0;i<ids.length;i++){	
		var row=document.createElement("tr");
		row.className='programmed';
		cell=document.createElement("td");
		if(ns[i]==''){
			ns[i]=' ';
		}
		cellText=document.createTextNode(ns[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);
		
		cell=document.createElement("td");
		if(pos[i]==''){
			pos[i]=' ';
		}
		cellText=document.createTextNode(pos[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);
		
		cell=document.createElement("td");
	//	cell.style.fontWeight="bold";
		cellText=document.createTextNode(deps[i]);	
		var data=[];
		data.push(ents[i],deps[i],ids[i]);//enteprise,department,id
		cell.className='active';
		cell.onclick=(function(n){
			return function(){
			getDepartment(n);
			};
		})(data);
		cell.setAttribute('data-tooltip',deps[i]);

		cell.appendChild(cellText);
		row.appendChild(cell);

		cell=document.createElement("td");
		cellText=document.createTextNode(phs[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);
		
		cell=document.createElement("td");
		if(ems[i]==''){
			ems[i]=' ';
		}
		cellText=document.createTextNode(ems[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);
		cell=document.createElement("td");
		cellText=document.createTextNode(ids[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);
		tblBody.appendChild(row);
    }
    if(activeEnable){
	activeSort();	
    }
    $('#result').slideDown(300);
}

function createNamesLike(ids,rs,es,ds,os,ps,ns,phs,ems,fnv){
    var o=document.getElementById('divShow');
    if(o !=null){
	o.parentNode.removeChild(o);
    }
    var newDiv=document.createElement('div');
    newDiv.id="divShow";
    var tbl=document.createElement("table");
    tbl.setAttribute("border","2px");
    tbl.setAttribute("cellpadding","2px");
    tbl.setAttribute("cellspacing","2px");
    var tblBody=document.createElement("tbody");
    var row,cell,celltext,str,linktarget,el,link;
    row=document.createElement("tr");
    cell=document.createElement("th");
    cell.setAttribute('colSpan','8');
    cell.setAttribute('id','headValue');
    var headValue=document.createTextNode(es[0]);
    cell.appendChild(headValue);
    row.appendChild(cell);
    tblBody.appendChild(row);
    row=document.createElement("tr");
    var names=["name","position","office","department","phone","Email","room","N"];
    var actions = ['name','position','department','phone','email','id'];
    for(var i=0;i<names.length;i++){
		cell=document.createElement("td");
		var cellText=document.createTextNode(names[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);
    }
    row.className='columnHeader';
    tblBody.appendChild(row);
    for(var i=0;i<ids.length;i++){
		var row=document.createElement("tr");
		row.className='programmed';
		cell=document.createElement("td");
		var fn=ns[i].split(' ')[0];
		var nn=ns[i].split(' ')[1];	
		var ln=ns[i].split(' ')[2];
		var b=document.createElement('b');
		cellText=document.createTextNode(fn);
		b.appendChild(cellText);
		cell.appendChild(b);
		cell.appendChild(document.createTextNode(' '+nn+' '+ln));
		row.appendChild(cell);
			
		cell=document.createElement("td");
		if(ps[i]==''){
			ps[i]=' ';
		}
		cellText=document.createTextNode(ps[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);
		
		cell=document.createElement("td");
		if(os[i]==''){
			os[i]=' ';
		}
		cellText=document.createTextNode(os[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);

		cell=document.createElement("td");
		cellText=document.createTextNode(ds[i]);
		cell.appendChild(cellText);
	//	cell.display='block';
	//	cell.style.fontWeight="bold";
		var data=[];
		data.push(es[i],ds[i],ids[i]);//enteprise,department,id
		cell.className='active';
		cell.onclick=(function(n){
			return function(){
			clearResult();
			getDepartment(n);
			};
		})(data);
		cell.setAttribute('data-tooltip',ds[i]);
		row.appendChild(cell);
		cell=document.createElement("td");
		if(phs[i]==''){
			phs[i]=' ';
		}
		cellText=document.createTextNode(phs[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);	
		
		cell=document.createElement("td");
		if(ems[i]==''){
			ems[i]=' ';
		}
		cellText=document.createTextNode(ems[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);
		
		cell=document.createElement("td");
		if(rs[i]==''){
			rs[i]=' ';
		}
		cellText=document.createTextNode(rs[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);
		
		cell=document.createElement("td");
		cellText=document.createTextNode(ids[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);

		tblBody.appendChild(row);
    }
    tbl.appendChild(tblBody);
    newDiv.appendChild(tbl);
    document.getElementById('result').appendChild(newDiv);
}

function createNameRow(c){//c= count current of search name
//    $('#result').hide();
    var ids;var rms;var ens;var dps;var ofs;var prs;var ps;var nms;var phs;var ems;
// 
    var o=document.getElementById('divShow');
    if(o !=null){
		o.parentNode.removeChild(o);
    }
    var newDiv=document.createElement('div');
    newDiv.id="divShow";
    var tbl=document.createElement("table");
    tbl.setAttribute("border","2px");
    tbl.setAttribute("cellpadding","2px");
    tbl.setAttribute("cellspacing","2px");
    var tblBody=document.createElement("tbody");
    var row,cell,celltext,str,linktarget,el,link;
    var keys=new Array('position','party','office','department','phone','email','room','id');
    for(var i=0;i<fNamesA[c]['id'].length;i++){
		row=document.createElement("tr");
		row.className='programmed';
		cell=document.createElement("td");
		cell.setAttribute('colSpan','8');
		cell.setAttribute('align','center');
		var cellText=document.createTextNode(fNamesA[c]['first_name'][i]+' '+fNamesA[c]['name_name'][i]+' '+fNamesA[c]['last_name'][i]);
		cell.appendChild(cellText);
		cell.className='resultSearch';
		row.appendChild(cell);
		tblBody.appendChild(row);

		row=document.createElement("tr");
		var names=["position","group","office","department","phone","Email","room","N"];
		for(var k=0;k<names.length;k++){
			cell=document.createElement("td");
			cellText=document.createTextNode(names[k]);
			cell.appendChild(cellText);
			row.appendChild(cell);
		}
		row.className='columnHeader';
		tblBody.appendChild(row);

		row=document.createElement("tr");
		row.className='programmed';

		for(var j=0;j<keys.length;j++){    
			cell=document.createElement("td");
			cellText=document.createTextNode(fNamesA[c][keys[j]][i]);
			if(fNamesA[c][keys[j]][i]!=''   ){
			cell.appendChild(cellText);
			} else {
			cell.appendChild(document.createTextNode(' '));
			}
			row.appendChild(cell);

			if(keys[j]=='department'){
			var data=[];
			data.push(fNamesA[c]['enterprise'][i],fNamesA[c]['department'][i],fNamesA[c]['id'][i]);//enteprise,department,id
			addClass(cell, 'active');
			cell.setAttribute('data-tooltip',fNamesA[c]['department'][i]);
			cell.onclick=(function(n){
				return function(){
				clearResult();
				getDepartment(n);
				};
			})(data);
			cell.display='block';
			}
		}
		tblBody.appendChild(row);
    }
    tbl.appendChild(tblBody);
    newDiv.appendChild(tbl);
    document.getElementById('result').appendChild(newDiv);
//    $('#result').slideDown();
//    console.log("K");
}

function createDepartmentTable(nms,pos,ofs,phs,ems,rms,ids,dep,ent,tn){//tn-tab number for marker
	//alert('dep');
   $('#result').hide();
    var o=document.getElementById('divShow');
    if(o !=null){
		o.parentNode.removeChild(o);
    }
    var newDiv=document.createElement('div');
    newDiv.id="divShow";
    var tbl=document.createElement("table");
    var tblBody=document.createElement("tbody");
    tblBody.id="tblBodyResult";
    var row,cell,celltext,str,linktarget,el,headValue,idTab;
    
    row=document.createElement("tr");
    cell=document.createElement("th");
    cell.setAttribute('colSpan','8');
    headValue=document.createTextNode(ent);
    cell.appendChild(headValue);
    row.appendChild(cell);
    tblBody.appendChild(row);
    
    row=document.createElement("tr");
    cell=document.createElement("th");
    cell.setAttribute('colSpan','8');
    headValue=document.createTextNode(dep);
    cell.appendChild(headValue);
    row.appendChild(cell);
    tblBody.appendChild(row);
    
    row=document.createElement("tr");

    var names=["N ","name","position","office","phone","Email","room","id N"];
    var actions = ['','name','position','office','phone','email','room','id'];

    for(var i=0;i<names.length;i++){
		cell=document.createElement("td");
		var link = document.createElement('a');
		link.href = '#';
		link.style.display = 'block';
		var data=[];
		data.push(dep,ent,tn,i);
		cell.className = 'active';
		var cellText=document.createTextNode(names[i]);
		if(tooltipMessages[actions[i]]){
			cell.setAttribute('data-tooltip',tooltipMessages[actions[i]]);
		}
	//	var p =document.createElement("p");
	//	p.appendChild(cellText);
		if(actions[i]){
			cell.setAttribute('data-action',actions[i]);//type of sort
		}	
		cell.appendChild(cellText);
		addClass(cell,'columnHeader');
		row.appendChild(cell);
		}
		tblBody.appendChild(row);
		tbl.appendChild(tblBody);
		newDiv.appendChild(tbl);
		document.getElementById('result').appendChild(newDiv);
		var tblBody=document.getElementById('tblBodyResult');
		for(var i=0;i<ids.length;i++){
		var row=document.createElement("tr");
		if(tn==ids[i]){//searchId
			addClass(row, 'searchResult');
		}
		addClass(row, 'programmed');
		cell=document.createElement("td");
	//	cellText=document.createTextNode(outA[i].number);
		cellText=document.createTextNode(i+1);
		cell.appendChild(cellText);
		row.appendChild(cell);
		cell=document.createElement("td");
		cellText=document.createTextNode(nms[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);
		cell=document.createElement("td");
			cellText=document.createTextNode(pos[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);
		cell=document.createElement("td");
	//	if(outA[i].office!=''){
			cellText=document.createTextNode(ofs[i]);
	//	} else {
	//	    cellText=document.createTextNode(' ');
	//	}
		cell.appendChild(cellText);
		row.appendChild(cell);	
		cell=document.createElement("td");
		cellText=document.createTextNode(phs[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);
		cell=document.createElement("td");
		cellText=document.createTextNode(ems[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);
		cell=document.createElement("td");
		cellText=document.createTextNode(rms[i]);
		cell.appendChild(cellText);
		row.appendChild(cell);
		cell=document.createElement("td");
	//	if(outA[i].email!=''){
			cellText=document.createTextNode(ids[i]);
	//	} else {
	//	    cellText=document.createTextNode(' ');	    
	//	}
		cell.appendChild(cellText);
		row.appendChild(cell);
		tblBody.appendChild(row);
    }
    if(activeEnable){
	activeSort();
    }
    $('#result').slideDown(300);
}

//var namesA=[];
//var count=0;//count current search of name

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
/*
function MenuNamesResult_(options){
    var elem = options.elem;
    var self = this;

    elem.on('click','.menu-delete',onDeleteClick);
    elem.on('click','.menu-title', onTitleClick);

    function onTitleClick(e){
	var el = $(e.currentTarget).parent();
	if(el.hasClass('menu-open')){
	    self.close(el);
	}  else {
	    self.open(el);
	}
	return false;
    }
    var idsOpen =[];

    this.open = function(el){
    	var info = el.children('.menu-info').html();
	var id = _.last(info.split(' '));
	menuPosition[id]='menu-open';
	el.removeClass('menu-close');
        el.addClass('menu-open');
    };
    this.close = function(el){
    	var info = el.children('.menu-info').html();
	var id = _.last(info.split(' '));
	menuPosition[id] = 'menu-close';
	el.removeClass('menu-open');
	el.addClass('menu-close');
    };
    
    function onDeleteClick(e){
	var elemMenu = $(e.currentTarget).parent();
	deleteMenu(elemMenu);
	return false;
    }
    function deleteMenu(elemMenu){
	var info = elemMenu.children('.menu-info').html();
	var id = _.last(info.split(' '));
	var position = fNamesA['id'].indexOf(id);	
	if(position!=null){
	    for(var i=0;i<keys.length;i++){
		fNamesA[keys[i]].splice(position,1);
	    }
	    elemMenu.remove();
	}
        if(showingTooltip){
    	    document.body.removeChild(showingTooltip);
    	    showingTooltip = false;
	}
    }
}
*/



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
    if(entSel){
	for(var i=0;i<objSelectD.options.length;i++){
//	    if(objSelectD.options[i].value==entSel){
	    if(i==0){
		objSelectD.options[i].setAttribute('selected','selected');	
//	    }
	    }
	}
    }
//    changeEnterprise();
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
    var navigatorEnterprise = $('#navigatorEnterprise option:selected').html();
    $('.autocomplete ol').children().remove();
    $('.autocomplete').removeClass('open');
    var navSel=$("#navigatorSearch option:selected").val();
    var text = $('.autocomplete input').val();
    var reg=new RegExp('[<>:;\/\'\"]','g');
    text=text.replace(reg,'');
    $('.autocomplete input').val(text);
    createDivisionOptions();
    if(text !=''){
		if(navSel =='first_name'){
			getNameLike(text,navigatorEnterprise);
		} 
		if(navSel =='department'){
		var o=document.getElementById('divShow');
		if(o !=null){
			o.parentNode.removeChild(o);
		}
		getDepFulltext(text,navigatorEnterprise);
		}
		if(navSel =='room'){
			var o=document.getElementById('divShow');
			if(o !=null){
			o.parentNode.removeChild(o);
			}
			getRoomLike(text,navigatorEnterprise);	    	    
		}
    } 
//    $('.autocomplete input').focus();           
//    changeDepartment();
}

function changeSearch(){
    $('.autocomplete input').val('');
    $('.autocomplete input').focus();           
    $('.autocomplete').removeClass('open');
    var o=document.getElementById('divShow');
    if(o !=null){
		o.parentNode.removeChild(o);
    }
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
}

function changeDepartment(){
    var objSelectD=document.getElementById('navigatorDepartment');
    var departmentSelected = objSelectD[objSelectD.selectedIndex].text;
    var objSelect=document.getElementById('navigatorEnterprise');
    var enterpriseSelected = objSelect[objSelect.selectedIndex].text;
    $('.autocomplete input').val('');
//    var input = document.getElementById('autocomplete');
//    input.value='';
//    alert($('.autocomplete input').val());
    $('.autocomplete').removeClass('open');
    var ar =[];
    ar.push(enterpriseSelected);
    ar.push(departmentSelected);
    getDepartment(ar);
    var departmentValue=objSelectD[objSelectD.selectedIndex].value; 
    createCookie('departmentValue',departmentValue,5);
}

function deleteLi(){
    var ulSearch=document.getElementById('ulSearch');
    var lis=document.getElementsByTagName('li');
    while(ulSearch.childNodes[1]){
	ulSearch.removeChild(ulSearch.childNodes[1]);        
    }
//    document.getElementById('like').value='';
    
}

function changeNavigator(){
//    deleteLi();
//    document.getElementById('like').value='';
//    temp='';
    $('.autocomplete input').val('');
    $('.autocomplete ol').empty();
    $('.autocomplete').removeClass('open');
    $('.autocomplete input').focus();
}
function clearResult(){
    $('.autocomplete input').val('');
    $('.autocomplete ol').empty();
    $('.autocomplete').removeClass('open');
    if(showingTooltip){
	document.body.removeChild(showingTooltip);
	showingTooltip = false;
    }
}


var showingTooltip;

    
function showTooltip(text,elem){
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

function Autocomplete(options){
    var self = this;
    var elem = options.elem;
    var provider = options.provider;
    var input = $('input', elem);    
    var list;
    input.on({
		focus: onInputFocus,
		blur: onInputBlur,
		keydown: onInputKeyDown
    });
    var inputCheckTimer;
    elem.on('click','.nameLi', onLiClick);
//    elem.on('click','.nextEnterpriseLi',onNextEnterpriseClick);
//    elem.on('click','.depLi', onDepLiClick);
    var endSearch = false;
    
    function onNextEnterpriseClick(e){
		nextEnterprise();
		changeEnterprise();
    }
    
    function onLiClick(e){
		list.liSelect($(e.target));
		self.setValue(list.get() || input.val());
		list.clear();	
		input.blur();
		
    }
    function onDepLiClick(e){
		list.liSelect($(e.target));
		self.setValue(list.get() || input.val());
		list.clear();	
		input.blur();
		
    }	
    
    $('body').on('updateList',function(e){
		provider.updateStrings(e.value);
		if(e.value){
			updateList();
		} else {
			list.clear();
		}
    });    
    $('body').on('updateListDep',function(e){
		provider.updateStrings(e.value);
		updateListDep();
    });    

    function onInputKeyDown(e){
		var KEY_ARROW_UP = 38;
		var KEY_ARROW_RIGHT = 39;
		var KEY_ARROW_DOWN = 40;
		var KEY_ENTER = 13;
		var KEY_ESC = 27;
		var KEY_PAGEUP = 33;
		var KEY_PAGEDOWN = 34;

		switch(e.keyCode){
			case KEY_ARROW_UP:
			list.up();
			return false;
			break;
			case KEY_ARROW_RIGHT: 
			if(list.get()){
				self.setValue(list.get(), true);
			}
			break;
			case KEY_ENTER:
			self.setValue(list.get() || input.val());
			list.clear();
			if(list.get()){
			   self.setValue(list.get(), true);
	//		    showCompletion(list.get());	
			}
			input.blur();
			break;
			case KEY_ESC:
				input.val('');
			inputValue='';
			list.clear();
			break;
			case KEY_ARROW_DOWN:
			list.down();
			return false;
			break;
			case KEY_PAGEUP:
			prevEnterprise();
			changeEnterprise();
			return false;
			break;
			case KEY_PAGEDOWN:
			nextEnterprise();
			changeEnterprise();
			return false;
			break;
		}

    }
	
	function onInputFocus(){
		var inputValue = input.val();
		function checkInput(){
			if(inputValue != input.val()){
				if(!list){
					initList();
				}
				if(input.val()!=''){
					var enterpriseSelected = $('#navigatorEnterprise option:selected').html();
					var navigatorSearch = $('#navigatorSearch option:selected').val(); 
					switch(navigatorSearch){
//						case 'first_name': 
//							getFirstNameLike(input.val(), enterpriseSelected);
//						break;
						case 'name_name':
							getNameLike(input.val());		
						break;
						case 'last_name':
							getLastNameLike(input.val());		
						break;
						case  'room':
							getRoomLike(input.val());
						break;
						case 'enterprise':
							getEnterpriseLike(input.val());		
						break;
						
						case 'department':
							getDepLike(input.val());		
						break;
						case 'office':
							getOfficeLike(input.val());		
						break;
						case 'group':
							getGroupLike(input.val());		
						break;
						case 'position':
							getPositionLike(input.val());		
						break;
					}
					list.clear();	
					list.update(input.val());
		//			if(input.val().length > inputValue.length &&  list.getCount()==1){
		//			    self.setValue(list.get(), true);
		//			}
					inputValue = input.val();
					provider.updateStrings('');
				}
			}
		}	
		inputCheckTimer = setInterval(checkInput, 10);
    } 	
	
    function initList(){
		list = new AutocompleteList(provider);
		list.render().appendTo(elem);
		$(list).on('update1',onListUpdate);
    }
    function updateList(){
		if(list){
			list.update(input.val());
		}
    }
    function updateListDep(){
		if(list){
			list.updateDep(input.val());
		}
    }
    
    function onListUpdate(e){
		if(e.values.length){
			elem.addClass('open');
		} else {
			elem.removeClass('open');
		}
    }
    var inputValue='';
   
    function onInputBlur(){
	clearInterval(inputCheckTimer);
//	if(list){
//	    list.clear();
//	}
    }	
    this.setValue = function(value, quiet){
//	input.val(value);
//	inputValue=value;
	inputValue='';
	input.val('');
	if(!quiet){
	    $(self).triggerHandler({
		type: 'changeAutocomplete',
		value: value
	    });
	}
    }
}

function AutocompleteList(provider){
    var elem;
    var filteredResults;
    var currentIndex = 0;
    this.render = function(){
		elem = $('<ol/>');
		return elem;
    };
    var self = this;
    var count;
    
    this.update = function(value){
		filteredResults = provider.filterByStart(value);
		count = filteredResults.length;
		if(filteredResults.length){
			elem.html('<li class="nameLi">'+filteredResults.join('</li><li class="nameLi" >')+'</li>');
//			var text="Продолжить поиск в следующем предприятии";
//			elem.append('<li class="nextEnterpriseLi" >'+text+'</li>');
		} else {
			elem.empty();
		}
		currentIndex =0;
		renderCurrent();
		$(this).triggerHandler({
			type: 'update1',
			values: filteredResults
			});
    };	
    this.updateDep = function(value){
		filteredResults = provider.getStrings(value);
		if(filteredResults.length){
			elem.html('<li class="depLi">'+filteredResults.join('</li><li class="depLi">')+'</li>');
		} else {
			elem.empty();
		}
		currentIndex =0;
		renderCurrent();
		$(this).triggerHandler({
			type: 'update1',
			values: filteredResults
		});
    };	
    
    function renderCurrent(){
		elem.children().eq(currentIndex).addClass('selected');
    }
    function clearCurrent(){
		elem.children().eq(currentIndex).removeClass('selected');
    }
    this.get = function(){
		return filteredResults[currentIndex];
    };
    this.down = function(){
	if(currentIndex == filteredResults.length -1) return;
		clearCurrent();
		currentIndex++;
		renderCurrent();
    };
    this.up = function (){
		if(currentIndex == 0) return;
		clearCurrent();
		currentIndex--;
		renderCurrent();
    };
    this.clear = function(){
//	this.update('');
		elem.empty();
		$('.autocomplete').removeClass('open');
    };
    this.liSelect = function(li){
		clearCurrent();
		li.addClass('selected');
		currentIndex = li.index();
    }
	this.getCount = (function(){
		return function(){
			return count;
		};
    })();
}

var dataProvider = new FilteringListProvider([
]);

function FilteringListProvider(strings){
    var self = this;    
    this.strings = strings;
    this.get = function(index){
		return self.strings[index];
    };
    this.filterByStart = function(stringStart){
	if(stringStart.length < 1) return [];
		if(self.strings.length<1) return [];
		
		var stringStartLC = stringStart.toLowerCase();
		return self.strings.filter(function(str){
			var strLC = str.toLowerCase();
		
			return  strLC.slice(0, stringStartLC.length) == stringStartLC && 
			strLC != stringStartLC;
		});
    }
    this.getStrings = function(){
	    return self.strings;
    }
    this.updateStrings = function(value){
		self.strings = value;
    }
}

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

function Person(id,first_name,name_name,last_name,enterprise,department,office,group,position,phone,phone1,email){
	var self = this;
	this.id = id;	
	this.name = first_name+' '+name_name+' '+last_name;	
	this.department = department;
	this.enterprise = enterprise;
	this.office = office;
	this.group = group;
	this.position = position;
	this.phone = phone;
	this.phone1 = phone1;
	this.email = email;	
}
function Result(){
	var self = this;
}
function ViewPeople(){
    var self = this;
	this.people = ko.observableArray([]),
    this.push = function(obj){
        self.people.push(obj);
    }
    this.sortBy = ko.observable('name');
    this.show = function(){
        alert('ff');
    }
    this.isVisible = ko.observable(false);
    this.sort = function(data, event){
        var sort = event.target.getAttribute('data-sort');
        switch(sort){
            case 'name':
                self.people.sort(function(a,b){
                    var x = a.name.toLowerCase();
                    var y = b.name.toLocaleLowerCase();
                    return( x<y ? -1 : (x>y) ? 1:0);
                })
            break;
            case 'office':
                self.people.sort(function(a,b){
                    var x = a.office.toLowerCase();
                    var y = b.office.toLocaleLowerCase();
                    return( x<y ? -1 : (x>y) ? 1:0);
                })
            break;
            case 'position':
                self.people.sort(function(a,b){
                    var x = a.position.toLowerCase();
                    var y = b.position.toLocaleLowerCase();
                    return( x<y ? -1 : (x>y) ? 1:0);
                 })
            break;
            case 'phone':
                self.people.sort(function(a,b){
                    var x = a.phone;
                    var y = b.phone;
                    return( x<y ? -1 : (x>y) ? 1:0);
                })
            break;
            case 'email':
                self.people.sort(function(a,b){
                    var x = a.email.toLowerCase();
                    var y = b.email.toLocaleLowerCase();
                    return( x<y ? -1 : (x>y) ? 1:0);
                })
            break;
        }


    };
}

function  Choice(options){
    var self = this;
    this.elem = options.elem;
//	this.persons = ko.observableArray([]);
    var screenHeight = Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
    this.selected = ko.observable('select');
    this.isOpen = ko.observable(false);
//    console.log(options);
    this.options = ko.observableArray(options.options);
    this.value = ko.observable('select');
    this.currentIndex = ko.observable(0);
//    var elemOffsetTop  = $('.custom-select').offset().top;
    var elemOffsetTop =0;
    var elemOffsetTop1;
//	this.sortBy = ko.observable('name');
//	this.test = ko.observable('h');
	
	
//    console.log(elemOffsetTop);

    this.getCurrentIndex = ko.computed(function(){
	    return self.currentIndex();
    }, this);

    this.onOptionClick = function(model, event){
		var event = event || window.event;
		var target = event.target || event.srcElement;
		var optionData = ko.dataFor(target);	
		
		self.currentIndex(optionData.value);
		self.value(self.options()[self.currentIndex()].value);

	//	elemOffsetTop = $('.custom-select-options li').eq(self.currentIndex()).offset().top;	    
	//	elemOffsetTop1 = $('.custom-select-options li').eq(0).offset().top;	    
//		console.log(elemOffsetTop);	
		close();
		var ent = $('#navigatorEnterprise option:selected').text();
		var dep = self.getSelectedOption().text;
		self.getDepartment([ent,dep]);		
    };
//    this.getValue = function(){

	

	this.getDepartment = function (ar){//tn - tab number for market
		var ent = ar[0];
		var dep = ar[1];
		var tn = ar[2];
		var result=new Array();
		var keys=new Array('id','room','first_name','name_name','last_name','phone','phone1','position','office','email','email_zimbra');
	//	for(var i=0;i<keys.length;i++){
	//		result[i]=new Array();
	//	}
	//	self.persons.removeAll();
         var viewPeople = new ViewPeople();
		$.ajax({
			type: "POST",
			url:"/kohana/ajax/useradmin/getnamebydepartment",
			data:{enterprise:ent,department:dep},
			dataType: "json",
			success: function(data,textStatus){
			//	console.log(data);
				$.each(data,function(i,val){

					result[i]=val;					
				});								
				for(var i=0;i<result['id'].length;i++){			
					viewPeople.push(new Person(result['id'][i],result['first_name'][i],result['name_name'][i],result['last_name'][i],
					result['enterprise'][i],
					result['department'][i],result['office'][i],result['party'][i],result['position'][i],
					result['phone'][i], result['phone1'][i],result['email_zimbra'][i]));

                }
			//	console.log(self.persons());
//				createDepartmentTable(namesName,namesPosition,namesOffice,namesPhone,namesEmail,namesRoom,
//				namesId,dep,ent,tn)
//				ko.applyBindings(self.persons(), document.getElementById('person'));
			    viewPeople.isVisible(true);

                ko.applyBindings(viewPeople, document.getElementById('divShow'));
			}
		});
	}

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
		return {text:'Select',value:'select'};
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
	    $('.autocomplete input').val('');
//	    $('.autocomplete input').focus();           
	    $('.autocomplete').removeClass('open');
	
		
		var currentIndex = self.currentIndex();
		var deltaDown = screenHeight  - self.elem.find('li').eq(currentIndex).offset().top;
		var elemHeight = self.elem.find('li').eq(currentIndex).outerHeight();
		
		if( deltaDown < 0){
			window.scrollBy(0,-deltaDown + elemHeight);
		}		
    }
    
    function close(){
        self.isOpen(false);
        $(document).off();
		window.scrollTo(0,0);
    }

    function toggle(){
//	self.isOpen(!self.isOpen());
        if(self.isOpen()){
            close();
//	    elemOffsetTop = $('.custom-select-options li[value='+ self.currentIndex()+ ']').offset().top;	    
        } else {
            open();
//	    var currentIndex = self.currentIndex();
//	    var deltaDown = screenHeight  - $('.custom-select-options li').eq(currentIndex).offset().top;
//	    var elemHeight = $('.custom-select-options li[value='+ self.currentIndex()+ ']').outerHeight();
//	    if( deltaDown < 0){
//		window.scrollBy(0,-deltaDown-elemHeight);
//	    }		
	    
        }
        return false;
    };
    
    this.onOptionMouseOver  = function(model, event){
	var event = event || window.event;
	var target = event.target || event.srcElement;
	var optionData = ko.dataFor(target);
//	self.currentIndex(self.options.indexOf(optionData));
//	self.value(self.options()[self.currentIndex()].value);
//	console.log(this.currentIndex);
//	var deltaDown = screenHeight  - $('li.active').offset().top;
//	var elemHeight = $('.custom-select-options li.active').outerHeight();
//	if( deltaDown < 30){
//	    $(event).priventDefault();
//	    $(event).stopPropagation();
//	    window.scrollBy(0,elemHeight);
//	    $(event).priventDefault();
//	    $(event).stopPropagation();
//	}		
//	if($('li.active').offset().top <  getPageScroll().top ){
//	    var elemHeight = $('.custom-select-options li.active').outerHeight();
//	    window.scrollBy(0,-elemHeight);		    
//	} 

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
                close();
            }
            break;
            case KEY_ESC:
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
//	console.log("L");
		window.scrollTo(0,0);
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
				document.getElementById('controlScrollTop').style.display = 'block';
			} else {
				document.getElementById('controlScrollTop').style.display = 'none';	
			}	
		};
    }
});


function MenuNamesResult(options){
    var elem = options.elem;
    var self = this;

    elem.on('click','.menu-delete',onDeleteClick);
    elem.on('click','.menu-title', onTitleClick);

    function onTitleClick(e){
	var el = $(e.currentTarget).parent();
	if(el.hasClass('menu-open')){
	    self.close(el);
	}  else {
	    self.open(el);
	}
	return false;
    }
    var idsOpen =[];

    this.open = function(el){
    	var info = el.children('.menu-info').html();
	var id = _.last(info.split(' '));
	menuPosition[id]='menu-open';
	el.removeClass('menu-close');
        el.addClass('menu-open');
    };
    this.close = function(el){
    	var info = el.children('.menu-info').html();
	var id = _.last(info.split(' '));
	menuPosition[id] = 'menu-close';
	el.removeClass('menu-open');
	el.addClass('menu-close');
    };
    
    function onDeleteClick(e){
	var elemMenu = $(e.currentTarget).parent();
	deleteMenu(elemMenu);
	return false;
    }
    function deleteMenu(elemMenu){
	var info = elemMenu.children('.menu-info').html();
	var id = _.last(info.split(' '));
	var position = fNamesA['id'].indexOf(id);	
	if(position!=null){
	    for(var i=0;i<keys.length;i++){
		fNamesA[keys[i]].splice(position,1);
	    }
	    elemMenu.remove();
	}
        if(showingTooltip){
    	    document.body.removeChild(showingTooltip);
    	    showingTooltip = false;
	}
    }
}









