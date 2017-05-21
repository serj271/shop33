"use strict";
var ROOT;
var path = [];
path = location.toString().split('\/');
//var pathAjax = path[0]+'//'+path[2]+'/'+path[3]+'/ajax/'
var pathAjax = path[3];

function getName(name,ent){
    var result=new Array();
    var keys=new Array('enterprise','department','office','position','first_name','name_name','last_name','phone1','phone2','email');
    for(var i=0;i<keys.length;i++){
		result[i]=new Array();
    }
    
    $.ajax({
		type: "POST",
		url:"/"+pathAjax+"/ajax/mrsk/getname",
		data:{enterprise:ent,name:name},
		dataType: "json",
		success: function(data,textStatus){
//				$.each(data,function(i,val){
//				results[i].push(val);
			var result =[];
			$.each(data,function(i,val){
				result[i]=val;
				
			});
			
			if(typeof result == 'undefined'){

			} else {
			
				var users = [];
				for(var i=0;i<result['first_name'].length;i++){
						var user = new User();					
						user.enterprise = result['enterprise'][i];
						user.department = result['department'][i];
						user.first_name = result['first_name'][i];
						user.name_name = result['name_name'][i];
						user.last_name = result['last_name'][i];
						user.position = result['position'][i];
						user.office = result['office'][i];						
						user.phone1 = result['phone1'][i];
						user.phone2 = result['phone2'][i];
						user.email = result['email'][i];
						users.push(user);
				}				
				Handlebars.registerHelper('fullName', function() {					
					return this.first_name+" "+this.name_name+" "+this.last_name;
				});				
				var source   = $("#name-table").html();
				var template = Handlebars.compile(source);
				var context = {
					users: users							
				};
//				var html    = template({department:dep,enterprise:ent},users);	
				var html    = template(context);
				$('#result').html(html);
				$('#like').val('');

			}
		}
    });	
}


function getDepartments(ent){
    var results=new Array();
    $.ajax({
		type: "POST",
		url: "/"+pathAjax+"/ajax/mrsk/getdepartments",
		data:{enterprise:ent},
		dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
				results.push(val);
			});
			if(typeof results=='undefined'){
				alert("none departments");
			} else {
				createDepartmentOption(results);	    
			}
		}
    });
}

function getEnterprises(){

    var enterprises=new Array();
    $.getJSON("/"+pathAjax+"/ajax/mrsk/getenterprises",function(data){
		$.each(data,function(key,val){
			enterprises.push(val);
		});	
		createEnterpriseOption(enterprises);    
    });
}

function getOffices(dep){
	var url="mrskGetOfficesXml.php";	
	var out=encodeFormField(dep);
	var data="department="+out+"&ms="+new Date().getTime();
	createOfficeOption(idValues);
}

function getNameFromDepartment(ent,dep){
    var result=new Array();
    var keys=new Array('first_name','name_name','last_name','phone2','phone1','position','office','email');
    for(var i=0;i<keys.length;i++){
		result[i]=new Array();
    }   
    $.ajax({
		type: "POST",
		url:"/"+pathAjax+"/ajax/mrsk/getnamefromdepartment",
		data:{enterprise:ent,department:dep},
		dataType: "json",
		success: function(data,textStatus){
			$.each(data,function(i,val){
				result[i]=val;			
			});
			if(typeof result=='undefined'){
	//		alert("Error departments");
			} else {			
				var users = [];
				for(var i=0;i<result['first_name'].length;i++){
						var user = new User();					
						user.enterprise = ent;
						user.department = dep;
						user.first_name = result['first_name'][i];
						user.name_name = result['name_name'][i];
						user.last_name = result['last_name'][i];
						user.position = result['position'][i];
						user.office = result['office'][i];						
						user.phone1 = result['phone1'][i];
						user.phone2 = result['phone2'][i];
						user.email = result['email'][i];
						users.push(user);
				}				
				Handlebars.registerHelper('fullName', function() {					
					return this.first_name+" "+this.name_name+" "+this.last_name;
				});				
				(function() {
					// Start at 1, name this unique to anything in this closure
					var positionCounter = 1;
					Handlebars.registerHelper('positionCounter', function() {
						return positionCounter++;
					});
					// Compile/render your template here
					// It will use the helper whenever it seems position
				})();
				var source   = $("#department-table").html();
				var template = Handlebars.compile(source);
				var context = {
					users: users,
					department:dep,
					enterprise:ent				
				};
//				var html    = template({department:dep,enterprise:ent},users);	
				var html    = template(context);
				$('#result').html(html);				
			}
	//	createNamesTable(result['position'],result['office'],result['first_name'], result['name_name'],result['last_name'],result['phone1'],result['phone2'],result['email'],dep,ent);		
		}
    });
}

