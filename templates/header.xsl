<?xml version="1.0" encoding="utf-8"?>

<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:include href="common.xsl"/>
  <xsl:include href="cal.xsl"/>

  <xsl:output method="xhtml" omit-xml-declaration = "yes"/>

  <xsl:template match="/">
		<div id="logo1">
		<img src="/cgi-bin/banner.py" width="437" height="126" alt="banner image" 
			style="float: left"/>
		<img src="/maps.png" width="271" height="126" alt="maps logo" />
		</div>
  </xsl:template>
</xsl:stylesheet>


