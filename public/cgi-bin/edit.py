#!/usr/bin/python2.5

import cgitb; cgitb.enable()
import os, sys
# import paths holding programs

sys.path.append(os.path.join(sys.path[0], "../../src"))

import request
from admin import Admin
import util


# process request
state = request.Request()

# render page
Admin().process(state)

# performance info
util.comment(state.profile())


