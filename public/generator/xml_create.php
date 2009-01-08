<?php

// MAPS 
// XML GENERATOR AUSGABE
// 2008 (m@marcelbamert.ch)


 require("config.php");
	 
header('Content-type: text/xml');
header('Content-Disposition: attachment; filename="maps_'.$_POST['v1'].'.'.$_POST['v2'].'.'.$_POST['v3'].'-'.$_POST['b1'].'.'.$_POST['b2'].'.'.$_POST['b3'].'.xml"');



echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<Root><Tag1><Table_main xmlns:aid5="http://ns.adobe.com/AdobeInDesign/5.0/" aid5:tablestyle="ts_main" xmlns:aid="http://ns.adobe.com/AdobeInDesign/4.0/" aid:table="table" aid:trows="300" aid:tcols="1"><?

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

<Tag_main aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="450" aid:pstyle="sprache" aid5:cellstyle="cs_main_sprache"><![CDATA[<? echo $sprache; ?>]]></Tag_main><?

}

function eintrag($value){
$getxml = simplexml_load_file("../../code/data/".$value);
if($getxml->title[0]!=""){
?><Tag_main aid:table="cell" aid:crows="1" aid:ccols="2" aid:ccolwidth="450" aid5:cellstyle="cs_main"><?
if($getxml->location[0]!=""){ $zeilen=3; }else{ $zeilen=2; }
?><Table_inside xmlns:aid5="http://ns.adobe.com/AdobeInDesign/5.0/" aid5:tablestyle="ts_inside" xmlns:aid="http://ns.adobe.com/AdobeInDesign/4.0/" aid:table="table" aid:trows="<? echo $zeilen ?>" aid:tcols="2"><?
?><Tag_inside aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="50" aid5:cellstyle="cs"><title aid:pstyle="datum"><? echo substr($value,8,2).".". substr($value,5,2)."." ?></title></Tag_inside><Tag_inside aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="350" aid5:cellstyle="cs"><title aid:pstyle="titel"><![CDATA[<? echo $getxml->title[0] ?>]]></title></Tag_inside>
<Tag_inside aid:table="cell" aid:crows="1" aid:ccols="2" aid:ccolwidth="500" aid:pstyle="inhalt" aid5:cellstyle="cs_desc"><![CDATA[<? echo trim($getxml->desc[0]); ?>]]></Tag_inside><? 
if($getxml->location[0]!=""){
?><Tag_inside aid:table="cell" aid:crows="1" aid:ccols="2" aid:ccolwidth="450" aid:pstyle="ort" aid5:cellstyle="cs_desc"><![CDATA[<? echo $getxml->location[0] ?>]]></Tag_inside><? 

}


?></Table_inside></Tag_main><?


}}

//$getxml->asXML();



?>
</Table_main></Tag1></Root>