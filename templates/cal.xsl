<?xml version="1.0" encoding="utf-8"?>

<!-- seb

Downloaded from http://cvs.4suite.org/viewcvs/4Suite/Ft/Server/Share/Demos/RadiCal/month.xsl?rev=1.3&view=markup

Source code from 4suite demo http://demos.4suite.org/index.html

-->

<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  
  <xsl:variable name="base_year" select="1970"/>
  <xsl:variable name="base_month" select="1"/>
  <xsl:variable name="base_day_of_week" select="4"/> <!-- 1/1/1970 was a thursday -->

  <xsl:variable name="page_bg" select="'#ffffff'"/>
  <xsl:variable name="header_bg" select="'#e7ff99'"/>
  <xsl:variable name="cell_bg" select="'#efefef'"/>

  <xsl:variable name="numdays">
    <xsl:call-template name="getnumdays"/>
  </xsl:variable>

  <xsl:variable name="startday">
    <xsl:call-template name="getstartday"/>
  </xsl:variable>


  <!--
       name: getcalrows
       context: month
       params: start (integer)  - the date on the sunday in the first row.
                                  should be negative if the first day of the
                                  month is not sunday.
               end (integer)    - equal to the number of days in the month
       description: builds a set of html rows, each with seven cells, each
                    of which is labeled with the date.
  -->
  <xsl:template name="getcalrows">
    <xsl:param name="start" select="1"/>
    <xsl:param name="end" select="31"/>
    <tr class="mcbody">
      <xsl:call-template name="buildrow">
        <xsl:with-param name="date" select="$start"/>
        <xsl:with-param name="rowlimit" select="$start + 6"/>
        <xsl:with-param name="end" select="$end"/>
      </xsl:call-template>
    </tr>
    <xsl:if test="$start + 6 &lt; $end">
      <xsl:call-template name="getcalrows">
        <xsl:with-param name="start" select="$start + 7"/>
        <xsl:with-param name="end" select="$end"/>
      </xsl:call-template>
    </xsl:if>
  </xsl:template>

  <xsl:template name="buildrow">
    <xsl:param name="date"/>
    <xsl:param name="rowlimit"/>
    <xsl:param name="end"/>
    <xsl:param name="day_of_week" select="0"/>
    <xsl:variable name="holiday">
    </xsl:variable>
    <xsl:variable name="datestring">
      <xsl:value-of select="$year"/>
      <xsl:text>-</xsl:text>
      <xsl:call-template name="twod">
        <xsl:with-param name="num" select="$month"/>
      </xsl:call-template>
      <xsl:text>-</xsl:text>
      <xsl:call-template name="twod">
        <xsl:with-param name="num" select="$date"/>
      </xsl:call-template>
    </xsl:variable>
    <td>
			<xsl:if test="$date=$curday and $month=$curmonth and $year=$curyear">
			<xsl:attribute name="class">today</xsl:attribute>
			</xsl:if>
			<xsl:if test="$date=$day">
			<xsl:attribute name="class">selected</xsl:attribute>
			</xsl:if>
      <xsl:if test="$date &gt;= 1 and $date &lt;= $end">
				<xsl:call-template name="changeDate">
						<xsl:with-param name="year" select="$year"/>
						<xsl:with-param name="month" select="$month"/>
						<xsl:with-param name="day" select="$date"/>
						<xsl:with-param name="text" select="$date"/>
				</xsl:call-template>
      </xsl:if>
      <br/>
    </td>
    <xsl:if test="$date &lt; $rowlimit">
      <xsl:call-template name="buildrow">
        <xsl:with-param name="date" select="$date + 1"/>
        <xsl:with-param name="rowlimit" select="$rowlimit"/>
        <xsl:with-param name="end" select="$end"/>
        <xsl:with-param name="day_of_week" select="$day_of_week + 1"/>
      </xsl:call-template>
    </xsl:if>
  </xsl:template>

  <!--
       name: getnumdays
       context: any
       params: year, month (integers): the year and month whose calendar you
       want to display
       desc: returns the number of days in the given month
  -->
  <xsl:template name="getnumdays">
    <xsl:choose>
      <xsl:when test="$month=2">
        <xsl:variable name="leap_day">
          <xsl:call-template name="isleapyear"/>
        </xsl:variable>
        <xsl:value-of select="28 + $leap_day"/>
      </xsl:when>
      <xsl:when
        test="$month=4 or $month=6 or $month=9 or $month=11">
        <xsl:value-of select="30"/>
      </xsl:when>
      <xsl:otherwise>
        <xsl:text>31</xsl:text>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>


  <xsl:template name="getstartday">
    <xsl:variable name="base_year" select="1970"/>
    <xsl:variable name="base_month" select="1"/>
    <xsl:variable name="days_difference">
      <xsl:call-template name="getdaysdifference"/>
    </xsl:variable>
    <xsl:value-of select="($days_difference + $base_day_of_week) mod 7"/>
  </xsl:template>

  <xsl:template name="getdaysdifference">
    <xsl:variable name="years_difference" select="$year - $base_year"/>
    <xsl:variable name="leap_days"
      select="(floor(($year - 1) div 4) - floor(($year - 1) div 100) + floor(($year - 1) div 1000))
              - (floor($base_year div 4) - floor($base_year div 100) + floor($base_year div 1000))"/>
    <xsl:variable name="day_of_year">
      <xsl:call-template name="getdaysfromjan1"/>
    </xsl:variable>
    <xsl:value-of select="$years_difference * 365 + $leap_days + $day_of_year"/>
  </xsl:template>

  <xsl:template name="getdaysfromjan1">
    <xsl:variable name="leap_day">
      <xsl:call-template name="isleapyear"/>
    </xsl:variable>

    <xsl:choose>
      <xsl:when test="$month=1">
        <xsl:value-of select="0"/>
      </xsl:when>
      <xsl:when test="$month=2">
        <xsl:value-of select="31"/>
      </xsl:when>
      <xsl:when test="$month=3">
        <xsl:value-of select="59 + $leap_day"/>
      </xsl:when>
      <xsl:when test="$month=4">
        <xsl:value-of select="90 + $leap_day"/>
      </xsl:when>
      <xsl:when test="$month=5">
        <xsl:value-of select="120 + $leap_day"/>
      </xsl:when>
      <xsl:when test="$month=6">
        <xsl:value-of select="151 + $leap_day"/>
      </xsl:when>
      <xsl:when test="$month=7">
        <xsl:value-of select="181 + $leap_day"/>
      </xsl:when>
      <xsl:when test="$month=8">
        <xsl:value-of select="212 + $leap_day"/>
      </xsl:when>
      <xsl:when test="$month=9">
        <xsl:value-of select="243 + $leap_day"/>
      </xsl:when>
      <xsl:when test="$month=10">
        <xsl:value-of select="273 + $leap_day"/>
      </xsl:when>
      <xsl:when test="$month=11">
        <xsl:value-of select="304 + $leap_day"/>
      </xsl:when>
      <xsl:when test="$month=12">
        <xsl:value-of select="334 + $leap_day"/>
      </xsl:when>
    </xsl:choose>
  </xsl:template>

  <xsl:template name="isleapyear">
    <xsl:choose>
      <xsl:when test="($year mod 4) = 0 and (($year mod 100) != 0 or ($year mod 1000) = 0)">
        <xsl:value-of select="1"/>
      </xsl:when>
      <xsl:otherwise>
        <xsl:value-of select="0"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>

  <xsl:template name="getmonthname">
    <xsl:param name="monthnum"/>
    <xsl:choose>
      <xsl:when test="$monthnum=1">
        <xsl:text>Januar</xsl:text>
      </xsl:when>
      <xsl:when test="$monthnum=2">
        <xsl:text>Februar</xsl:text>
      </xsl:when>
      <xsl:when test="$monthnum=3">
        <xsl:text>Maerz</xsl:text>
      </xsl:when>
      <xsl:when test="$monthnum=4">
        <xsl:text>April</xsl:text>
      </xsl:when>
      <xsl:when test="$monthnum=5">
        <xsl:text>May</xsl:text>
      </xsl:when>
      <xsl:when test="$monthnum=6">
        <xsl:text>Juni</xsl:text>
      </xsl:when>
      <xsl:when test="$monthnum=7">
        <xsl:text>July</xsl:text>
      </xsl:when>
      <xsl:when test="$monthnum=8">
        <xsl:text>August</xsl:text>
      </xsl:when>
      <xsl:when test="$monthnum=9">
        <xsl:text>September</xsl:text>
      </xsl:when>
      <xsl:when test="$monthnum=10">
        <xsl:text>Oktober</xsl:text>
      </xsl:when>
      <xsl:when test="$monthnum=11">
        <xsl:text>November</xsl:text>
      </xsl:when>
      <xsl:when test="$monthnum=12">
        <xsl:text>Dezember</xsl:text>
      </xsl:when>
    </xsl:choose>
  </xsl:template>

  <xsl:template name="getmonthabbrev">
    <xsl:param name="monthnum"/>
    <xsl:variable name="fullname">
      <xsl:call-template name="getmonthname">
        <xsl:with-param name="monthnum" select="$monthnum"/>
      </xsl:call-template>
    </xsl:variable>
    <xsl:value-of select="substring($fullname,1,3)"/>
  </xsl:template>

  <xsl:template name="getdayname">
    <xsl:param name="day_of_week"/>
    <xsl:choose>
      <xsl:when test="$day_of_week=0">
        <xsl:text>Sonntag</xsl:text>
      </xsl:when>
      <xsl:when test="$day_of_week=1">
        <xsl:text>Montag</xsl:text>
      </xsl:when>
      <xsl:when test="$day_of_week=2">
        <xsl:text>Dienstag</xsl:text>
      </xsl:when>
      <xsl:when test="$day_of_week=3">
        <xsl:text>Mittwoch</xsl:text>
      </xsl:when>
      <xsl:when test="$day_of_week=4">
        <xsl:text>Donnerstag</xsl:text>
      </xsl:when>
      <xsl:when test="$day_of_week=5">
        <xsl:text>Freitag</xsl:text>
      </xsl:when>
      <xsl:when test="$day_of_week=6">
        <xsl:text>Samstag</xsl:text>
      </xsl:when>
    </xsl:choose>
  </xsl:template>

  <xsl:template name="getdayabbrev">
    <xsl:param name="day_of_week"/>
    <xsl:variable name="fullname">
      <xsl:call-template name="getdayname">
        <xsl:with-param name="day_of_week" select="$day_of_week"/>
      </xsl:call-template>
    </xsl:variable>
    <xsl:value-of select="substring($fullname,1,3)"/>
  </xsl:template>

  <!-- convert a one-digit number to two digits -->
  <xsl:template name="twod">
    <xsl:param name="num"/>
    <xsl:if test="$num &lt; 10">
      <xsl:text>0</xsl:text>
    </xsl:if>
    <xsl:value-of select="$num"/>
  </xsl:template>

	<!-- renders current date in long format -->
	<xsl:template name="currentDate">
		<!--
			<xsl:call-template name="getdayname">
				<xsl:with-param name="day_of_week">
					<xsl:call-template name="getstartday" />
				</xsl:with-param>
			</xsl:call-template>
			<xsl:text>, </xsl:text>
		-->
			<xsl:value-of select="$day"/>
			<xsl:text>. </xsl:text>
      <xsl:call-template name="getmonthname">
      	<xsl:with-param name="monthnum" select="$month"/>
			</xsl:call-template>
			<xsl:text> </xsl:text>
      <xsl:value-of select="$year"/>
	</xsl:template>

	<!-- render link back to caller with new calendar parameters -->
	<xsl:template name="changeDate">
		<xsl:param name="year"/>
		<xsl:param name="month"/>
		<xsl:param name="day"/>
		<xsl:param name="text"/>
		<a href="{$script}?year={$year}&amp;month={$month}&amp;day={$day}&amp;edit={$edit}&amp;lang={$lang}">
			<xsl:value-of select="$text"/>
		</a>
	</xsl:template>

</xsl:stylesheet>
