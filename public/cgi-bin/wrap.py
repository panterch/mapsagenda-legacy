#!/usr/bin/python2.5

# cgi dispatcher script
# get's called from shtml pages, prepares page parts
# parameter dispatch decides which page to open

# import time ; t = time.time() # variable to measure execution time

import cgitb; cgitb.enable()
import sys, os
# import paths holding programs
sys.path.append(os.path.join(sys.path[0], "../../src"))
import request
import util
from pageparts import *


print "Content-Type: text/html; charset=utf-8" 
print                               # blank line, end of headers

# process request
state = request.Request()
state.script='/event.shtml'

# render page
dispatch = state.form.getfirst('dispatch')
instance = eval(dispatch+'()')
instance.render(state)

#print '<!-- '+str(t)+' -->'
#t = time.time() - t
#print '<!-- wrapped %s took %f sec(s) to execute -->'  % (dispatch, t)
