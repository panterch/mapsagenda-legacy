<?xml version="1.0" encoding="utf-8"?>

<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  
	<xsl:include href="common.xsl"/>

  <xsl:output method="xhtml" omit-xml-declaration = "yes"/>

  <xsl:template match="/languages">
	<div id="languages">
		<ul>
		<xsl:for-each select="language">
			<li>
			<xsl:if test="position() = last()">
				<xsl:attribute name="class">
					<xsl:text>last</xsl:text>
				</xsl:attribute>
			</xsl:if>
			<a>
				<xsl:attribute name="href">
					<xsl:value-of select="concat('/',
						'index.shtml?lang=',iso,
						'&amp;edit=',$edit)"/>
				</xsl:attribute>
				<xsl:if test="$lang=iso">
				<xsl:attribute name="class">selected</xsl:attribute>
				</xsl:if>
				<xsl:attribute name="title">
				<xsl:value-of select="title" />
				</xsl:attribute>
				<xsl:value-of select="text"/>
			</a>
			</li>
		</xsl:for-each>
		</ul>
		</div>
	</xsl:template>
</xsl:stylesheet>
