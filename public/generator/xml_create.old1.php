<?php

// MAPS 
// XML GENERATOR AUSGABE
// 2008 (m@marcelbamert.ch)


 require("config.php");
	 
header('Content-type: text/xml');
header('Content-Disposition: attachment; filename="maps_'.$_POST['v1'].'.'.$_POST['v2'].'.'.$_POST['v3'].'-'.$_POST['b1'].'.'.$_POST['b2'].'.'.$_POST['b3'].'.xml"');



echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<Root><Tag1><Table xmlns:aid5="http://ns.adobe.com/AdobeInDesign/5.0/" aid5:tablestyle="ts" xmlns:aid="http://ns.adobe.com/AdobeInDesign/4.0/" aid:table="table" aid:trows="300" aid:tcols="2"><?

// JEDE SPRACHE
 foreach ($sprachen as $spr =>$value) {
 	sprachstart($value[1]);
 	// JEDEN EINTRAG
	foreach($_POST[xmllist] as $value){
	
		if(file_exists($datapfad.str_replace ( "de" , $spr,  $value))){
		eintrag(str_replace ( "de" , $spr,  $value));	
		}
	}
}


?>



<?php
function sprachstart($sprache){

?>
<Tag2 aid:table="cell" aid:crows="1" aid:ccols="2" aid:ccolwidth="450" aid:pstyle="sprache"><![CDATA[<? echo $sprache; ?>]]></Tag2>
<?
}

function eintrag($value){
$getxml = simplexml_load_file("../../code/data/".$value);
if($getxml->title[0]!=""){
//echo "<event><lang>".$getxml->lang[0]."</lang><datum>".substr($datei,8,2).".". substr($value,5,2).".". substr($datei,0,4)."</datum><title>".$getxml->title[0]."</title><desc>".$getxml->desc[0]."</desc><url>".$getxml->url[0]."</url></event>\n";
?>
<Tag2 aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="50" aid5:cellstyle="cs"><title aid:pstyle="datum"><? echo substr($value,8,2).".". substr($value,5,2)."." ?></title></Tag2><Tag2 aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="350" aid5:cellstyle="cs"><title aid:pstyle="titel"><![CDATA[<? echo $getxml->title[0] ?>]]></title></Tag2>
<Tag2 aid:table="cell" aid:crows="1" aid:ccols="2" aid:ccolwidth="500" aid:pstyle="inhalt"><![CDATA[<? echo trim($getxml->desc[0]); ?>]]></Tag2>
<? 
if($getxml->location[0]!=""){
?>
<Tag2 aid:table="cell" aid:crows="1" aid:ccols="2" aid:ccolwidth="450" aid:pstyle="ort"><![CDATA[<? echo $getxml->location[0] ?>]]></Tag2>
<? }





}}

//$getxml->asXML();



?>
</Table></Tag1></Root>