# file and html utility methods


from __future__ import with_statement
import sys
from lxml import etree
from datetime import datetime, timedelta




def include(filename):	
	""" renders a file to the current output 
	"""
	print '\n\n<!-- BEGIN include output %s -->\n' % filename
	with open(filename) as f:
		for line in f:
			print line
	print '\n<!-- END include output %s -->\n\n' % filename

def transform(state,xslt_file, xml_file):
	""" transforms xml documents using given stylesheet and prints
	    result to current output
	"""
	print '\n\n<!-- BEGIN transform output %s using %s -->\n' % \
		(xml_file.name, xslt_file.name)
	xslt_tree = etree.parse(xslt_file)
	xml_tree  = etree.parse(xml_file)
	transform = etree.XSLT(xslt_tree)
	result = transform(xml_tree, \
		year=state.year, month=state.month, day=state.day, \
		eventid=state.eventid, timestamp="'"+state.timestamp+"'", \
		curyear=state.curyear, curmonth=state.curmonth, curday=state.curday, \
		script="'"+state.script+"'",lang="'"+state.lang+"'",edit="'"+state.edit+"'")
	print etree.tostring(result,pretty_print=True, encoding="utf-8")
	print '\n\n<!-- END transform output %s using %s -->\n' % \
		(xml_file.name, xslt_file.name)

def renderBlank():
	""" renders blank gif tag to current output
	"""
	print '<img src="/blank.gif" alt="" />'

def opentag(tag):
	""" opens a html tag on current output
	"""
	print '<%s>' % tag

def opentag(tag,id=None, styleClass=None):
	""" opens a html tag on current output with given attribute id and style
	"""
	#print '<%s id="%s" class="%s">' % (tag,id, styleClass)
	print '<'+tag+' ',
	if (id):
		print 'id="'+id+'" ',
	if (styleClass):
		print 'class="'+styleClass+'" ',
	print '>'

def closetag(tag):
	""" closes a html tag on current output
	"""
	print '</%s>' % tag

def comment(text):
	""" renders a html comment on current output
	"""
	print '<!-- %s -->' % text


def eventFileName(state, lang, id):
	""" puts togheter an event filename
	"""
	name='%(dir)s/%(year)i-%(month)02i-%(day)02i.%(lang)s.%(#)i.xml' % \
				{'dir': state.datadir, \
				 'year': int(state.year), 'month': int(state.month), \
				 'day': int(state.day), 'lang': lang, '#': int(id) }
	return name

def monthFileName(state, lang):
	""" puts togheter an the month event filename
	"""
	name='%(dir)s/%(year)i-%(month)02i.%(lang)s.xml' % \
				{'dir': state.datadir, \
				 'year': int(state.year), 'month': int(state.month), \
				 'lang': lang }
	return name

def gmtnow():
	""" returns the current gmt time and date (warning: dst ignored!)
	"""
	utcnow = datetime.utcnow()
	d = timedelta(hours = 2)
	return utcnow + d
	
