<?xml version="1.0" encoding="utf-8"?>

<!-- renders a form to edit current event -->

<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:output method="xml"/>
	<xsl:include href="common.xsl"/>

  
  <xsl:template match="/event">
			<form action='/cgi-bin/edit.py' method='post'>
			<hr />
			<h2>
				Uebersetzung
				<xsl:value-of select='$lang'/>
			</h2>
			<p>Titel:<br />
			<!-- render textfield for title input -->
				<input name='title' class='title' type='text' 
				       maxlength='1024' size='50'>
					<xsl:if test="lang = $lang">
					  <xsl:attribute name='value'>
					  	<xsl:value-of select='title'/>
					  </xsl:attribute>
					</xsl:if>
				</input>
			</p>	
			<p>Beschreibung:<br />
			<!-- the data to admin here may be from the fallback (the german version)
					 this is ok for most fields but not for description, so we have to
					 check here if its real or fallback data -->
			<!-- render textfield holding description:
			     xslt will render collapsed <textarea /> tag when no value is
					 given. many browsers will render all following tags and content
					 _inside_ the text area. Therefore if an empty description is
					 given, the textarea will be outputed as CDATA w/ output encoding
					 disabled -->
				<xsl:choose>
					<xsl:when test="lang = $lang and string-length(desc) &gt; 0">
					<textarea id='desc' name='desc' maxlength='10240' class='desc'
					  cols='50' rows='10'>
						<xsl:value-of select='desc' disable-output-escaping="yes"/>
					</textarea>
					</xsl:when>
					<xsl:otherwise>
					<xsl:text disable-output-escaping='yes'><![CDATA[<textarea id='desc' name='desc' maxlength='10240' cols='50' rows='10'></textarea>]]></xsl:text>
					</xsl:otherwise>
				</xsl:choose>
			</p>	
			<p>Addresse:<br />
				<input name='location' class='location'
				       type='text' maxlength='1024' size='50'>
					<xsl:attribute name='value'>
						<xsl:value-of select='location'/>
					</xsl:attribute>
				</input>
			</p>	
			<p>Link:<br />
				<input name='url' class='url'
				       type='text' maxlength='1024' size='50'>
					<xsl:attribute name='value'>
						<xsl:value-of select='url'/>
					</xsl:attribute>
				</input>
			</p>	

			<!-- render state (date, language...) as hidden fields -->
			<input type='hidden' name='eventid'>
				<xsl:attribute name='value'>
					<xsl:value-of select='$eventid'/>
				</xsl:attribute>
			</input>
			<input type='hidden' name='edit'>
				<xsl:attribute name='value'>
					<xsl:value-of select='$edit'/>
				</xsl:attribute>
			</input>
			<input type='hidden' name='year'>
				<xsl:attribute name='value'>
					<xsl:value-of select='$year'/>
				</xsl:attribute>
			</input>
			<input type='hidden' name='month'>
				<xsl:attribute name='value'>
					<xsl:value-of select='$month'/>
				</xsl:attribute>
			</input>
			<input type='hidden' name='day'>
				<xsl:attribute name='value'>
					<xsl:value-of select='$day'/>
				</xsl:attribute>
			</input>
			<input type='hidden' name='lang'>
				<xsl:attribute name='value'>
					<xsl:value-of select='$lang'/>
				</xsl:attribute>
			</input>

			<!-- control buttons -->
			<input type='submit' value='Speichern'/>
			<input type='reset' />


<script type="text/javascript" src="/js/prototype.js">
<xsl:text> </xsl:text>
</script>
<script type="text/javascript" src="/js/fckeditor/fckeditor.js">
<xsl:text> </xsl:text>
</script>
<script type="text/javascript">
var editor = new FCKeditor('desc');
editor.BasePath = "/js/fckeditor/";
editor.Config['CustomConfigurationsPath'] = "/js/fckconfig.js";
editor.Config['ContentLangDirection'] = $('desc').getStyle('direction');
editor.ToolbarSet = 'maps';
editor.DefaultLanguage = "<xsl:value-of select='$lang'/>" ;
editor.ReplaceTextarea();
</script>

			</form>


			
	</xsl:template>
</xsl:stylesheet>
