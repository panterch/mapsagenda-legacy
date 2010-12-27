      <?php
	  
// MAPS 
// XML GENERATOR EINGABE
// 2008 (m@marcelbamert.ch)

 require("config.php");
	

	  
$selektion=array();
$selektion2=array();
$monatsthemen= array();


// Alle Dateien im Pfad aufmachen und Einträge in den Array $selektion schreiben
$fp=opendir($datapfad);
while ($datei = readdir($fp)) {
if($datei!=".." && $datei!="." && substr_count( $datei, "de" )==1 && substr_count( $datei, "week" )==0){

$tag=substr($datei,8,2);
$monat=substr($datei,5,2);
$jahr=substr($datei,0,4);

// Wenn an 7. Stelle ein Bindestrich = kein Monatsthema
if(substr($datei,7,1)=="-"){
// Innerhalb des Zeitrahmens?
if(mktime(0, 0, 0, $monat,$tag,  $jahr)< 10+mktime(0, 0, 0, $_POST[date10_month],$_POST[date10_date],  $_POST[date10_year]) && mktime(0, 0, 0, $monat,$tag,  $jahr) > mktime(0, 0, 0, $_POST[date9_month],$_POST[date9_date],  $_POST[date9_year])-10){

array_push ($selektion,$datei);


}

}else{ // Monatsthema

//if(mktime(0, 0, 0, $monat,'1',  $jahr)-60*60*24*45< mktime(0, 0, 0, $_POST[date10_month],$_POST[date10_date],  $_POST[date10_year]) && mktime(0, 0, 0, $monat,'28',  $jahr)+60*60*24*45 > mktime(0, 0, 0, $_POST[date9_month],$_POST[date9_date],  $_POST[date9_year])){
//array_unshift ($selektion2,$datei);

if($jahr==$_POST[date9_year] && $monat==$_POST[date9_month]){

echo "//$datei";
$monatsth=$datei;
}



}

}
}
sort($selektion);
if($monatsth){
array_push ($selektion,$monatsth);
}


function cleanme($input){ // Zeichen formatieren für HTML ausgabe
$output=htmlspecialchars($input, ENT_QUOTES);
//$output=htmlentities($output);
/*
$output = addslashes("-*,,-".$output);

$output=ereg_replace('"','',$output);

$output = ereg_replace(chr(34),"",$output);
*/

$output=ereg_replace("„","\"",$output);

$output=ereg_replace("“","\"",$output);

return $output;

}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MAPS - generator</title>
<style type="text/css">
<!--
.titel {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color:#CC3300;
	text-decoration: underline;
}
.untertitel {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #333333;
	text-decoration: underline;
}
.kleintitel {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bolder;
	color: #CC0000;
}
.formular {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #990000;
	border: 1px solid #000000;
}
.link{
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #990000;
	text-decoration:none;
}

.link:hover{
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color:#660000;
	text-decoration:overline;
}

