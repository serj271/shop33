
window.onload=inter_init;

function inter_init(){
/*
    try{
	if(window.addEventListener){
	    window.addEventListener("keydown", onInputKeyDown, true);
	} else if(document.attachEvent){ //IE
	    
	    document.attachEvent("onkeydown", onInputKeyDown);
	} else {
	    document.addEventListener("keydown", onInputKeyDown, true);
	}
    } catch(e){
	alert(e);
    }
*/
//    document.onkeydown = function(e){
//	history.back();
//	var event = e || window.event;
//	alert(event.which);
//	onInputKeyDown(event);
//    };
/*
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
		break;
	    case KEY_ARROW_RIGHT: 
		break;
	    case KEY_ENTER:
		break;
	    case KEY_ESC:
		alert("K");
		window.history.go(-1);
		break;
	    case KEY_ARROW_DOWN:
		break;
	    case KEY_PAGEUP:
		break;
	    case KEY_PAGEDOWN:
		break;
	}
    }
*/
}

