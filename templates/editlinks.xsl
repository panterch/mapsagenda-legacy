<?xml version="1.0" encoding="utf-8"?>

<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  
	<xsl:include href="common.xsl"/>

  <xsl:output method="xhtml" omit-xml-declaration = "yes"/>

  <xsl:template match="/languages">
	<div>
		<hr />
		<h2>Sprachauswahl</h2>
		<ul>
		<xsl:for-each select="language">
			<li>
			<a>
				<xsl:attribute name="href">
					<xsl:value-of select="concat('/event.shtml',
						'?edit=1',
						'&amp;year=',$year,
						'&amp;month=',$month,
						'&amp;day=',$day,
						'&amp;lang=',iso)"/>
				</xsl:attribute>
				<xsl:if test="$lang=iso">
				<xsl:attribute name="class">selected</xsl:attribute>
				</xsl:if>
				<xsl:attribute name="title">
				<xsl:value-of select="title" />
				</xsl:attribute>
				<xsl:text>Sprache </xsl:text>
				<xsl:value-of select="text"/>
				<xsl:text> editieren</xsl:text>
			</a>
			</li>
		</xsl:for-each>
		</ul>
		</div>
	</xsl:template>
</xsl:stylesheet>