body,td,th {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color:#000000;
}
.klein {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color:#000000;
}
.buttons{
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color:#FFFFFF;
	background-color:#660000;
	margin: 0px;
}
.gruen {color: #33CC00}
.rot {color: #990000}
.listcontent{
display:none;
}
-->
</style>
<SCRIPT LANGUAGE="JavaScript" SRC="CalendarPopup.js"></SCRIPT>

<SCRIPT LANGUAGE="JavaScript">document.write(getCalendarStyles());</SCRIPT>
</head>

<body>
<script type="text/javascript" src="wz_tooltip.js"></script>
<table width="900" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="8" rowspan="3">&nbsp;</td>
    <td width="224" valign="top"><br />
      <a href="index.php" class="titel">
  MAPS AGENDA<br />
XML - GENERATOR
    </a><br /><br />&nbsp;
</td>
    <td width="521" valign="top">&nbsp;</td>
    <td width="147" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="untertitel"><FORM action="index.php" method="post" name="datumwahl">
<p>1. Zeitraum w&auml;hlen:
</p>

Von

<SCRIPT LANGUAGE="JavaScript" ID="js9">
var cal9 = new CalendarPopup("testdiv1");
cal9.setReturnFunction("setMultipleValues1");
function setMultipleValues1(y,m,d) {
	document.forms[0].date9_year.value=y;
	document.forms[0].date9_month.value=m;
	document.forms[0].date9_date.value=d;
	}
</SCRIPT>


<INPUT TYPE="text" NAME="date9_date" VALUE="<? echo $_POST[date9_date] ?>" SIZE=3 class="formular">.
<INPUT TYPE="text" NAME="date9_month" VALUE="<? echo $_POST[date9_month] ?>" SIZE=3 class="formular">.
<INPUT TYPE="text" NAME="date9_year" VALUE="<? echo $_POST[date9_year] ?>" SIZE=5 class="formular">&nbsp;
<A HREF="#" onClick="cal9.showCalendar('anchor9'); return false;" TITLE="cal9.showCalendar('anchor9'); return false;" NAME="anchor9" ID="anchor9" class="link">w&auml;hlen</A><br /><br />
Bis &nbsp;

<SCRIPT LANGUAGE="JavaScript" ID="js10">
var cal10 = new CalendarPopup("testdiv1");
cal10.setReturnFunction("setMultipleValues2");
function setMultipleValues2(y,m,d) {
	document.forms[0].date10_year.value=y;
	document.forms[0].date10_month.value=m;
	document.forms[0].date10_date.value=d;
	}
</SCRIPT>


<INPUT TYPE="text" NAME="date10_date" VALUE="<? echo $_POST[date10_date] ?>" SIZE=3 class="formular">.
<INPUT TYPE="text" NAME="date10_month" VALUE="<? echo $_POST[date10_month] ?>" SIZE=3 class="formular">.
<INPUT TYPE="text" NAME="date10_year" VALUE="<? echo $_POST[date10_year] ?>" SIZE=5 class="formular">
&nbsp;<A HREF="#" onClick="cal10.showCalendar('anchor10'); return false;" TITLE="cal10.showCalendar('anchor10'); return false;" NAME="anchor10" ID="anchor10" class="link">w&auml;hlen</A><br />
<br />
<a href="javascript: document.datumwahl.submit()" class="titel">  weiter</a><br>

</FORM>
<DIV ID="testdiv1" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></DIV></td>
    <td valign="top" ><FORM action="xml_create.php" method="post" name="hauptformular">
    <?
	if($_POST[date10_date]!=""){
	
	
	?>
<script language="javascript">
<!--
function toggle(control)
{
//for (var i = 1; i <= <? echo count($selektion); ?>; i++){

//if(control=="a"+i){
document.getElementById(control).style.display = "block";

//}else{
//document.getElementById("a"+i).style.display = "none";
//}
//}

}
//-->
</script>
      <p class="untertitel">2. Eintr&auml;ge w&auml;hlen:  </p>
        <span class="untertitel"><?
		echo  "Zeitraum ".$_POST[date9_date].".".$_POST[date9_month].".".$_POST[date9_year]." bis ".$_POST[date10_date].".".$_POST[date10_month].".".$_POST[date10_year];
		?></span>&nbsp;&nbsp;&nbsp;Ausw&auml;hlen: <a href="#" onClick="checkAll(true)"  class="link">alle</a> <a href="#" onClick="checkAll(false)"  class="link">keine</a>
  <br />
        <br />
      
           

      <table width="474" border="0" cellspacing="0" cellpadding="0">


<?
$bcount=0;


	
foreach ($selektion as $key => $val) {
$bcount++;
	
$getxml = simplexml_load_file($datapfad.$val);


if(substr($val,7,1)!="-"){
$monatsthema=1;
}else{
$monatsthema=0;
}

if($monatsthema==1){
?>

<tr>
          <td width="23%" class="kleintitel" VALIGN="bottom">Monatsthema <? echo substr($val,5,2).".".substr($val,0,4) ?></td>
          <td class="kleintitel" VALIGN="bottom"><? echo $getxml->title[0] ?></td>
        
<td width="10%" align="right" class="kleintitel"  VALIGN="bottom"  colspan="2" >

MT w&auml;hlen <input type="checkbox" name="monatsthema[]" id="<? echo strlen($getxml->desc[0].$getxml->location[0]) ?>" value="<? echo $val ?>" class="formular"  onClick="zaehlen(0)">
         </td>
        </tr><?

}else{

?>
<tr>
          <td width="23%" class="kleintitel" VALIGN="bottom"><? echo substr($val,8,2).".". substr($val,5,2).".".substr($val,0,4) ?></td>
          <td class="kleintitel" VALIGN="bottom"><? echo $getxml->title[0] ?></td>
         <td width="19%" align="right" VALIGN="bottom" class="kleintitel">
<span id="a<? echo $bcount ?>" name="a<? echo $bcount ?>" class="listcontent">bildtext <input type="checkbox" name="bildtexte[]" id="checkbox" class="formular" value="<? echo $val ?>"><br>gross <input type="checkbox" name="gross[]" id="checkbox" class="formular" value="<? echo $val ?>" onClick="zaehlen(0)"> </span>
</td>
<td width="10%" align="right" class="kleintitel"  VALIGN="bottom">

<input type="checkbox" name="xmllist[]" id="<? echo strlen($getxml->desc[0].$getxml->location[0]) ?>" value="<? echo $val ?>" class="formular" onClick="zaehlen(<? echo $bcount ?>)">
         </td>
        </tr>
<?
}
?>
        <tr>
          <td colspan="4" height="1" bgcolor="#000000"></td>
          </tr>
     
          
        <tr><?

/*
          <td colspan="2" width="350"><span class="td" onmouseover="Tip('<span class=klein><? echo cleanme($getxml->desc[0]) ?></span>',DELAY, 0,BGCOLOR, '#FFFFFF', WIDTH,300)" onmouseout="UnTip()"><? echo substr($getxml->desc[0],0,90); ?>...</span><br />&nbsp;</td>
*/
?>
          <td colspan="2" width="350"><span class="td"><? echo $getxml->desc[0] ?></span><br />&nbsp;</td>

          <td colspan="2" valign="top" style="padding-left:5px">&Uuml;bersetzungen: <?
          	$count=0;
			$gruen="";
			$rot="";
		  foreach ($sprachen as $spr => $arr) {
			
			if(file_exists($datapfad.str_replace ( "de" , $spr,  $val))){
			$count++;
			$gruen.=$arr[1]."<br>";
			}else{
			$rot.=$arr[1]."<br>";
			}
			}
			
			?><span class="<?
            if($count >= count($sprachen)){
			echo "gruen";}else{ echo"rot";}
			?>" onmouseover="Tip('<span class=gruen><? echo $gruen ?></span><span class=rot><? echo $rot ?></span>',DELAY, 0,BGCOLOR, '#FFFFFF')" onmouseout="UnTip()"><? echo $count."/".count($sprachen); ?></span><br />
            Ort: <? 
if($getxml->location[0]!="" ){
?><span class="gruen"  <?

/* 
onmouseover="Tip('<span class=klein><? echo cleanme($getxml->location[0])?></span>',DELAY, 0,BGCOLOR, '#FFFFFF', WIDTH,200)" onmouseout="UnTip()"
*/

?> >vorhanden</span><?
 }else{ ?>
 <span class="rot">fehlt</span>
 <?
 }?>
 

            
			
			
		


            
            </td>
          </tr>
          

<?


}

echo "<INPUT TYPE='hidden' name='v1' value='$_POST[date9_date]'>\n";
echo "<INPUT TYPE='hidden' name='v2' value='$_POST[date9_month]'>\n";
echo "<INPUT TYPE='hidden' name='v3' value='$_POST[date9_year]'>\n";
echo "<INPUT TYPE='hidden' name='b1' value='$_POST[date10_date]'>\n";
echo "<INPUT TYPE='hidden' name='b2' value='$_POST[date10_month]'>\n";
echo "<INPUT TYPE='hidden' name='b3' value='$_POST[date10_year]'>\n";

?>
      
        
      </table>
   <a href="javascript: document.form.submit()" class="titel"> <br />
   </a>
    </FORM>
    
    <?
    
	}
	
	?></td>
    <td valign="top"><?
    if($_POST[date10_date]!=""){
	?><p class="untertitel">3. Ausgabe:</p>
     <span style="text-decoration:underline">Insgesamt </span><br />
	<Span Id="total_anl" ></Span> Eintr&auml;ge<br />
    ca. <Span Id="total_zahl" ></Span> Zeichen<br />
    <br />
     <span style="text-decoration:underline">aktuelle Auswahl</span> <br />
	<Span Id="akt_anl" ></Span> Eintr&auml;ge<br />
    ca. <Span Id="akt_zahl" ></Span> Zeichen<br />
	<Span Id="akt_ein" ></Span> Eintr&auml;ge gross<br />
	<Span Id="mt_zahl" ></Span> Monatsthema<br />
	
    
    <script language="JavaScript">

<!-- Begin
zaehlen(0);
function zaehlen(control){




var total_anl=0;
var total_zahl=0;
var akt_zahl=0;
var akt_anl=0;
var akt_ein=0;
var mt=0;


	var mm = document.getElementsByName("monatsthema[]");
  for (var i=0; i<mm.length; i++){
 if( mm[i].checked ==true){
mt++;
	}
	}

	var cb = document.getElementsByName("xmllist[]");

  for (var i=0; i<cb.length; i++){
    	total_anl++;
         total_zahl=total_zahl+cb[i].id*1;
 if( cb[i].checked ==true){
  	akt_zahl=akt_zahl+cb[i].id*1;
  	akt_anl++;
	document.getElementById("a"+(i*1+1)).style.display = "block";
    }else{

	document.getElementById("a"+(i*1+1)).style.display = "none";
}
}

var cb1 = document.getElementsByName("gross[]");
  for (var i=0; i<cb1.length; i++){
 if( cb1[i].checked ==true){
  	akt_ein++;
    }
}


document.getElementById("mt_zahl").innerHTML=formatZahl(mt,0,0);
document.getElementById("akt_zahl").innerHTML=formatZahl(akt_zahl,0,0);
document.getElementById("total_zahl").innerHTML=formatZahl(total_zahl,0,0);
document.getElementById("akt_anl").innerHTML=formatZahl(akt_anl,0,0);
document.getElementById("total_anl").innerHTML=formatZahl(total_anl,0,0);
document.getElementById("akt_ein").innerHTML=formatZahl(akt_ein,0,0);

}
  
  
  function checkAll(switcher) {
	var cb = document.getElementsByName("xmllist[]");
  for (var i=0; i<cb.length; i++)
  	if (cb[i].type.indexOf(cb) != 1) cb[i].checked = switcher;

	zaehlen(0);
}


// usage: format_zahl( number [, number]  [, bool]  )
function formatZahl(zahl, k, fix)
{
    if(!k) k = 0;
    var neu = '';
    // Runden
    var f = Math.pow(10, k);
    zahl = '' + parseInt( zahl * f + (.5 * (zahl > 0 ? 1 : -1)) ) / f ;
    // Komma ermittlen
    var idx = zahl.indexOf('.');
    // fehlende Nullen einfÃ¼gen
    if(fix)
    {
         zahl += (idx == -1 ? '.' : '' )
         + f.toString().substring(1);
    }
    // Nachkommastellen ermittlen
    idx = zahl.indexOf('.');
    if( idx == -1) idx = zahl.length;
    else neu = ',' + zahl.substr(idx + 1, k);
    // Tausendertrennzeichen
    while(idx > 0)
    {
        if(idx - 3 > 0)
        neu = '\'' + zahl.substring( idx - 3, idx) + neu;
        else
        neu = zahl.substring(0, idx) + neu;
        idx -= 3;
    }
    return neu;
}

//  End -->

</script>



    <br />
<br />
<a href="javascript: document.hauptformular.submit()" class="titel">
    XML ausgeben</a><?
    
	}
	
	?></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>


</body>
</html>
