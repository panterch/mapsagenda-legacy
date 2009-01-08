<?xml version="1.0" encoding="utf-8"?>

<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:include href="common.xsl"/>
	<xsl:include href="cal.xsl"/>

  <xsl:output method="xhtml" omit-xml-declaration = "yes"/>
  
  <xsl:template match="/event">
				<xsl:if test="string-length(title) &gt; 0">
				<p class="eventShort">
				<xsl:value-of select="title" />
				<xsl:text> ... </xsl:text>
				<xsl:call-template name="changeDate">
						<xsl:with-param name="year" select="$curyear"/>
            <xsl:with-param name="month" select="$curmonth"/>
       	    <xsl:with-param name="day" select="$curday"/>
						<xsl:with-param name="text" select="'mehr >>'"/>
				</xsl:call-template>
				</p>
				</xsl:if>
	</xsl:template>
</xsl:stylesheet>

