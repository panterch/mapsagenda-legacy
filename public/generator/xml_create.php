<?php

// MAPS 
// XML GENERATOR AUSGABE
// 2008 (m@marcelbamert.ch)


 require("config.php");
	 
header('Content-type: text/xml');
header('Content-Disposition: attachment; filename="maps_'.$_POST['v1'].'.'.$_POST['v2'].'.'.$_POST['v3'].'-'.$_POST['b1'].'.'.$_POST['b2'].'.'.$_POST['b3'].'.xml"');



echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<Root><Tag1><?

$bildtext_array= array();

// JEDE SPRACHE
 foreach ($sprachen as $spr =>$value) {
 	//sprachstart($value[0],$value[1]);
 	?><<? echo $spr ?>><inh><?

// MONATSTHEMA

		if(count($_POST[monatsthema])>0){
foreach($_POST[monatsthema] as $value){
	if(file_exists($datapfad.str_replace ( "de" , $spr,  $value))){
			eintrag(str_replace ( "de" , $spr,  $value),2,$spr);
	
		}

}
}

// JEDEN EINTRAG
	foreach($_POST[xmllist] as $value){
	
		// IST EINTRAG ALS GROSS GECHECKT?
		$machgross=0;
		if(count($_POST[gross])>0){
		foreach($_POST[gross] as $value_g){

			if($value==$value_g){
				$machgross=1;

			}
		}
		}

		// SOLL AUS DEM EINTRAG EINE BILDUNTERSCHRIFT GENERIERT WERDEN?
		if(count($_POST["bildtexte"])>0){
		foreach($_POST["bildtexte"] as $value_b){

			if($value==$value_b){

			if(!array_key_exists($value, $bildtext_array)){

			$bildtext_array[$value]=array();
		//	array_push($bildtext_array,array( $value => array()));
			} 
			
			if(file_exists($datapfad.str_replace ( "de" , $spr,  $value))){
			$getxml = simplexml_load_file($datapfad.str_replace ( "de" , $spr,  $value));
			$titel_spr=$getxml->title[0];

			array_push  ($bildtext_array[$value], array($spr,$titel_spr));
			}


			}
		}

		}



		// EXISTIERT ZUGEHÖRIGES XML?
		if(file_exists($datapfad.str_replace ( "de" , $spr,  $value))){
			eintrag(str_replace ( "de" , $spr,  $value),$machgross,$spr);
	
		}
	}
?></inh></<? echo $spr ?>><?
}



// TITEL/STARTZEILE SPRACHE

function sprachstart($sprache,$sprache_d){
global $zufallbreite;
$zufallbreite=0;
?>

<Tag_main aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="450" aid:pstyle="sprache" aid5:cellstyle="cs_main_sprache"><sprache  aid:cstyle="sprache_d" ><![CDATA[<? echo $sprache; ?>]]></sprache> <sprache  aid:cstyle="sprache" ><![CDATA[<? echo $sprache_d; ?>]]></sprache></Tag_main><?

}

// EINTRAG

