import {randcolor} from './randcolor.js';
import {addwidth} from './addwidth.js';


var box1 = document.getElementById("box1");
var box2 = document.getElementById("box2");
var box3 = document.getElementById("box3");

//让box1变色
randcolor(box1,1000);

//让box2逐渐变大
addwidth(box2,2,500);

//box3
randcolor(box3,2000);
addwidth(box3,1,100);


