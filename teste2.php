<?php
require_once 'init.php';

$code = '<style type="text/css">
  * { box-sizing: border-box; } body {margin: 0;}*{box-sizing:border-box;}body{margin:0;background-image:none;background-repeat:repeat;background-position:left top;background-attachment:scroll;background-size:auto;}.navbar-items-c{display:inline-block;float:right;}.navbar{background-color:#222;color:#ddd;min-height:50px;width:100%;}.navbar-container{max-width:950px;margin:0 auto;width:95%;}.navbar-container::after{content:"";clear:both;display:block;}.navbar-brand{vertical-align:top;display:inline-block;padding:5px;min-height:50px;min-width:50px;color:inherit;text-decoration:none;}.navbar-menu{padding:10px 0;display:block;float:right;margin:0;}.navbar-menu-link{margin:0;color:inherit;text-decoration:none;display:inline-block;padding:10px 15px;}.navbar-burger{margin:10px 0;width:45px;padding:5px 10px;display:none;float:right;cursor:pointer;}.navbar-burger-line{padding:1px;background-color:white;margin:5px 0;}@media fadeEffect{from{opacity:0;}to{opacity:1;}}@media (max-width: 768px){.navbar-burger{display:block;}.navbar-items-c{display:none;width:100%;}.navbar-menu{width:100%;}.navbar-menu-link{display:block;}}
</style>
<div data-gjs="navbar" class="navbar"><div class="navbar-container"><a href="/" class="navbar-brand"></a><div id="irmv" class="navbar-burger"><div class="navbar-burger-line"></div><div class="navbar-burger-line"></div><div class="navbar-burger-line"></div></div><div data-gjs="navbar-items" class="navbar-items-c"><nav data-gjs="navbar-menu" class="navbar-menu"><a href="#" class="navbar-menu-link">Home</a><a href="#" class="navbar-menu-link">About</a><a href="#" class="navbar-menu-link">Contact</a></nav></div></div></div><script>var items = document.querySelectorAll("#irmv");
          for (var i = 0, len = items.length; i < len; i++) {
            (function(){
var e,t=0,n=function(){var e,t=document.createElement("void"),n={transition:"transitionend",OTransition:"oTransitionEnd",MozTransition:"transitionend",WebkitTransition:"webkitTransitionEnd"};for(e in n)if(void 0!==t.style[e])return n[e]}(),r=function(e){var t=window.getComputedStyle(e),n=t.display,r=(t.position,t.visibility,t.height,parseInt(t["max-height"]));if("none"!==n&&"0"!==r)return e.offsetHeight;e.style.height="auto",e.style.display="block",e.style.position="absolute",e.style.visibility="hidden";var i=e.offsetHeight;return e.style.height="",e.style.display="",e.style.position="",e.style.visibility="",i},i=function(e){t=1;var n=r(e),i=e.style;i.display="block",i.transition="max-height 0.25s ease-in-out",i.overflowY="hidden",""==i["max-height"]&&(i["max-height"]=0),0==parseInt(i["max-height"])?(i["max-height"]="0",setTimeout(function(){i["max-height"]=n+"px"},10)):i["max-height"]="0"},a=function(r){if(r.preventDefault(),!t){var a=this.closest("[data-gjs=navbar]"),o=a.querySelector("[data-gjs=navbar-items]");i(o),e||(o.addEventListener(n,function(){t=0;var e=o.style;0==parseInt(e["max-height"])&&(e.display="",e["max-height"]="")}),e=1)}};"gjs-collapse"in this||this.addEventListener("click",a),this["gjs-collapse"]=1
}.bind(items[i]))();
          }</script>
'
;

