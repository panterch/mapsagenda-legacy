<?xml version="1.0" encoding="utf-8"?>

<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:include href="common.xsl"/>

  <xsl:output method="xhtml" omit-xml-declaration = "yes"/>
  
  <xsl:template match="/event">
			<div class="event">
				<xsl:if test="string-length(title) &gt; 0">
				<h2><xsl:value-of select="title" /></h2>
				</xsl:if>

				<p class='desc'>
				<xsl:value-of select="desc" disable-output-escaping="yes"/>
				</p>

				<xsl:if test="string-length(url) &gt; 0">
				<p class='url'>
					<a onclick="this.target = '_blank';">
						<xsl:attribute name="href">
							<xsl:value-of select="url"/>
						</xsl:attribute>
						<xsl:value-of select="url"/>
					</a>
				</p>
				</xsl:if>

				<xsl:if test="string-length(location) &gt; 0">
				<p class='location'>
				<xsl:value-of select="location" />
				</p>
				</xsl:if>

				<xsl:if test="$edit=1">
				<p class="editlink">
					<a href="/cgi-bin/edit.py?edit=w&amp;lang={$lang}">
					Wochenthema bearbeiten
					</a>
				</p>
			</xsl:if>

			</div>
			
	</xsl:template>
</xsl:stylesheet>
