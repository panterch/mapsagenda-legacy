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

  <xsl:template match="/">
          <table class="mcouter">
            <tr class="mctop">
              <td>
							<!--
                <xsl:variable name="prevyear">
                  <xsl:value-of select="$year - 1"/>
                </xsl:variable>
								<xsl:call-template name="changeDate">
										<xsl:with-param name="year" select="$prevyear"/>
                    <xsl:with-param name="month" select="1"/>
                    <xsl:with-param name="day" select="1"/>
										<xsl:with-param name="text" select="$prevyear"/>
								</xsl:call-template>
							-->
              </td>
              <td>
                <xsl:variable name="prevmonth">
                  <xsl:choose>
                    <xsl:when test="$month=1">
                      <xsl:text>12</xsl:text>
                    </xsl:when>
                    <xsl:otherwise>
                      <xsl:value-of select="$month - 1"/>
                    </xsl:otherwise>
                  </xsl:choose>
                </xsl:variable>
                <xsl:variable name="prevmonthyear">
                  <xsl:choose>
                    <xsl:when test="$month=1">
                      <xsl:value-of select="$year - 1"/>
                    </xsl:when>
                    <xsl:otherwise>
                      <xsl:value-of select="$year"/>
                    </xsl:otherwise>
                  </xsl:choose>
                </xsl:variable>
                <xsl:variable name="prevmonthabbrev">
                  <xsl:call-template name="getmonthabbrev">
                    <xsl:with-param name="monthnum" select="$prevmonth"/>
                  </xsl:call-template>
                </xsl:variable>
								<xsl:call-template name="changeDate">
										<xsl:with-param name="year" select="$prevmonthyear"/>
                    <xsl:with-param name="month" select="$prevmonth"/>
                    <xsl:with-param name="day" select="1"/>
										<xsl:with-param name="text" select="$prevmonthabbrev"/>
								</xsl:call-template>
              </td>
              <td>
                <span class="mctitle">
                  <xsl:call-template name="getmonthname">
                    <xsl:with-param name="monthnum" select="$month"/>
									</xsl:call-template>
                  <xsl:text>, </xsl:text>
                  <xsl:value-of select="$year"/>
                </span>
              </td>
              <td>
                <xsl:variable name="nextmonth">
                  <xsl:choose>
                    <xsl:when test="$month=12">
                      <xsl:text>1</xsl:text>
                    </xsl:when>
                    <xsl:otherwise>
                      <xsl:value-of select="$month + 1"/>
                    </xsl:otherwise>
                  </xsl:choose>
                </xsl:variable>
                <xsl:variable name="nextmonthyear">
                  <xsl:choose>
                    <xsl:when test="$nextmonth=1">
                      <xsl:value-of select="$year + 1"/>
                    </xsl:when>
                    <xsl:otherwise>
                      <xsl:value-of select="$year"/>
                    </xsl:otherwise>
                  </xsl:choose>
                </xsl:variable>
                <xsl:variable name="nextmonthabbrev">
                  <xsl:call-template name="getmonthabbrev">
                    <xsl:with-param name="monthnum" select="$nextmonth"/>
                  </xsl:call-template>
                </xsl:variable>
								<xsl:call-template name="changeDate">
										<xsl:with-param name="year" select="$nextmonthyear"/>
                    <xsl:with-param name="month" select="$nextmonth"/>
                    <xsl:with-param name="day" select="1"/>
										<xsl:with-param name="text" select="$nextmonthabbrev"/>
								</xsl:call-template>
              </td>
              <td>
							<!--
                <xsl:variable name="nextyear">
                  <xsl:value-of select="$year + 1"/>
                </xsl:variable>
								<xsl:call-template name="changeDate">
										<xsl:with-param name="year" select="$nextyear"/>
                    <xsl:with-param name="month" select="1"/>
                    <xsl:with-param name="day" select="1"/>
										<xsl:with-param name="text" select="$nextyear"/>
								</xsl:call-template>
							-->
              </td>
            </tr>
            <tr>
              <td colspan="5">
                <table class="mcmain" cellpadding="4">
                  <tr class="mchead">
									<!-- TODO: could be replaced with loop over getdayabbrev -->
                    <th>So</th>
                    <th>Mo</th>
                    <th>Di</th>
                    <th>Mi</th>
                    <th>Do</th>
                    <th>Fr</th>
                    <th>Sa</th>
                  </tr>
                  <xsl:call-template name="getcalrows">
                    <xsl:with-param name="start" select="1 - $startday"/>
                    <xsl:with-param name="end" select="$numdays"/>
                  </xsl:call-template>
                </table>
              </td>
            </tr>
						<tr>
							<td colspan="5">
								<xsl:call-template name="changeDate">
										<xsl:with-param name="year" select="$curyear"/>
                    <xsl:with-param name="month" select="$curmonth"/>
                    <xsl:with-param name="day" select="$curday"/>
										<xsl:with-param name="text" select="'Heute / Today'"/>
								</xsl:call-template>
							</td>
						</tr>
          </table>

  </xsl:template>
</xsl:stylesheet>
