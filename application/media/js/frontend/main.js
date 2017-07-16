/**
 * Created by .
 * User: 744
 * Date: 02.12.15
 * Time: 12:50
 * To change this template use File | Settings | File Templates.
 */
//'use strict';

var Menu = require('./menu');

var pandaMenu = new Menu({
    title: 'Menu',
    items:[{
	text:"eggs",
	href: '#eggs'
    },{
	text: "meat",
	href: "#meat"
    }]
});

var elem = document.createElement('div');
var menu = document.getElementById('menu');
document.body.appendChild( pandaMenu.elem);