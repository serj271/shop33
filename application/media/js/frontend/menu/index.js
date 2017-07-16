/**
 * Created by .
 * User: 744
 * Date: 02.12.15
 * Time: 13:09
 * To change this template use File | Settings | File Templates.
 */
'use strict';
require('./menu.css');

let template = require("./menu.pug");//pug-loader!

module.exports =  class Menu {
    constructor(options){
        this.elem = document.createElement('div');
        this.elem.className = 'menu';
        this.elem.innerHTML = template(options);
        this.titleElem = this.elem.querySelector('.title');
        this.titleElem.onclick = () => this.elem.classList.toggle('open');
//        this.title.elem.onmousedown = () => false;
//        this.elem.onClick = () => this.onTitleClick();
    }

    onTitleClick(event){
        let item = event.target;
        item.classList.toggle('open');
    }

}