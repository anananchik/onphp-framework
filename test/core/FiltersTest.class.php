<?php
	/* $Id$ */
	
	final class FiltersTest extends UnitTestCase
	{
		public function testTrim()
		{
			$filter = TrimFilter::create();
			$text = ' qq ';
			
			$this->assertEqual(
				$filter->apply($text),
				'qq'
			);
			
			$this->assertEqual(
				$filter->setLeft()->apply($text),
				'qq '
			);
			
			$this->assertEqual(
				$filter->setRight()->apply($text),
				' qq'
			);
			
			$this->assertEqual(
				$filter->setBoth()->apply($text),
				'qq'
			);
		}
		
		public function testUu()
		{
			$text = 'foo und bar';
			
			$this->assertEqual(
				Filter::uudecode()->apply(Filter::uuencode()->apply($text)),
				$text
			);
		}
		
		public function testNewLines()
		{
			$this->assertEqual(
				Filter::nl2br()->apply("strange\nthings\nhappens"),
				"strange<br />\nthings<br />\nhappens"
			);
		}
		
		public function testRussianTypograf()
		{
			$filter = RussianTypograph::me();
			$emptyValues = array(null, '', false, 0, '  ', "\n");
			
			foreach ($emptyValues as $value) {
				$this->assertEqual(null, $filter->apply($value));
			}
			
			$this->assertEqual(
				$filter->apply(' 1/4'),
				'&frac14;'
			);
			
			$this->assertEqual(
				$filter->apply('1/2 '),
				'&frac12;'
			);
			
			$this->assertEqual(
				$filter->apply(' 3/4'),
				'&frac34;'
			);
			
			$this->assertEqual(
				$filter->apply(' 1/4 1/2 3/4 '),
				'&frac14; &frac12; &frac34;'
			);
			
			$link = '<a href="http://site.ru/21/43/41/21">http://test/21/43/41/21</a>';
			$this->assertEqual(
				$filter->apply($link),
				$link
			);
			
			$link = '<a href="http://site.ru/1/4/3/4/1/2">http://test/1/4/3/4/1/2</a>';
			$this->assertEqual(
				$filter->apply($link),
				$link
			);
			
			$this->assertEqual(
				$filter->apply('арбайтен   ---   gut'),
				'арбайтен&nbsp;&#151; gut'
			);
			
			$this->assertEqual(
				$filter->apply('р  ра  раз,д  дв   два   три'),
				'р&nbsp;ра&nbsp;раз,д&nbsp;дв&nbsp;два три'
			);
			
			$this->assertEqual(
				$filter->apply('рок\'н\'ролл'),
				'рок&#146;н&#146;ролл'
			);
			
			$this->assertEqual(
				$filter->apply(
					'Работает   и   с   "unicode-строками (\'utf-8\')"'
					.' - не только с ansi, и это радует'
				),
				'Работает и&nbsp;с&nbsp;&laquo;unicode-строками (&#146;utf-8&#146;)&raquo;'
				.'&nbsp;&#151; не&nbsp;только с&nbsp;ansi, и&nbsp;это радует'
			);
		}
	}
?>