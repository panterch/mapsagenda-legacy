<?xml version="1.0" encoding="utf-8"?>

<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:include href="common.xsl"/>
  <xsl:include href="cal.xsl"/>

  <xsl:output method="xhtml" omit-xml-declaration = "yes"/>

  <xsl:template match="/">

<xsl:comment>
Generated: <xsl:value-of select="$timestamp"/>
</xsl:comment>

<head>
<title>
	Veranstaltungen - MAPS Züri Agenda
	<xsl:call-template name="currentDate"/>
</title>
<meta name="author" content="seb / Panter llc" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="robots" content="all" />
<meta name="keywords" lang="de" content="Veranstaltungen, Veranstaltungskalender, Events, Zürich, Maps Züri Agenda, Zürcher Kulturprogramm, Stadtleben, günstige, kostenlos, Zürcher Kultur- und Freizeitbereich, Freizeitangebote, Kulturangebot" />
<meta name="description" content="Veranstaltungen und Events - Zürich. Der Veranstaltungskalender MAPS Züri Agenda informiert in 13 Sprachen über günstige Angebote im Zürcher Kultur- und Freizeitbereich." /> 
<meta http-equiv="content-language">
<xsl:attribute name="content">
	<xsl:value-of select="$lang"/>
</xsl:attribute>
</meta>
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="stylesheet" type="text/css">
<xsl:attribute name="href">
	<xsl:value-of select="concat('/style/maps-',$lang,'.css')"/>
</xsl:attribute>
</link>

<link rel="stylesheet" type="text/css" href="/style/maps.css" />
</head>



  </xsl:template>
</xsl:stylesheet>


