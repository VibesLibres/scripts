<?php
/*
Description : Affiche une donnée dans un DIV et réactualise ce dernier toutes les X secondes
Auteur : Niblischim pour Vibrations Libres
URL : http://vibrationslibres.fr
Licence : GNU GPL v2
*/
?>

var seconds = 10;
var divid = "icecastdiv";
var url = "/scripts/affichertitre.php";

function refreshdiv(){

var xmlHttp;
try{
xmlHttp=new XMLHttpRequest(); // Firefox, Opera 8.0+, Safari
}
catch (e){
try{
xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
}
catch (e){
try{
xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
}
catch (e){
alert("Your browser does not support AJAX.");
return false;
}
}
}

// Timestamp for preventing IE caching the GET request

fetch_unix_timestamp = function()
{
return parseInt(new Date().getTime().toString().substring(0, 10))
}

var timestamp = fetch_unix_timestamp();
var nocacheurl = url+"?t="+timestamp;


xmlHttp.onreadystatechange=function(){
if(xmlHttp.readyState==4){
document.getElementById(divid).innerHTML=xmlHttp.responseText;
setTimeout('refreshdiv()',seconds*1000);
}
}
xmlHttp.open("GET",nocacheurl,true);
xmlHttp.send(null);
}

window.onload = function startrefresh(){
setTimeout('refreshdiv()',seconds*1000);
}
