# Site component control classes

import os
import util
import time
import locale
from datetime import date
from request import Request
from pageparts import Date
from pageparts import Language
from pageparts import HtmlHeader

class MailchimpExport:
  """ overall layout controller """

  def process(self,state):
    # send http header
    print "Content-Type: text/html; charset=utf-8" 
    print                               # blank line, end of headers
    
    print '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"'
    print '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'
    print '<html xmlns="http://www.w3.org/1999/xhtml">'
    
    HtmlHeader().render(state)
    util.opentag('body')
    util.opentag('div', id='content')

    locale.setlocale(locale.LC_TIME, "de_DE")
    
    for day in range(1,31):
      state.day = str(day);
      renderDate = 1
      for eventid in range(0,10):
        state.eventid=str(eventid)
        name = util.eventFileName(state, state.lang, state.eventid)
        if not os.path.exists(name):
          continue;
        if renderDate:
          print "<h1>"+state.day+". "+state.month+". "+state.year+"</h1>"
          renderDate = 0
        xml_file = file(name)
        xslt_file = file(Request.templatedir+'/event.xsl')
        util.transform(state, xslt_file, xml_file)


    util.closetag('div')
    util.closetag('body')
    util.closetag('html')






