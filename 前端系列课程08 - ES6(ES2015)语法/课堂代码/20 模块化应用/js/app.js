import {randomcolor} from './randomcolor.js';
import {bigger} from './bigger.js';
import {goright} from './goright.js';

let x = document.getElementById("x");
let y = document.getElementById("y");
let z = document.getElementById("z");
let m = document.getElementById("m");

randomcolor(x,500);
bigger(y,5,300);

randomcolor(z,2000);
bigger(z);

goright(m,5,500);
randomcolor(m);



