
var w3c = (document.getElementById) ? true : false; 
var agt = navigator.userAgent.toLowerCase(); 
var ie = ((agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1) && (agt.indexOf("omniweb") == -1)); 
var mymovey = new Number(); 
function IeTrueBody(){ 
	return (document.compatMode && document.compatMode!="BackCompat") ? document.documentElement : document.body;
 } 
function GetScrollTop(){ 
	return ie ? IeTrueBody().scrollTop : window.pageYOffset; 
} 
function heartBeat(){ 
	diffY=GetScrollTop(); 
	mymovey += Math.floor((diffY-document.getElementById('backi').style.top.replace("px","")+170)*0.1); 
	document.getElementById('backi').style.top = mymovey+"px"; 
	} 
	
function close_float_left(){document.getElementById('backi').style.visibility='hidden';}

function WriteQqStr()
{
	document.write('<DIV id=backi style="RIGHT:20px; OVERFLOW: visible; POSITION: absolute;TOP:200px;border:1px solid #ddd;background-color: white;z-index:9">');
	document.write('<table border="0" cellpadding="0" cellspacing="0" width="55">');
	document.write("<tr><td align=center><img src=\"/en/images/qqkefu/session.gif\"></td></tr>");
	document.write("<tr><td align=center><br><a target=\"_blank\" href=\"https://api.whatsapp.com/send?phone=8617512016913\" ><IMG src=\"/en/images/qqkefu/whatsapp.gif\" border=0></a></td></tr>");
	document.write("<tr><td align=center><br><a target=\"_blank\" href=\"#\" ><IMG src=\"/en/images/qqkefu/facebook.png\" border=0></a></td></tr>");
	document.write("<tr><td align=center><br><a target=\"_blank\" href=\"skype:zhumerchant?chat\"><IMG src=\"/en/images/qqkefu/skype.gif\" border=0></a><br><br></td></tr>");
	document.write("<tr><td align=center><a target=\"_blank\" href=\"mailto:stic1688@163.com\"><IMG src=\"/en/images/qqkefu/email.png\" border=0></a><br><br></td></tr>");
	document.write('</table>');
	document.write('</DIV>');
}

WriteQqStr();
window.setInterval("heartBeat()",1); 

