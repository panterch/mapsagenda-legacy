<?

// MAPS - AOZ
// XML GENERATOR CONFIG
// 2008 (m@marcelbamert.ch)
//
// !!! ACHTUNG !!! Datei ist UTF-8 codiert, umbedingt so lassen !!! 
//
//                 (z.b. mit Dreamweaver öffnen)

// ---- Pfad zu "data"-Ordner (xml-files)
$datapfad="../../data/";

// ---- Aktive Sprachen
// key = sprachkürzel (xml-dateinamen), value1= Name original, value2= Name deutsch

$sprachen=array(
		"de" => array("deutsch","deutsch"),
		"sq" => array("shqip ","albanisch"),
		"ar" => array("Ø§Ù„Ø¹Ø±Ø¨ÙŠØ© ","arabisch"),
		"en" => array("english ","englisch"),
		"fr" => array("franÃ§ais ","franz&ouml;sisch"),
		"fa" => array("ÙØ§Ø±Ø³ÛŒ ","persisch"),
		"pt" => array("portuguÃªs ","portugiesisch"),
		"ru" => array("Ð ÑƒÑÑÐºÐ¸Ð¹ ","russisch"),
		"sh" => array("srpski/bosanski/hrvatski ","serbokroatisch"),
		"es" => array("espaÃ±ol ","spanisch"),
		"it" => array("italiano ","italienisch"),
		"ta" => array("à®¤à®®à®¿à®´à¯ ","tamilisch"),
		"tr" => array("tÃ¼rkÃ§e ","t&uuml;rkisch")
);

// ---- Kürzel für Wochentage
// key = sprachkürzel (xml-dateinamen), array mit wochentagen

$tagkuerzel=array(
		"sq" => array("D","H","Ma","Me","E","P","Sh"),
		"ar" => array("الا حد","الا ثنين","الثلا ثاء","الا ربعاء","الخميس","الجمعة","السبت"),
		"de" => array("So","Mo","Di","Mi","Do","Fr","Sa"),
		"en" => array("Su","Mo","Tu","We","Th","Fr","Sa"),
		"fr" => array("Di","Lu","Ma","Me","Je","Ve","Sa"),
		"fa" => array("يکشنبه","دوشنبه","سه شنبه","چهارشنبه","پنجشنبه","جمعه","شنبه"),
		"pt" => array("Dom","Seg","Ter","Qua","Qui","Sex","Sáb"),
		"ru" => array("Вс","Пн","Вт","Ср","Чт","Пят","Сб"),
		"sh" => array("Ne","Po","Ut","Sr","Ce","Pe","Su"),
		"es" => array("Do","Lu","Ma","Mi","Ju","Vi","Sa"),
		"it" => array("dom","lun","mar","mer","giov","ven","sab"),
		"ta" => array("ஞாயிறு","திங்கள்","செவ்வாய்","புதன்","வியாழன்","வெள்ளி","சனி"),
		"tr" => array("Pa","Pt","Sa","Ca","Pe","Cu","Ct")
);

// ---- Welche Sprachen brauchen eigene Absatzformate?
// key = sprachkürzel (xml-dateinamen), value = 1 für RightToLeft, 0 für LeftToRight

$speziellesprachen=array(
		"ar"=> array(1),
		"fa"=> array(1),
		"ru"=> array(0),
		"ta"=> array(0),
);