#!/usr/bin/python2.5

import cgitb; cgitb.enable()
import os, sys
# import paths holding programs

sys.path.append(os.path.join(sys.path[0], "../../src"))
sys.path.append(os.path.join(sys.path[0], "../../lxml-1.3.6/src"))

import request
from mailchimpExport import MailchimpExport
import util


# process request
state = request.Request()

# render page
MailchimpExport().process(state)

# performance info
util.comment(state.profile())


