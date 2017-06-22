"use strict";
$(".refresh").on('click',function(){ // Добавляем событие на изображение "обновить" при нажатии
    /** Картинке с кодом присваиваем новое изображение
     *  Math.random() нам нужно для того чтобы не было кеширование картинок
     */
    $("img.captcha").attr("src","/captcha/default?_rnd="+Math.random());
    
    return false;
});






