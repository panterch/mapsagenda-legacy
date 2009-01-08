import unittest
import static

mockTemplates = ['/test.shtml$lang',\
	'/path/param.shtml$lang$date','/noparam.shtml']
langsMock = ['de','fr','ar']

class TestExtract(unittest.TestCase):
	""" tests the extract functions of the module """
	def setUp(self):
		pass

	def testExtractPageSimple(self):
		page = static.extractPage('test.shtml')
		self.assertEqual(page, 'test')

	def testExtractPageWithParam(self):
		page = static.extractPage('test.shtml$date$bla')
		self.assertEqual(page, 'test')

	def testExtractPageWithParamAndPath(self):
		page = static.extractPage('/bla/test.shtml$date$bla')
		self.assertEqual(page, 'test')

	def testExtractValueMiddle(self):
		val = static.extractValue('/test.shtml?bla=test&q=a','bla')
		self.assertEqual(val, 'test')
	
	def testExtractValueEnd(self):
		val = static.extractValue('/test.shtml?bla=test','bla')

	def testExtractDate(self):
		date = static.extractDate('/test/bla.shtml?year=2008&month=12&day=11')
		self.assertEqual(date.year, 2008)
		self.assertEqual(date.month, 12)
		self.assertEqual(date.day, 11)

class TestUrlRewrite(unittest.TestCase):
	def setUp(self):
		pass

	def testRewriteSimple(self):
		local = static.rewrite('test.shtml', 'test.shtml')
		self.assertEqual(local, 'test.html')
	
	def testRewriteCropParam(self):
		local = static.rewrite('test.shtml?bla=xxx&test=123', 'test.shtml')
		self.assertEqual(local, 'test.html')

	def testLangParam(self):
		local = static.rewrite('test.shtml?lang=de&bla=123', 'test.shtml$lang')
		self.assertEqual(local, 'test.de.html')

	def testDateLangParam(self):
		local = static.rewrite('test.shtml?lang=de&year=2007&month=12&day=1&bla=123', 'test.shtml$lang$date')
		self.assertEqual(local, 'test.2007-12-01.de.html')

	def testFindTemplateNoParam(self):
		template = static.findTemplate('/x/y/z/noparam.shtml',mockTemplates)
		self.assertEqual(template,'/noparam.shtml')

	def testFindTemplateWithParam(self):
		template = static.findTemplate('/x/y/z/param.shtml?bla=x',mockTemplates)
		self.assertEqual(template,'/path/param.shtml$lang$date')

	def testFindTemplateNomatch(self):
		template = static.findTemplate('/x/y/z/xx.shtml?bla=x',mockTemplates)
		assert not template

class TestSomeLongerStrings(unittest.TestCase):
	def setUp(self):
		pass

	def testRewriteUrlsQuote(self):
		text = "bla href='http://www.panter.ch/j/x/noparam.shtml' 123"
		text = static.rewriteUrls(text, mockTemplates)
		self.assertEquals(text, "bla href='noparam.html' 123")


	def testRewriteUrlsNoMatch(self):
		text = "bla href='/j/x/xyz.shtml' 123"
		text = static.rewriteUrls(text, mockTemplates)
		self.assertEquals(text, "bla href='/j/x/xyz.shtml' 123")

	def testRewriteUrlsTwoMatches(self):
		text = "bla href='/j/x/noparam.shtml' 123 href=\"test.shtml?lang=de&x=y\" 1"
		text = static.rewriteUrls(text, mockTemplates)
		self.assertEquals(text, \
			"bla href='noparam.html' 123 href=\"test.de.html\" 1")


class FileGlobTest(unittest.TestCase):
  def setUp(self):
    static.year =  2008

  def tearDown(self):
    pass

  def testNoReplace(self):
    """ w/o any special $params, it should return simply its input """
    assert '/home/foo' == static.fnGlob('/home/foo', langsMock)[0]

  def testReplaceLangRemote(self):
    """ tests the replacement of languages for url use"""
    res = static.fnGlob('/test.shtml$lang', langsMock)
    assert len(res) == len(langsMock), "not enough expanded: %i" % len(res)
    for lang in langsMock:
      assert '/test.shtml?lang='+lang in res, "lang missing: %s" % lang

  def testReplaceDateRemote(self):
    """ test the replacement of the date glob for url use"""
    res = static.fnGlob('/test.shtml$lang$date', langsMock)
    self.assertEqual(len(res)/len(langsMock), 366) # 2008 is a leap year
    assert '/test.shtml?lang=de&year=2008&month=2&day=29' in res





if __name__ == '__main__':
    unittest.main()

