"use strict";
//personal
var ROOT;
var path = [];
path = location.toString().split('\/');
//var pathAjax = path[0]+'//'+path[2]+'/'+path[3]+'/ajax/'
var pathAjax = path[3];







window.onload=inter_init;

function inter_init(){
	var path =[];	
	path = location.href.toString().split('\/');
//	var ROOT = path[4];
	$('#header ul#menu li').find('a[href="'+'/'+path[3]+'/'+path[4]+'"]').parent().addClass('on');
	$('[data-toggle="tooltip"]').tooltip();
}