window.onload=inter_init;

function inter_init(){
//    extMessage.style.display='none';
	$('#header ul#menu li').find('a[href="'+'/'+path[3]+'/'+path[4]+'"]').parent().addClass('on'); 
    getEnterprises();
	$('input#like').focus();

}


function createEnterpriseOption(ar){
    var objSelectD=document.getElementById('navigatorEnterprise');
    removeAllOptions(objSelectD);
    for(var i=0;i<ar.length;i++){
	var optn=document.createElement('option');
	optn.text=ar[i];
	optn.value=i;
	objSelectD.options.add(optn);        
    }
    changeEnterprise();
//	var ent = $("#navigatorEnterprise option:selected").text();	
	
	$('#like').typeahead({
		source:  function(query,process){	
			$.ajax({
				url: "/"+pathAjax+"/ajax/mrsk/getnamelike",
				type: 'POST',
				dataType: 'JSON',
				data: {enterprise:$("#navigatorEnterprise option:selected").text(), nameLike:query},
				success: function(data) {
					var result =[];
					$.each(data,function(i,val){
						result.push(val);
					});			
				
					process(result);
				}
			});
		},
		updater: function(item) {
			getName(item, $("#navigatorEnterprise option:selected").text());
			return item;	
		},
		minLength: 1,
		highlighter: function (item) {
			var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&');
				return item.replace(new RegExp('(' + query + ')', 'i'), function ($1, match) {
				return '<strong>' + match + '</strong>'
			})
		}
	
	});	
}


function createDepartmentOption(ar){
    var objSelectD=document.getElementById('navigatorDepartment');
    removeAllOptions(objSelectD);
    for(var i=0;i<ar.length;i++){
		var optn=document.createElement('option');
		optn.text=ar[i];
		optn.value=i;
		objSelectD.options.add(optn);        
    }	
}


function changeEnterprise(){
    var objSelectD=document.getElementById('navigatorEnterprise');
    if(objSelectD.selectedIndex != -1){

		getDepartments(objSelectD.options[objSelectD.selectedIndex].text);
	$('input#like').val('');
    }
}

function createOfficeOption(ar){
    var objSelectD=document.getElementById('navigatorOffice');
    removeAllOptions(objSelectD);
    for(var i=0;i<ar.length;i++){
		var optn=document.createElement('option');
		optn.text=ar[i];
		optn.value=i;
		objSelectD.options.add(optn);        
    }
    changeOffice();
}


function changeDepartment(){
    var objSelectD=document.getElementById('navigatorDepartment');
    var departmentSelected = objSelectD[objSelectD.selectedIndex].text;
    var objSelect=document.getElementById('navigatorEnterprise');
    var enterpriseSelected=objSelect[objSelect.selectedIndex].text;

	$('input#like').val('');
    if(objSelect.selectedIndex != -1){
//    deleteLi();
//    document.getElementById('like').value='';
		getNameFromDepartment(enterpriseSelected,departmentSelected);
    }
}

function removeAllOptions(selectbox){
    for(var i=selectbox.options.length-1;i>=0;i--){
		selectbox.remove(i);
    }
}

function changeNavigator(){
    deleteLi();
    document.getElementById('like').value='';
    temp='';
}

function visibleExtDepMessage(){
//    var text=document.createTextNode('');
    var extMessage=document.getElementById('ext');
//    extMessage.appendChild(text);
    extMessage.className='prompt';
    extDep.style.display='visible';
}

function User(){		
	this.enterprise;
	this.department;
	this.office;
	this.position;
	this.first_name;
	this.name_name;
	this.last_name;
	this.phone1;
	this.phone2;
	this.email;
}





