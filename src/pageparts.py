# Site component control classes

import os
import util
from request import Request


class MonthShort:
	""" control class for month event short display
	"""

	def render(self,state):	
		""" trys to access current days event files and transforms them
		"""
		# try to access current month.xml and render it
		name=util.monthFileName(state, state.lang)
		if not os.path.exists(name): # fallback to default lang
			name=util.monthFileName(state, 'de')
		if not os.path.exists(name):
			name = (Request.templatedir+'/emptyevent.xml')
		if not os.path.exists(name):
			return
		xml_file = file(name)
		xslt_file = file(Request.templatedir+'/monthShort.xsl')
		util.transform(state, xslt_file, xml_file)
		
class MonthEvent:
	""" control class for month event display
	"""

	def render(self,state):	
		""" trys to access current days event files and transforms them
		"""
		# try to access requested month xml and render it
		name=util.monthFileName(state, state.lang)
		if not os.path.exists(name): # fallback to default lang
			name=util.monthFileName(state, 'de')
		if not os.path.exists(name):
			name = (Request.templatedir+'/emptyevent.xml')
		if not os.path.exists(name):
			return
		xml_file = file(name)
		xslt_file = file(Request.templatedir+'/monthEvent.xsl')
		util.transform(state, xslt_file, xml_file)
		

class EventShort:
	""" control class for event display
	"""

	def render(self,state):	
		""" trys to access current days event files and transforms them
		"""
		# try to access current dates event files and render them
		for i in range(0,10):
			state.eventid=str(i)
			name = util.eventFileName(state, state.lang, state.eventid)
			if not os.path.exists(name): # fallback to default lang
				name = util.eventFileName(state, 'de', state.eventid)
			if not os.path.exists(name):
				continue
			xml_file = file(name)
			xslt_file = file(Request.templatedir+'/eventShort.xsl')
			util.transform(state, xslt_file, xml_file)


class Event:
	""" control class for event display
	"""


	def render(self,state):	
		""" trys to access current days event files and transforms them
		"""
		# try to access current dates event files and render them
		for i in range(0,10):
			state.eventid=str(i)
			name = util.eventFileName(state, state.lang, state.eventid)
			if not os.path.exists(name): # fallback to default lang
				name = util.eventFileName(state, 'de', state.eventid)
			if not os.path.exists(name):
				name = (Request.templatedir+'/emptyevent.xml')
			if not os.path.exists(name):
				continue
			xml_file = file(name)
			xslt_file = file(Request.templatedir+'/event.xsl')
			util.transform(state, xslt_file, xml_file)
		


class Language:
	""" control class for language selector display """
	
	xml_file = file(Request.templatedir+'/languages.xml')
	xslt_file = file(Request.templatedir+'/languages.xsl')


	def render(self,state):
		util.transform(state, Language.xslt_file, Language.xml_file)


class Month:
	""" control class for monthly calendar display """
	
	xml_file = file(Request.templatedir+'/empty.xml')
	xslt_file = file(Request.templatedir+'/month.xsl')

	def render(self,state):
		util.transform(state, Month.xslt_file, Month.xml_file)

class Date:
	""" control class for day date display """
	
	xml_file = file(Request.templatedir+'/empty.xml')
	xslt_file = file(Request.templatedir+'/date.xsl')

	def render(self,state):
		util.transform(state, Date.xslt_file, Date.xml_file)

class HtmlHeader:
	""" control class for html header display """
	
	xml_file = file(Request.templatedir+'/empty.xml')
	xslt_file = file(Request.templatedir+'/htmlheader.xsl')

	def render(self,state):
		util.transform(state, HtmlHeader.xslt_file, HtmlHeader.xml_file)

class Header:
	""" control class for header display """
	
	xml_file = file(Request.templatedir+'/empty.xml')
	xslt_file = file(Request.templatedir+'/header.xsl')

	def render(self,state):
		util.transform(state, Header.xslt_file, Header.xml_file)

import random

class HeaderImagePath:
	def render(self,state):
		print '/banner/p%i.jpg' % random.randint(0, 15),



