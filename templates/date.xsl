<?xml version="1.0" encoding="utf-8"?>

<!-- seb

Downloaded from http://cvs.4suite.org/viewcvs/4Suite/Ft/Server/Share/Demos/RadiCal/month.xsl?rev=1.3&view=markup

Source code from 4suite demo http://demos.4suite.org/index.html

-->

<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  
  <xsl:include href="common.xsl"/>
  <xsl:include href="cal.xsl"/>

	<xsl:output method="xhtml" omit-xml-declaration = "yes"/>

	<!-- match root element render date -->
  <xsl:template match="/">
		<div id="current-date">
			<xsl:call-template name="currentDate"/>
		</div>
  </xsl:template>

</xsl:stylesheet>

