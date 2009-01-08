#!which python
from __future__ import with_statement
import datetime
import time
from datetime import date
from calendar import Calendar
import re
import urllib
import threading
import sys
import util
from sets import Set


localExt = 'html' # extension for local files

def saveToStatic(url, path, templates):
	""" downloads and rewrites file under url. saves the rewritten version
		  under correct local name in path """
	template = findTemplate(url, templates)
	print url
	outName  = '/'.join([path, rewrite(url, template)])
	out = open(outName, 'w')
	input = None
	while not input:
		try:
			input  = urllib.urlopen(url)
		except:
			print >> sys.stderr, "Unexpected error:", sys.exc_info()[0]
			time.sleep(3)
	for line in input:
		print >>out, rewriteUrls(line,templates),

def extractPage(url):
	""" extracts page name only from given url. strips
	    * path and directory info
			* parameter info
			* file extension """
	dot = url.rfind('.')
	slash = url.rfind('/')
	return url[slash+1:dot]

def extractDate(url):
	""" tries to extract a date object from the parameters of the given url """
	year  = int(extractValue(url, 'year'))
	month = int(extractValue(url, 'month'))
	day   = int(extractValue(url, 'day'))
	return date(year, month, day)
	
def extractValue(url, name):
	""" extracts the cgi paramter beginning at pos """
	pos = url.rfind(name+'=') + len(name) + 1 # beginning of cgi value
	end = url.find('&',pos)                   # end of cgi value
	if end < 0 : end = len(url) # no & found (last param)
	return url[pos:end]


def rewrite(url, template):
	""" rewrites the url to a local form stripping parametrs
	    and directories. the given template decides, which parameters
			should be included in the local file name
			see unit tests for examples """
	local = extractPage(url)

  if (-1 < template.find('$date') and -1 < url.find('year=')): # handle date parameter
		date = extractDate(url)
		local = '.'.join([local,date.strftime('%Y-%m-%d')])

	if (-1 < template.find('$lang')): # handle lang parameter
		local = '.'.join([local, extractValue(url,'lang')])

	local = '.'.join([local,localExt])

	return local

def findTemplate(url, templates = []):
	""" tries to find a template that can be used to rewrite the given
	    url. returns first template string that matches, None if there is no
			match """
	pageUrl = extractPage(url)
	for template in templates:
		pageTemplate = extractPage(template)
		if (pageUrl == pageTemplate):
			return template

	return None

def rewriteUrls(text, templates = [], offset=0):
	""" rewrites all urls in text that match a template """
	offset = text.find('href=',offset) # search next href in text
	if (offset < 0): return text
	quote=text[offset+5] # skip to quote (could be ' or ")
	offset += 6 # skrip to value of href param
	end = text.find(quote, offset)
	url = text[offset:end]
	# check if matches given template and replace
	template = findTemplate(url, templates)
	if template:
		url = rewrite(url, template)
		text = ''.join([text[:offset],url,text[end:]])
	# recursive call for next occurence
	return rewriteUrls(text, templates, offset+len(url))



def fnGlob(fn, langs=[], year=util.gmtnow().year):
  """
  transforms parameters to remote url filename scheme w/ parameters
  """
  remote = []

  # replace lang w/ available langs
  i = fn.find('$lang')
  dot = fn.rfind('.')
  if i>=0:
    (bef, sep, aft) = fn.partition('$lang')
    for lang in langs:
      remote.append(''.join([bef, '?lang=', lang, aft]))

  # replace $date with dates in year
  i = fn.find('$date')
  if i>=0:
    cal = Calendar()
    today =  util.gmtnow()
    for i in range(0, len(remote)):
			# extract part of string before $date
      rbef = remote.pop(0).split('$date')[0]
      for month in range(1, 13):
        for day in cal.itermonthdays(year, month):
          if (0 == day): continue # don't know why, but day is 0 sometimes
          # we are not interested in older events
          if (year < today.year): continue
          if (year == today.year and month < today.month): continue
          # if (year == today.year and month == today.month \
					# 		and day < today.day): continue
          remote.append('%s&year=%i&month=%i&day=%i' % \
            (rbef, year, month, day))

  # when no expansion happened at all, simply add the original string
  if 1 > len(remote):
    remote.append(fn)

  return remote

def readTemplates(fname = 'staticFiles.conf'):
	""" reads templates from a config file """
	f = open(fname)
	templates = []
	for line in f:
		templates.append(line.rstrip())
	return templates

def readLanguages(fname = '../templates/languages.xml'):
	""" reads languages.xml and extracts iso country codes """
	f = open(fname)
	languages = []
	patt = re.compile(r'<iso>(.*)</iso>')
	for line in f:
		mobj = patt.search(line)
		if not mobj:
			continue
		languages.append(mobj.group(1))
	return languages
		

class worker(threading.Thread):
	def __init__(self, id):
		self.id = id
		self.cnt = 0
		threading.Thread.__init__(self)
	def run(self):
		while True:
 			with urlsLock:
				if 1 > len(urls):
					break
				url = urls.pop(0)
			saveToStatic(url, '../../live/', templates)
			self.cnt += 1


if __name__ == '__main__':
	templates=readTemplates()
	languages=readLanguages()
	urlsLock=threading.Lock() # global lock used by worker threads
#	urls = Set()
	urls = []
	year =  util.gmtnow().year
	for template in templates:
		urls.extend(fnGlob(template, languages, year))
		urls.extend(fnGlob(template, languages, year+1))
	threads = []
	for i in range(3):
		thread = worker(i)
		thread.start()
		threads.append(thread)
	for thread in threads:
		thread.join()
		print 'thread # %i joined after %i pages' % (thread.id, thread.cnt)
	print 'program end.'
		





		

	
