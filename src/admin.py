# Site component control classes

import os
import util
from request import Request
from pageparts import Date
from pageparts import Language
from pageparts import HtmlHeader

class Admin:
	""" overall layout controller """

	def process(self,state):
		""" looks at value of parameter edit:
		    - if edit is 'e' a form will be displayed allowing the user
				  editing the current event
				- if edit is 'w' this is a form submit and the event has
				  to be stored
		"""
		# edit state s(ave) signals that we should process form data
		# and store it to xml. user is redirected to calendar page
		if ('s'==state.edit):
			self.store(state)
			# redirect url
			print 'Location: /event.shtml?year=%(y)s&amp;month=%(m)s&amp;day=%(d)s&amp;lang=%(lang)s&amp;edit=1' % \
				{'y': state.year, 'm': state.month, 'd': state.day, 'lang': state.lang }
			print
			return
		
		# edit state S(ave) signals that we should save a weekly event
		if ('S'==state.edit):
			self.store(state)
			# redirect url
			print 'Location: /week.shtml?lang=%(lang)s&amp;edit=1' % \
				{'y': state.year, 'm': state.month, 'd': state.day, 'lang': state.lang }
			print
			return

		# all other edit states
		self.render(state)
		return
		

	def render(self, state):
		""" renders edit site """

		# send http header
		print "Content-Type: text/html; charset=utf-8" 
		print                               # blank line, end of headers

		print '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"'
		print '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'
		print '<html xmlns="http://www.w3.org/1999/xhtml">'

		HtmlHeader().render(state)
		util.opentag('body')
		util.opentag('div', id='content')

		# this block should only be rendered, if a user clicked on an
		# edit link of an event
		if ('e'==state.edit):
			Date().render(state)
			OriginalEvent().render(state)
			AdminEvent().render(state)

		# this block should only be rendered, if a user clicked on the
		# edit link the weekly event
		if ('w'==state.edit):
			OriginalWeekEvent().render(state)
			AdminWeekEvent().render(state)

		EditLinks().render(state)
		util.closetag('div')
		util.closetag('body')
		util.closetag('html')

	def store(self, state):
		""" this method stores the submitted form as xml event """
		if ('s' == state.edit):
			name = util.eventFileName(state, state.lang, state.eventid)
		if ('S' == state.edit):
			name = util.weekFileName(state, state.lang)
		f = open(name,'w')
		f.truncate()
		print >>f, '<?xml version="1.0" encoding="UTF-8"?>'
		print >>f, '<event>'
		print >>f, '<lang>'+state.lang+'</lang>'
		print >>f, '<title><![CDATA['+\
			state.form.getfirst("title", "")[0:1024]+']]></title>'
		print >>f, '<desc><![CDATA['+\
			state.form.getfirst("desc", "")[0:10240]+']]></desc>'
		print >>f, '<location><![CDATA['+\
			state.form.getfirst("location", "")[0:10240]+']]></location>'
		print >>f, '<url><![CDATA['+\
			state.form.getfirst("url", "")[0:1024]+']]></url>'
		print >>f, '</event>'
		f.close()



class AdminEvent:
	""" renders a form to edit the current selected event
	"""


	def render(self,state):	
		""" trys to access current days event files and transforms them
		"""
		# try to access special language event
		name = util.eventFileName(state, state.lang, state.eventid)
		if not os.path.exists(name):
		  name = name = util.eventFileName(state, 'de', state.eventid)
		if not os.path.exists(name):
			name = (Request.templatedir+'/emptyevent.xml')
		xml_file = file(name)
		xslt_file = file(Request.templatedir+'/admin.xsl')
		state.edit='s' # set edit type to event save
		util.transform(state, xslt_file, xml_file)

class AdminWeekEvent:
	""" renders a form to edit the current selected event
	"""


	def render(self,state):	
		""" trys to access current days event files and transforms them
		"""
		# try to access special language event
		name = util.weekFileName(state, state.lang)
		if not os.path.exists(name):
		  name = name = util.weekFileName(state, 'de')
		if not os.path.exists(name):
			name = (Request.templatedir+'/emptyevent.xml')
		xml_file = file(name)
		xslt_file = file(Request.templatedir+'/admin.xsl')
		state.edit='S' # set edit type to week event save
		util.transform(state, xslt_file, xml_file)

class OriginalEvent:
	""" displays the event in default language, read only
	"""


	def render(self,state):	
		""" trys to access current days event files and transforms them
		"""
		# try to access default language event
		name = util.eventFileName(state, 'de', state.eventid)
		if not os.path.exists(name):
			return
		xml_file = file(name)
		xslt_file = file(Request.templatedir+'/event.xsl')
		util.transform(state, xslt_file, xml_file)


class OriginalWeekEvent:
	""" displays the event in default language, read only
	"""


	def render(self,state):	
		""" trys to access current days event files and transforms them
		"""
		# try to access default language event
		name = util.weekFileName(state, 'de')
		if not os.path.exists(name):
			return
		xml_file = file(name)
		xslt_file = file(Request.templatedir+'/week.xsl')
		util.transform(state, xslt_file, xml_file)


class EditLinks:
	""" displays a link list to edit other languages
	"""

	xml_file  = Language.xml_file
	xslt_file = file(Request.templatedir+'/editlinks.xsl')


	def render(self,state):
		util.transform(state, EditLinks.xslt_file, EditLinks.xml_file)
	