function eintrag($value,$machgross,$spr){
global $zufallbreite,$tagkuerzel,$letztesdatum,$speziellesprachen,$datapfad;

// BRAUCHT SPRACHE SPEZIELLES FORMAT?
if(array_key_exists($spr, $speziellesprachen)){
$formatzusatz="_".$spr;
$rtl=$speziellesprachen[$spr][0];
}else{
$formatzusatz="";
$rtl=0;
}


// DATUM UMWANDELN  / WOCHENTAG GENERIEREN
 if($machgross!=2){ 
 $temp = split("-", $value);
 $datum = mktime(0, 0, 0, substr($value,5,2), substr($value,8,2), substr($value,0,4));
 $wochentag=$tagkuerzel[$spr][date("w", $datum)];       
}

$getxml = simplexml_load_file($datapfad.$value);
if($getxml->title[0]!=""){



if($machgross>0){ // GROSSSER EINTRAG 

// LEFT TO RIGHT / GROSS
if($rtl==0){
?>
<Table_inside xmlns:aid5="http://ns.adobe.com/AdobeInDesign/5.0/" aid5:tablestyle="ts_inside" xmlns:aid="http://ns.adobe.com/AdobeInDesign/4.0/" aid:table="table" aid:trows="2" aid:tcols="3"><?

?>
<Tag_inside aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="52" aid5:cellstyle="cs_gross" aid:pstyle="wochentag<? echo $formatzusatz ?>"><Wochentag><? if($machgross==1){ echo $wochentag; } ?></Wochentag></Tag_inside>

<Tag_inside aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="40" aid5:cellstyle="cs_gross" aid:pstyle="datum"><?
 if($machgross==1){ 
echo " ".substr($value,8,2).".". substr($value,5,2).". ";
}?></Tag_inside>
 
<Tag_inside aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="303" aid5:cellstyle="cs_titel_gross"><title aid:pstyle="titel<? echo $formatzusatz ?>"><![CDATA[<? echo edittitel(edittext($getxml->title[0],$spr)) ?>]]></title></Tag_inside>
<Tag_inside aid:table="cell" aid:crows="1" aid:ccols="3" aid5:cellstyle="cs_desc_gross"><Inhalttag aid:pstyle="inhalt_gross<? echo $formatzusatz ?>"><![CDATA[<? echo edittext($getxml->desc[0],$spr); ?>]]></Inhalttag><?
if($getxml->location[0]!=""){
?>

<Orttag aid:pstyle="ort_gross<? if($formatzusatz=="_ru"){ echo $formatzusatz; } ?>"><![CDATA[<? echo edittext($getxml->location[0],$spr); 
if($getxml->url[0]!=""){
echo editurl($getxml->url[0]);
}
?>]]></Orttag><? 

}
?></Tag_inside><? 


}else{

/// RIGHT TO LEFT / GROSS

?>
<Table_inside xmlns:aid5="http://ns.adobe.com/AdobeInDesign/5.0/" aid5:tablestyle="ts_inside" xmlns:aid="http://ns.adobe.com/AdobeInDesign/4.0/" aid:table="table" aid:trows="2" aid:tcols="3"><?

?><Tag_inside aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="374" aid5:cellstyle="cs_titel_gross"><title aid:pstyle="titel<? echo $formatzusatz ?>"><![CDATA[<? echo edittext($getxml->title[0],$spr) ?>]]></title></Tag_inside>
<Tag_inside aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="40" aid5:cellstyle="cs_gross" aid:pstyle="datum"><?
 if($machgross==1){ 
echo " ".substr($value,8,2).".". substr($value,5,2).". ";
}
?></Tag_inside>
<Tag_inside aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="45" aid5:cellstyle="cs_gross" aid:pstyle="wochentag<? echo $formatzusatz ?>"><Wochentag><?  if($machgross==1){  echo $wochentag; } ?></Wochentag></Tag_inside>
<Tag_inside aid:table="cell" aid:crows="1" aid:ccols="3" aid5:cellstyle="cs_desc_gross"><Inhalttag aid:pstyle="inhalt_gross<? echo $formatzusatz ?>"><![CDATA[<? echo edittext($getxml->desc[0],$spr); ?>]]></Inhalttag><?
if($getxml->location[0]!=""){
?>

<Orttag aid:pstyle="ort_gross_rtl"><![CDATA[<? echo edittext($getxml->location[0],$spr);
if($getxml->url[0]!=""){
echo editurl($getxml->url[0]);
}?>]]></Orttag><? 

}
?></Tag_inside><? 
}

}else{ // STANDARD EINTRAG 
// LEFT TO RIGHT / KLEIN
if($rtl==0){
?>
<Table_inside xmlns:aid5="http://ns.adobe.com/AdobeInDesign/5.0/" aid5:tablestyle="ts_inside" xmlns:aid="http://ns.adobe.com/AdobeInDesign/4.0/" aid:table="table" aid:trows="1" aid:tcols="3"><?

?>
<Tag_inside aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="52" aid5:cellstyle="cs_datum" aid:pstyle="wochentag<? echo $formatzusatz ?>"><Wochentag><? echo $wochentag ?></Wochentag></Tag_inside><?

if($letztesdatum!=substr($value,0,10)){ ?>
<Tag_inside aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="40" aid5:cellstyle="cs_datum" aid:pstyle="datum"><?
echo " ".substr($value,8,2).".". substr($value,5,2).". ";
?></Tag_inside>
<?
}else{ ?><Tag_inside aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="40" aid5:cellstyle="cs_datum" aid:pstyle="wochentag"></Tag_inside><?

}
?> 
<Tag_inside aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="358" aid5:cellstyle="cs_desc"><title aid:pstyle="titel<? echo $formatzusatz ?>"><![CDATA[<? echo edittitel(edittext($getxml->title[0],$spr)) ?>]]></title>
<Inhalttag aid:pstyle="inhalt<? echo $formatzusatz ?>"><![CDATA[<? echo edittext($getxml->desc[0],$spr); ?>]]></Inhalttag><?
if($getxml->location[0]!=""){
?>

<Orttag aid:pstyle="ort<? if($formatzusatz=="_ru"){ echo $formatzusatz; } ?>"><![CDATA[<? echo edittext($getxml->location[0],$spr) ;
if($getxml->url[0]!=""){
echo editurl($getxml->url[0]);
}
?>]]></Orttag><? 

}
?>
</Tag_inside><? 

}else{

/// RIGHT TO LEFT / KLEIN

?>
<Table_inside xmlns:aid5="http://ns.adobe.com/AdobeInDesign/5.0/" aid5:tablestyle="ts_inside" xmlns:aid="http://ns.adobe.com/AdobeInDesign/4.0/" aid:table="table" aid:trows="1" aid:tcols="3"><?


?> 
<Tag_inside aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="374" aid5:cellstyle="cs_desc"><title aid:pstyle="titel<? echo $formatzusatz ?>"><![CDATA[<? echo edittext($getxml->title[0],$spr) ?>]]></title>
<Inhalttag aid:pstyle="inhalt<? echo $formatzusatz ?>"><![CDATA[<? echo edittext($getxml->desc[0],$spr); ?>]]></Inhalttag><?
if($getxml->location[0]!=""){
?>

<Orttag aid:pstyle="ort<? if($rtl==1){ echo "_rtl";  } ?>"><![CDATA[<? echo edittext($getxml->location[0],$spr) ;
if($getxml->url[0]!=""){
echo editurl($getxml->url[0]);
} 
?>]]></Orttag><? 

}
?>
</Tag_inside><?

if($letztesdatum!=substr($value,0,10)){ ?>
<Tag_inside aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="40" aid5:cellstyle="cs_datum" aid:pstyle="datum"><?
echo " ".substr($value,8,2).".". substr($value,5,2).". ";
?></Tag_inside>
<?
}else{ ?><Tag_inside aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="40" aid5:cellstyle="cs_datum" aid:pstyle="wochentag<? echo $formatzusatz ?>"></Tag_inside><?

}
?><Tag_inside aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="45" aid5:cellstyle="cs_datum" aid:pstyle="wochentag<? echo $formatzusatz ?>"><Wochentag><? echo $wochentag ?></Wochentag></Tag_inside><?
}
}

?></Table_inside><?
$letztesdatum=substr($value,0,10);
}

}
function editurl($text){

$text=str_replace("http://www", "www", $text);
$text=" ".$text;

return $text;
}

