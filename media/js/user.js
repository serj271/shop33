
window.onload=inter_init;

function inter_init(){
//    $('#job').val("oo");
    $('#job').focus();
//    $('#result table').find('td').each(function(){
	
    


}

function checkForm(text,keyCheck){
//    var text=$('#job').val();
//    var tempA=[];
//    tempA=text.split(/\s/);
    var checkInhibit=new RegExp('[\<\>\,\'\"\;\:]','g');
    var checkRus=new RegExp('[�-�]','i');
//    var checkEmail=new RegExp('^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9\-]*[a-z0-9]\.)+ [a-z]{2,4}$/');
    var checkEmail=new RegExp('^([a-z0-9_\-]+\.)*[a-z0-9_\-]+(@che.mrsk-ural.ru)$');
    var checkRoom=/^(\d){1,3}([�-�]*)$/;
    var checkDep=/^([�-��-�]+)/;
    var checkName=/^([�-��-�a-zA-Z0-9_]+)$/;
    var checkPassword=/^([�-��-�a-zA-Z0-9_]+)$/;    
    var errPassword=/[�-��-�a-zA-Z0-9_]/g;
    var checkSpace=/^(\s)+|(\s)+$/;
    var checkPhone=/^(\d)+\-*(\d)+$/;
    var checkId=/^(\d{7})$/;
    var goodtogo=new Boolean(true);
    var check={'phone':[checkPhone,'ErrPhone'],'id':[checkId,'ErrId'],
	'room':[checkRoom,'ErrRoom'],'department':[checkDep,'ErrDep'],
	'first_name':[checkName,'ErrName'],'email':[checkEmail,'ErrEmail'],'password':[checkPassword,'ErrPassword']};
    if(check.hasOwnProperty(keyCheck)){       //checked key check    
		    try{
			if(text ==''){
			    goodtogo=false;
			    throw("ErrNull");
			}
			if(checkSpace.test(text)){
			    goodtogo=false;
			    throw("ErrSpace");
    			}	
			if(checkInhibit.test(text)){
			    goodtogo=false;
			    throw("ErrInhibit");
			}
			if(text.length>128){
			    goodtogo=false;
			    throw("ErrLength");
			}
//			for(var i in check){
//			    if(i==navigationSelected){
				if(!check[keyCheck][0].test(text)){
				    goodtogo=false;
				    throw(check[keyCheck][1]);
				}
//			    }
//			}
		    }
		    catch(e){
			if(e=='ErrNull'){
	    		    alert("���� ������");
			}
			if(e=='ErrInhibit'){
	    		    alert("������� ������������ �������: "+text);
//			    input.value=text.replace(checkInhibit,'');
//			    moveCaretToEnd(input);
			}
			if(e=="ErrLength"){
	    		    alert("������� ������� ������: "+text.length);
//			    input.value=text.replace(/[^(\d)]/g,'');
//			    moveCaretToEnd(input);
			}
			if(e=='ErrCount'){
			    alert("������� ������ ������ �����: "+text);
//			    input.value=tempA[0];
			}
			if(e=='ErrId'){
			    alert("������������ ��������� �����: "+text);
//			    input.value=text.replace(/[^(\d)]/g,'');
//			    moveCaretToEnd(input);
			}
			if(e=="ErrSpace"){
			    alert("������� ������ �������: "+text);
//			    input.value=text.replace(/^\s+|\s+$/g,'');
			}
			if(e=='ErrEmail'){
			    alert("������������ ���� ������ �����: "+text);
//			    moveCaretToEnd(input);
			}
			if(e=='ErrDep'){
			    alert("������ ����� ������������: "+text);
//			    moveCaretToEnd(input);
			}
			if(e=='ErrName'){
			    alert("������������ ���� : "+text);
//			    moveCaretToEnd(input);
			}
			if(e=='ErrPassword'){
			    alert("������������ password : "+text.replace(errPassword,''));
//			    moveCaretToEnd(input);
			}			
			if(e=='ErrPhone'){
			    alert("������������ ������ ����� ��������: "+text);
//			    moveCaretToEnd(input);
			}
			if(e=='ErrRoom'){
			    alert("������������ ������ �������: "+text);
//			    moveCaretToEnd(input);
			}
		    }
		    if(goodtogo==true){
			return true;
		    } else {
			return false;
		    }
//		}
//	    }
//	}
    } else {
	alert("error key check");
    }
}

function displ(){
    var text=$('#job').val();
//    alert(text);
    if(checkForm('id')){
	alert("OK");
    }
}

function validatePreForm(){
    var text=($('#pre #job').val());
    return checkForm(text,'id');
}

function checkConfirm(p,c){
    if(p==c){
	return true;
    } else {
	alert("��������� ������ �� ���������");
	return false;
    }
}

function validateForm(){
    var email=$("#email").val();
    var username=$("#username").val();
    var password=$("#password").val();
    var password_confirm=$("#password_confirm").val();
    if(checkForm(username,'first_name') && checkForm(email,'email') 
	&& checkForm(password_confirm,'password') && 
	checkForm(password,'password')  && checkConfirm(password,password_confirm)){
//	alert("OK");
	return true;
    }	 
    return false;
}

function checkInput(){
    var text=$('#job').val();
    if(text!=''){
	var checkName=/^([�-��-�]+)/;
	if(checkName.test(text)){
	    var objSelectD=document.getElementById('navigation');
	    for(var i=0;i<objSelectD.options.length;i++){
		if(objSelectD.options[i].value=='first_name'){
		    objSelectD.options[i].selected=true;
		}
	    }
	}
	var checkId=/^(\d{7})$/;
	if(checkId.test(text)){
	    var objSelectD=document.getElementById('navigation');
	    for(var i=0;i<objSelectD.options.length;i++){
		if(objSelectD.options[i].value=='id'){
		    objSelectD.options[i].selected=true;
		}
	    }
	}
	var checkEmail=/@/;
	if(checkEmail.test(text)){
	    var objSelectD=document.getElementById('navigation');
	    for(var i=0;i<objSelectD.options.length;i++){
		if(objSelectD.options[i].value=='em'){
		    objSelectD.options[i].selected=true;
		}
	    }
	}
	var checkRoom=/^(\d){1,3}([�-�]*)$/;
	if(checkRoom.test(text)){
	    var objSelectD=document.getElementById('navigation');
	    for(var i=0;i<objSelectD.options.length;i++){
		if(objSelectD.options[i].value=='rm'){
		    objSelectD.options[i].selected=true;
		}
	    }
	}
    } 
//    else {
//    	var radios=document.getElementsByTagName('input');
//	for(var i=0;i<radios.length;i++){
//	    if(radios[i].type=='radio' && radios[i].name=='ragion'){
//		if(radios[i].value=='all'){
//		    radios[i].checked=true;
//		}	
//	    }
//	}
//    }
    setTimeout('checkInput()',2000);
}







