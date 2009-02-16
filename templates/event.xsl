<?xml version="1.0" encoding="utf-8"?>

<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:regexp="http://exslt.org/regular-expressions"
	extension-element-prefixes="regexp">

	<xsl:include href="common.xsl"/>

  <xsl:output method="xhtml" omit-xml-declaration = "yes"/>

  
  <xsl:template match="/event">
			<div class="event">
				<xsl:if test="string-length(title) &gt; 0">
				<h2><xsl:value-of select="title" /></h2>
				</xsl:if>
				<!-- when lang tag available check with current
             requests lang -->
				<xsl:if test="lang and not(lang = $lang)">
				<p class='trans'>noch keine Uebersetzung /
				no translation yet</p>
				</xsl:if>

				<div class='desc'>
				<xsl:value-of select="desc" disable-output-escaping="yes" />
				</div>

				<xsl:if test="string-length(location) &gt; 0">
				<p class='location'>
				<xsl:value-of select="location" />
				</p>
				</xsl:if>


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
				<xsl:if test="$edit=1">
				<p class="editlink">
					<a href="/cgi-bin/edit.py?eventid={$eventid}&amp;edit=e&amp;year={$year}&amp;month={$month}&amp;day={$day}&amp;lang={$lang}">
					<xsl:value-of select="concat($eventid+1,'. Event bearbeiten')" />
					</a>
				</p>
      </xsl:if>
      <p>
        <xsl:text disable-output-escaping='yes'><![CDATA[&nbsp;]]></xsl:text>
      </p>

			</div>
			
	</xsl:template>
</xsl:stylesheet>