function edittitel($text){
/*
$text = preg_replace('#"(\w)#', "«\$1", $text); 
$text = preg_replace('#([\w|.?! ])"#', "\$1»", $text);


$text = preg_replace('#„(\w)#', "«\$1", $text); 
$text = preg_replace('#([\w|.?! ])“#', "\$1»", $text);

$text = preg_replace('#“(\w)#', "«\$1", $text); 
$text = preg_replace('#([\w|.?! ])„#', "\$1»", $text);
*/

return $text;
}

function edittext($text,$sprache){
$text=trim($text);
$text=str_replace("\n", "", $text);
if($sprache=="ta"){
$text=str_replace("&#160;", "", $text);
}else{
$text=str_replace("&#160;", " ", $text);
}
$text=strip_tags($text);


return $text;
}

?></Tag1>

<bildtexte>
<?
 foreach ($bildtext_array as $value => $titel_spr){



?>
<<? echo "bild_".substr($value,8,2)."_". substr($value,5,2) ?>>
<Table_main xmlns:aid5="http://ns.adobe.com/AdobeInDesign/5.0/" aid5:tablestyle="ts_main" xmlns:aid="http://ns.adobe.com/AdobeInDesign/4.0/" aid:table="table" aid:trows="1" aid:tcols="1"><?
?><Tag_main aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="450" aid5:cellstyle="cs_bildtitel"><bilddatum  aid:pstyle="bilddatum"> <? echo substr($value,8,2).".". substr($value,5,2)."." ?> </bilddatum>
<p_titel  aid:pstyle="bildtitel" ><?
if(is_array($titel_spr)){
	 foreach ($titel_spr as $value2 => $titel)
		{

// BRAUCHT SPRACHE SPEZIELLES FORMAT?
if(array_key_exists($titel[0], $speziellesprachen)){
$formatzusatz="_".$titel[0];
$rtl=$speziellesprachen[$titel[0]][0];
}else{
$formatzusatz="";
$rtl=0;
}



?><b_titel  aid:cstyle="bildtitel<? echo $formatzusatz ?>" ><?

//echo " ".str_replace(" ",chr(160),$titel[1])." "; 
echo " ".$titel[1]." ";

?></b_titel><space  aid:cstyle="space" > </space><?
	} 
}
?>

</p_titel></Tag_main>
</Table_main>
</<? echo "bild_".substr($value,8,2)."_". substr($value,5,2) ?>>



<?

}

?>


<individuell>
<Table_main xmlns:aid5="http://ns.adobe.com/AdobeInDesign/5.0/" aid5:tablestyle="ts_main" xmlns:aid="http://ns.adobe.com/AdobeInDesign/4.0/" aid:table="table" aid:trows="1" aid:tcols="1"><Tag_main aid:table="cell" aid:crows="1" aid:ccols="1" aid:ccolwidth="450" aid5:cellstyle="cs_bildtitel"><bilddatum  aid:pstyle="bilddatum"> 03.12. </bilddatum>
<p_titel  aid:pstyle="bildtitel" ><b_titel  aid:cstyle="bildtitel" > Text text text... </b_titel>
</p_titel></Tag_main>
</Table_main></individuell></bildtexte></Root>