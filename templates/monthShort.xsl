<?xml version="1.0" encoding="utf-8"?>

<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:regexp="http://exslt.org/regular-expressions"
	extension-element-prefixes="regexp"
	>

	<xsl:include href="common.xsl"/>
	<xsl:include href="cal.xsl"/>

  <xsl:output method="xhtml" omit-xml-declaration = "yes"/>
  
  <xsl:template match="/event">
		<div>
				<xsl:if test="string-length(title) &gt; 0">
				<h2>
				<xsl:value-of select="title" />
				</h2>
				</xsl:if>
				<p class='desc'>
				<!-- The regexp has to match things like <emph>, </emph> or <br /> in a              none greedy way -->
				<xsl:value-of select="substring(regexp:replace(string(desc), '&lt;[a-z/]*(\ /)?&gt;', 'g',''), 0, 250)" disable-output-escaping = "yes" />
				<xsl:text> ... </xsl:text>
				<a><xsl:attribute name="href">
          <xsl:value-of select="concat('/month.shtml',
            '?lang=',$lang,
            '&amp;year=',$year,
            '&amp;month=',$month,
            '&amp;edit=',$edit)"/>
					 </xsl:attribute>
				mehr >></a>
				</p>
		</div>
	</xsl:template>
</xsl:stylesheet>
