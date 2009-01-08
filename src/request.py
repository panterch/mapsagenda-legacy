import cgi
import os, sys
import time
import datetime
import util

class Request(object):
	""" holds current request state and configuration information
	"""

	# configuration information / paths
	basedir = os.path.join(os.path.dirname(__file__), '..')
	templatedir = os.path.join(basedir, 'templates')
	datadir     = os.path.join(basedir, 'data')

	def __init__(self):
		# get profiling and date information for current request
		self.starttime=time.time()
		today = util.gmtnow()
		self.curday=str(today.day)
		self.curmonth=str(today.month)
		self.curyear=str(today.year)
		self.timestamp = str(today) + " GMT"
		form = cgi.FieldStorage()
		# gather os and form values
		self.script = os.environ.get('SCRIPT_NAME', '') 
		# TODO: use browser cookie for lang
		self.lang  = form.getfirst("lang", 'de')[0:2].lower()
		self.day   = form.getfirst("day", self.curday)[0:2]
		self.month = form.getfirst("month", self.curmonth)[0:2]
		self.year  = form.getfirst("year", self.curyear)[0:4]
		self.edit  = form.getfirst("edit", "0")[0:1]
		self.eventid  = form.getfirst("eventid", "0")[0:1]
		self.debug = form.has_key("debug")
		# some security
		# check for numbers and chars
		if not (self.day.isdigit() and self.month.isdigit() \
			      and self.year.isdigit() and self.lang.isalpha() \
						and self.eventid.isdigit()): 
			raise "invalid input"
		self.form = form

	def renderDebug(self):
		print '<div class="debug">'
		print "<p>request %s</p>" % str(self)
		cgi.test()
		print '</div>'

	def profile(self):
		return "request time %f, cpu time %f" % \
			(time.time() - self.starttime, time.clock())
	
	def __str__(self):
		return "script: %s day: %s month: %s year: %s debug: %s" % \
			(self.script, self.day, self.month, self.year, self.debug)

	

