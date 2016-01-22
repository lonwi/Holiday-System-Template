<?php

function get_bank_holiday(){
	$bankholidays = get_bank_holidays();
	$current_date = date("Y-m-d");
	
	foreach($bankholidays as $bankholiday){
		if($current_date < $bankholiday['date']){
			$result = $bankholiday;
			break;
		}
	}
	return $result;
}

function get_bank_holidays(){
	/*http://www.webcal.fi/en-GB/other_file_formats.php*/
	$bankholidays = array (
	  0 => 
	  array (
		'date' => '2015-01-01',
		'name' => 'New Year\'s Day',
		'url' => 'https://en.wikipedia.org/wiki/New_Year%27s_Day',
		'description' => 'New Year\'s Day is observed on January 1, the first day of the year on the modern Gregorian calendar as well as the Julian calendar used in ancient Rome. With most countries using the Gregorian calendar as their main calendar, New Year\'s Day is the closest thing to being the world\'s only truly global public holiday, often celebrated with fireworks at the stroke of midnight as the new year starts. January 1 on the Julian calendar currently corresponds to January 14 on the Gregorian calendar, and it is on that date that followers of some of the Eastern Orthodox churches celebrate the New Year.',
	  ),
	  1 => 
	  array (
		'date' => '2015-04-03',
		'name' => 'Good Friday',
		'url' => 'https://en.wikipedia.org/wiki/Good_Friday',
		'description' => 'Good Friday (from the senses pious, holy of the word "good"), is a religious holiday observed primarily by Christians commemorating the crucifixion of Jesus Christ and his death at Calvary. The holiday is observed during Holy Week as part of the Paschal Triduum on the Friday preceding Easter Sunday, and may coincide with the Jewish observance of Passover. It is also known as Black Friday, Holy Friday, Great Friday, or Easter Friday, though the latter normally refers to the Friday in Easter week.',
	  ),
	  2 => 
	  array (
		'date' => '2015-04-05',
		'name' => 'Easter',
		'url' => 'https://en.wikipedia.org/wiki/Easter',
		'description' => 'Easter (Old English: Ēostre; Greek: Πάσχα, Paskha; Aramaic: פֶּסחא‎ Pasḥa; from Hebrew: פֶּסַח‎ Pesaḥ) is the central feast in the Christian liturgical year. According to the Canonical gospels, Jesus rose from the dead on the third day after his crucifixion. His resurrection is celebrated on Easter Day or Easter Sunday (also Resurrection Day or Resurrection Sunday). The chronology of his death and resurrection is variously interpreted to have occurred between AD 26 and 36.',
	  ),
	  3 => 
	  array (
		'date' => '2015-04-06',
		'name' => 'Easter Monday',
		'url' => 'https://en.wikipedia.org/wiki/Easter_Monday',
		'description' => 'Easter Monday is the day after Easter Sunday and is celebrated as a holiday in some largely Christian cultures, especially Roman Catholic and Eastern Orthodox cultures. Easter Monday in the Roman Catholic liturgical calendar is the second day of the octave of Easter Week and analogously in the Eastern Orthodox Church is the second day of Bright Week.',
	  ),
	  4 => 
	  array (
		'date' => '2015-05-04',
		'name' => 'Early May Bank Holiday',
		'url' => 'https://en.wikipedia.org/wiki/May_Day',
		'description' => 'A bank holiday is a public holiday in the United Kingdom or a colloquialism for public holiday in Ireland. There is no automatic right to time off on these days, although the majority of the population is granted time off work or extra pay for working on these days, depending on their contract. The first official bank holidays were the four days named in the Bank Holidays Act 1871, but today the term is colloquially used for public holidays which are not officially bank holidays, for example Good Friday and Christmas Day.',
	  ),
	  5 => 
	  array (
		'date' => '2015-05-25',
		'name' => 'Spring Bank Holiday',
		'alternate_names' => 'Monday of the Holy Spirit; Pentecost Monday; Whit Monday',
		'url' => 'https://en.wikipedia.org/wiki/Whit_Monday',
		'description' => 'Whit Monday is the holiday celebrated the day after Pentecost, a movable feast in the Christian calendar. It is movable because it is determined by the date of Easter.
	
	Whit Monday gets its English name for following "Whitsun", the day that became one of the three baptismal seasons. The origin of the name "Whit Sunday" is generally attributed to the white garments formerly worn by those newly baptized on this feast.',
	  ),
	  6 => 
	  array (
		'date' => '2015-08-31',
		'name' => 'Summer Bank Holiday',
		'url' => 'http://www.timeanddate.com/holidays/uk/summer-bank-holiday',
		'description' => 'A bank holiday is a public holiday in the United Kingdom or a colloquialism for public holiday in Ireland. There is no automatic right to time off on these days, although the majority of the population is granted time off work or extra pay for working on these days, depending on their contract. The first official bank holidays were the four days named in the Bank Holidays Act 1871, but today the term is colloquially used for public holidays which are not officially bank holidays, for example Good Friday and Christmas Day.',
	  ),
	  7 => 
	  array (
		'date' => '2015-12-25',
		'name' => 'Christmas Day',
		'url' => 'https://en.wikipedia.org/wiki/Christmas',
		'description' => 'Christmas or Christmas Day (Old English: Crīstesmæsse, literally "Christ\'s mass") is an annual commemoration of the birth of Jesus Christ, celebrated generally on December 25 as a religious and cultural holiday by billions of people around the world. A feast central to the Christian liturgical year, it closes the Advent season and initiates the twelve days of Christmastide. Christmas is a civil holiday in many of the world\'s nations, is celebrated by an increasing number of non-Christians, and is an integral part of the Christmas and holiday season.',
	  ),
	  8 => 
	  array (
		'date' => '2015-12-26',
		'name' => 'Boxing Day',
		'alternate_names' => 'Proclamation Day; St. Stephen\'s Day',
		'url' => 'https://en.wikipedia.org/wiki/Boxing_Day',
		'description' => 'Boxing Day is traditionally a day following Christmas when wealthy people in the United Kingdom would give a box containing a gift to their servants. Today, Boxing Day is better known as a bank or public holiday that occurs on December 26, or the first or second weekday after Christmas Day, depending on national or regional laws. It is observed in the United Kingdom, Australia, Canada, New Zealand, and some other Commonwealth nations.
	
	In South Africa, Boxing Day was renamed Day of Goodwill in 1994. In Ireland it is recognized as St. Stephen\'s Day (Irish: Lá Fhéile Stiofáin) or the Day of the Wren (Irish: Lá an Dreoilín). In the Netherlands, Latvia, Lithuania, Austria, Germany, Scandinavia and Poland, December 26 is celebrated as the Second Christmas Day.',
	  ),
	  9 => 
	  array (
		'date' => '2015-12-28',
		'name' => 'Boxing Day Bank Holiday',
		'alternate_names' => 'Proclamation Day; St. Stephen\'s Day',
		'url' => 'https://en.wikipedia.org/wiki/Boxing_Day',
		'description' => 'Boxing Day is traditionally a day following Christmas when wealthy people in the United Kingdom would give a box containing a gift to their servants. Today, Boxing Day is better known as a bank or public holiday that occurs on December 26, or the first or second weekday after Christmas Day, depending on national or regional laws. It is observed in the United Kingdom, Australia, Canada, New Zealand, and some other Commonwealth nations.
	
	In South Africa, Boxing Day was renamed Day of Goodwill in 1994. In Ireland it is recognized as St. Stephen\'s Day (Irish: Lá Fhéile Stiofáin) or the Day of the Wren (Irish: Lá an Dreoilín). In the Netherlands, Latvia, Lithuania, Austria, Germany, Scandinavia and Poland, December 26 is celebrated as the Second Christmas Day.',
	  ),
	  10 => 
	  array (
		'date' => '2016-01-01',
		'name' => 'New Year\'s Day',
		'url' => 'https://en.wikipedia.org/wiki/New_Year%27s_Day',
		'description' => 'New Year\'s Day is observed on January 1, the first day of the year on the modern Gregorian calendar as well as the Julian calendar used in ancient Rome. With most countries using the Gregorian calendar as their main calendar, New Year\'s Day is the closest thing to being the world\'s only truly global public holiday, often celebrated with fireworks at the stroke of midnight as the new year starts. January 1 on the Julian calendar currently corresponds to January 14 on the Gregorian calendar, and it is on that date that followers of some of the Eastern Orthodox churches celebrate the New Year.',
	  ),
	  11 => 
	  array (
		'date' => '2016-03-25',
		'name' => 'Good Friday',
		'url' => 'https://en.wikipedia.org/wiki/Good_Friday',
		'description' => 'Good Friday (from the senses pious, holy of the word "good"), is a religious holiday observed primarily by Christians commemorating the crucifixion of Jesus Christ and his death at Calvary. The holiday is observed during Holy Week as part of the Paschal Triduum on the Friday preceding Easter Sunday, and may coincide with the Jewish observance of Passover. It is also known as Black Friday, Holy Friday, Great Friday, or Easter Friday, though the latter normally refers to the Friday in Easter week.',
	  ),
	  12 => 
	  array (
		'date' => '2016-03-27',
		'name' => 'Easter',
		'url' => 'https://en.wikipedia.org/wiki/Easter',
		'description' => 'Easter (Old English: Ēostre; Greek: Πάσχα, Paskha; Aramaic: פֶּסחא‎ Pasḥa; from Hebrew: פֶּסַח‎ Pesaḥ) is the central feast in the Christian liturgical year. According to the Canonical gospels, Jesus rose from the dead on the third day after his crucifixion. His resurrection is celebrated on Easter Day or Easter Sunday (also Resurrection Day or Resurrection Sunday). The chronology of his death and resurrection is variously interpreted to have occurred between AD 26 and 36.',
	  ),
	  13 => 
	  array (
		'date' => '2016-03-28',
		'name' => 'Easter Monday',
		'url' => 'https://en.wikipedia.org/wiki/Easter_Monday',
		'description' => 'Easter Monday is the day after Easter Sunday and is celebrated as a holiday in some largely Christian cultures, especially Roman Catholic and Eastern Orthodox cultures. Easter Monday in the Roman Catholic liturgical calendar is the second day of the octave of Easter Week and analogously in the Eastern Orthodox Church is the second day of Bright Week.',
	  ),
	  14 => 
	  array (
		'date' => '2016-05-02',
		'name' => 'Early May Bank Holiday',
		'url' => 'https://en.wikipedia.org/wiki/May_Day',
		'description' => 'A bank holiday is a public holiday in the United Kingdom or a colloquialism for public holiday in Ireland. There is no automatic right to time off on these days, although the majority of the population is granted time off work or extra pay for working on these days, depending on their contract. The first official bank holidays were the four days named in the Bank Holidays Act 1871, but today the term is colloquially used for public holidays which are not officially bank holidays, for example Good Friday and Christmas Day.',
	  ),
	  15 => 
	  array (
		'date' => '2016-05-30',
		'name' => 'Spring Bank Holiday',
		'alternate_names' => 'Monday of the Holy Spirit; Pentecost Monday; Whit Monday',
		'url' => 'https://en.wikipedia.org/wiki/Whit_Monday',
		'description' => 'Whit Monday is the holiday celebrated the day after Pentecost, a movable feast in the Christian calendar. It is movable because it is determined by the date of Easter.
	
	Whit Monday gets its English name for following "Whitsun", the day that became one of the three baptismal seasons. The origin of the name "Whit Sunday" is generally attributed to the white garments formerly worn by those newly baptized on this feast.',
	  ),
	  16 => 
	  array (
		'date' => '2016-08-29',
		'name' => 'Summer Bank Holiday',
		'url' => 'http://www.timeanddate.com/holidays/uk/summer-bank-holiday',
		'description' => 'A bank holiday is a public holiday in the United Kingdom or a colloquialism for public holiday in Ireland. There is no automatic right to time off on these days, although the majority of the population is granted time off work or extra pay for working on these days, depending on their contract. The first official bank holidays were the four days named in the Bank Holidays Act 1871, but today the term is colloquially used for public holidays which are not officially bank holidays, for example Good Friday and Christmas Day.',
	  ),
	  17 => 
	  array (
		'date' => '2016-12-25',
		'name' => 'Christmas Day',
		'url' => 'https://en.wikipedia.org/wiki/Christmas',
		'description' => 'Christmas or Christmas Day (Old English: Crīstesmæsse, literally "Christ\'s mass") is an annual commemoration of the birth of Jesus Christ, celebrated generally on December 25 as a religious and cultural holiday by billions of people around the world. A feast central to the Christian liturgical year, it closes the Advent season and initiates the twelve days of Christmastide. Christmas is a civil holiday in many of the world\'s nations, is celebrated by an increasing number of non-Christians, and is an integral part of the Christmas and holiday season.',
	  ),
	  18 => 
	  array (
		'date' => '2016-12-26',
		'name' => 'Boxing Day',
		'alternate_names' => 'Proclamation Day; St. Stephen\'s Day',
		'url' => 'https://en.wikipedia.org/wiki/Boxing_Day',
		'description' => 'Boxing Day is traditionally a day following Christmas when wealthy people in the United Kingdom would give a box containing a gift to their servants. Today, Boxing Day is better known as a bank or public holiday that occurs on December 26, or the first or second weekday after Christmas Day, depending on national or regional laws. It is observed in the United Kingdom, Australia, Canada, New Zealand, and some other Commonwealth nations.
	
	In South Africa, Boxing Day was renamed Day of Goodwill in 1994. In Ireland it is recognized as St. Stephen\'s Day (Irish: Lá Fhéile Stiofáin) or the Day of the Wren (Irish: Lá an Dreoilín). In the Netherlands, Latvia, Lithuania, Austria, Germany, Scandinavia and Poland, December 26 is celebrated as the Second Christmas Day.',
	  ),
	  19 => 
	  array (
		'date' => '2016-12-27',
		'name' => 'Christmas Day Holiday',
		'url' => 'https://en.wikipedia.org/wiki/Christmas',
		'description' => 'Christmas or Christmas Day (Old English: Crīstesmæsse, literally "Christ\'s mass") is an annual commemoration of the birth of Jesus Christ, celebrated generally on December 25 as a religious and cultural holiday by billions of people around the world. A feast central to the Christian liturgical year, it closes the Advent season and initiates the twelve days of Christmastide. Christmas is a civil holiday in many of the world\'s nations, is celebrated by an increasing number of non-Christians, and is an integral part of the Christmas and holiday season.',
	  ),
	  20 => 
	  array (
		'date' => '2017-01-01',
		'name' => 'New Year\'s Day',
		'url' => 'https://en.wikipedia.org/wiki/New_Year%27s_Day',
		'description' => 'New Year\'s Day is observed on January 1, the first day of the year on the modern Gregorian calendar as well as the Julian calendar used in ancient Rome. With most countries using the Gregorian calendar as their main calendar, New Year\'s Day is the closest thing to being the world\'s only truly global public holiday, often celebrated with fireworks at the stroke of midnight as the new year starts. January 1 on the Julian calendar currently corresponds to January 14 on the Gregorian calendar, and it is on that date that followers of some of the Eastern Orthodox churches celebrate the New Year.',
	  ),
	  21 => 
	  array (
		'date' => '2017-01-02',
		'name' => 'New Year\'s Day Holiday',
		'url' => 'https://en.wikipedia.org/wiki/New_Year%27s_Day',
		'description' => 'New Year\'s Day is observed on January 1, the first day of the year on the modern Gregorian calendar as well as the Julian calendar used in ancient Rome. With most countries using the Gregorian calendar as their main calendar, New Year\'s Day is the closest thing to being the world\'s only truly global public holiday, often celebrated with fireworks at the stroke of midnight as the new year starts. January 1 on the Julian calendar currently corresponds to January 14 on the Gregorian calendar, and it is on that date that followers of some of the Eastern Orthodox churches celebrate the New Year.',
	  ),
	  22 => 
	  array (
		'date' => '2017-04-14',
		'name' => 'Good Friday',
		'url' => 'https://en.wikipedia.org/wiki/Good_Friday',
		'description' => 'Good Friday (from the senses pious, holy of the word "good"), is a religious holiday observed primarily by Christians commemorating the crucifixion of Jesus Christ and his death at Calvary. The holiday is observed during Holy Week as part of the Paschal Triduum on the Friday preceding Easter Sunday, and may coincide with the Jewish observance of Passover. It is also known as Black Friday, Holy Friday, Great Friday, or Easter Friday, though the latter normally refers to the Friday in Easter week.',
	  ),
	  23 => 
	  array (
		'date' => '2017-04-16',
		'name' => 'Easter',
		'url' => 'https://en.wikipedia.org/wiki/Easter',
		'description' => 'Easter (Old English: Ēostre; Greek: Πάσχα, Paskha; Aramaic: פֶּסחא‎ Pasḥa; from Hebrew: פֶּסַח‎ Pesaḥ) is the central feast in the Christian liturgical year. According to the Canonical gospels, Jesus rose from the dead on the third day after his crucifixion. His resurrection is celebrated on Easter Day or Easter Sunday (also Resurrection Day or Resurrection Sunday). The chronology of his death and resurrection is variously interpreted to have occurred between AD 26 and 36.',
	  ),
	  24 => 
	  array (
		'date' => '2017-04-17',
		'name' => 'Easter Monday',
		'url' => 'https://en.wikipedia.org/wiki/Easter_Monday',
		'description' => 'Easter Monday is the day after Easter Sunday and is celebrated as a holiday in some largely Christian cultures, especially Roman Catholic and Eastern Orthodox cultures. Easter Monday in the Roman Catholic liturgical calendar is the second day of the octave of Easter Week and analogously in the Eastern Orthodox Church is the second day of Bright Week.',
	  ),
	  25 => 
	  array (
		'date' => '2017-05-01',
		'name' => 'Early May Bank Holiday',
		'url' => 'https://en.wikipedia.org/wiki/May_Day',
		'description' => 'A bank holiday is a public holiday in the United Kingdom or a colloquialism for public holiday in Ireland. There is no automatic right to time off on these days, although the majority of the population is granted time off work or extra pay for working on these days, depending on their contract. The first official bank holidays were the four days named in the Bank Holidays Act 1871, but today the term is colloquially used for public holidays which are not officially bank holidays, for example Good Friday and Christmas Day.',
	  ),
	  26 => 
	  array (
		'date' => '2017-05-29',
		'name' => 'Spring Bank Holiday',
		'alternate_names' => 'Monday of the Holy Spirit; Pentecost Monday; Whit Monday',
		'url' => 'https://en.wikipedia.org/wiki/Whit_Monday',
		'description' => 'Whit Monday is the holiday celebrated the day after Pentecost, a movable feast in the Christian calendar. It is movable because it is determined by the date of Easter.
	
	Whit Monday gets its English name for following "Whitsun", the day that became one of the three baptismal seasons. The origin of the name "Whit Sunday" is generally attributed to the white garments formerly worn by those newly baptized on this feast.',
	  ),
	  27 => 
	  array (
		'date' => '2017-08-28',
		'name' => 'Summer Bank Holiday',
		'url' => 'http://www.timeanddate.com/holidays/uk/summer-bank-holiday',
		'description' => 'A bank holiday is a public holiday in the United Kingdom or a colloquialism for public holiday in Ireland. There is no automatic right to time off on these days, although the majority of the population is granted time off work or extra pay for working on these days, depending on their contract. The first official bank holidays were the four days named in the Bank Holidays Act 1871, but today the term is colloquially used for public holidays which are not officially bank holidays, for example Good Friday and Christmas Day.',
	  ),
	  28 => 
	  array (
		'date' => '2017-12-25',
		'name' => 'Christmas Day',
		'url' => 'https://en.wikipedia.org/wiki/Christmas',
		'description' => 'Christmas or Christmas Day (Old English: Crīstesmæsse, literally "Christ\'s mass") is an annual commemoration of the birth of Jesus Christ, celebrated generally on December 25 as a religious and cultural holiday by billions of people around the world. A feast central to the Christian liturgical year, it closes the Advent season and initiates the twelve days of Christmastide. Christmas is a civil holiday in many of the world\'s nations, is celebrated by an increasing number of non-Christians, and is an integral part of the Christmas and holiday season.',
	  ),
	  29 => 
	  array (
		'date' => '2017-12-26',
		'name' => 'Boxing Day',
		'alternate_names' => 'Proclamation Day; St. Stephen\'s Day',
		'url' => 'https://en.wikipedia.org/wiki/Boxing_Day',
		'description' => 'Boxing Day is traditionally a day following Christmas when wealthy people in the United Kingdom would give a box containing a gift to their servants. Today, Boxing Day is better known as a bank or public holiday that occurs on December 26, or the first or second weekday after Christmas Day, depending on national or regional laws. It is observed in the United Kingdom, Australia, Canada, New Zealand, and some other Commonwealth nations.
	
	In South Africa, Boxing Day was renamed Day of Goodwill in 1994. In Ireland it is recognized as St. Stephen\'s Day (Irish: Lá Fhéile Stiofáin) or the Day of the Wren (Irish: Lá an Dreoilín). In the Netherlands, Latvia, Lithuania, Austria, Germany, Scandinavia and Poland, December 26 is celebrated as the Second Christmas Day.',
	  ),
	  30 => 
	  array (
		'date' => '2018-01-01',
		'name' => 'New Year\'s Day',
		'url' => 'https://en.wikipedia.org/wiki/New_Year%27s_Day',
		'description' => 'New Year\'s Day is observed on January 1, the first day of the year on the modern Gregorian calendar as well as the Julian calendar used in ancient Rome. With most countries using the Gregorian calendar as their main calendar, New Year\'s Day is the closest thing to being the world\'s only truly global public holiday, often celebrated with fireworks at the stroke of midnight as the new year starts. January 1 on the Julian calendar currently corresponds to January 14 on the Gregorian calendar, and it is on that date that followers of some of the Eastern Orthodox churches celebrate the New Year.',
	  ),
	  31 => 
	  array (
		'date' => '2018-03-30',
		'name' => 'Good Friday',
		'url' => 'https://en.wikipedia.org/wiki/Good_Friday',
		'description' => 'Good Friday (from the senses pious, holy of the word "good"), is a religious holiday observed primarily by Christians commemorating the crucifixion of Jesus Christ and his death at Calvary. The holiday is observed during Holy Week as part of the Paschal Triduum on the Friday preceding Easter Sunday, and may coincide with the Jewish observance of Passover. It is also known as Black Friday, Holy Friday, Great Friday, or Easter Friday, though the latter normally refers to the Friday in Easter week.',
	  ),
	  32 => 
	  array (
		'date' => '2018-04-01',
		'name' => 'Easter',
		'url' => 'https://en.wikipedia.org/wiki/Easter',
		'description' => 'Easter (Old English: Ēostre; Greek: Πάσχα, Paskha; Aramaic: פֶּסחא‎ Pasḥa; from Hebrew: פֶּסַח‎ Pesaḥ) is the central feast in the Christian liturgical year. According to the Canonical gospels, Jesus rose from the dead on the third day after his crucifixion. His resurrection is celebrated on Easter Day or Easter Sunday (also Resurrection Day or Resurrection Sunday). The chronology of his death and resurrection is variously interpreted to have occurred between AD 26 and 36.',
	  ),
	  33 => 
	  array (
		'date' => '2018-04-02',
		'name' => 'Easter Monday',
		'url' => 'https://en.wikipedia.org/wiki/Easter_Monday',
		'description' => 'Easter Monday is the day after Easter Sunday and is celebrated as a holiday in some largely Christian cultures, especially Roman Catholic and Eastern Orthodox cultures. Easter Monday in the Roman Catholic liturgical calendar is the second day of the octave of Easter Week and analogously in the Eastern Orthodox Church is the second day of Bright Week.',
	  ),
	  34 => 
	  array (
		'date' => '2018-05-07',
		'name' => 'Early May Bank Holiday',
		'url' => 'https://en.wikipedia.org/wiki/May_Day',
		'description' => 'A bank holiday is a public holiday in the United Kingdom or a colloquialism for public holiday in Ireland. There is no automatic right to time off on these days, although the majority of the population is granted time off work or extra pay for working on these days, depending on their contract. The first official bank holidays were the four days named in the Bank Holidays Act 1871, but today the term is colloquially used for public holidays which are not officially bank holidays, for example Good Friday and Christmas Day.',
	  ),
	  35 => 
	  array (
		'date' => '2018-05-28',
		'name' => 'Spring Bank Holiday',
		'alternate_names' => 'Monday of the Holy Spirit; Pentecost Monday; Whit Monday',
		'url' => 'https://en.wikipedia.org/wiki/Whit_Monday',
		'description' => 'Whit Monday is the holiday celebrated the day after Pentecost, a movable feast in the Christian calendar. It is movable because it is determined by the date of Easter.
	
	Whit Monday gets its English name for following "Whitsun", the day that became one of the three baptismal seasons. The origin of the name "Whit Sunday" is generally attributed to the white garments formerly worn by those newly baptized on this feast.',
	  ),
	  36 => 
	  array (
		'date' => '2018-08-27',
		'name' => 'Summer Bank Holiday',
		'url' => 'http://www.timeanddate.com/holidays/uk/summer-bank-holiday',
		'description' => 'A bank holiday is a public holiday in the United Kingdom or a colloquialism for public holiday in Ireland. There is no automatic right to time off on these days, although the majority of the population is granted time off work or extra pay for working on these days, depending on their contract. The first official bank holidays were the four days named in the Bank Holidays Act 1871, but today the term is colloquially used for public holidays which are not officially bank holidays, for example Good Friday and Christmas Day.',
	  ),
	  37 => 
	  array (
		'date' => '2018-12-25',
		'name' => 'Christmas Day',
		'url' => 'https://en.wikipedia.org/wiki/Christmas',
		'description' => 'Christmas or Christmas Day (Old English: Crīstesmæsse, literally "Christ\'s mass") is an annual commemoration of the birth of Jesus Christ, celebrated generally on December 25 as a religious and cultural holiday by billions of people around the world. A feast central to the Christian liturgical year, it closes the Advent season and initiates the twelve days of Christmastide. Christmas is a civil holiday in many of the world\'s nations, is celebrated by an increasing number of non-Christians, and is an integral part of the Christmas and holiday season.',
	  ),
	  38 => 
	  array (
		'date' => '2018-12-26',
		'name' => 'Boxing Day',
		'alternate_names' => 'Proclamation Day; St. Stephen\'s Day',
		'url' => 'https://en.wikipedia.org/wiki/Boxing_Day',
		'description' => 'Boxing Day is traditionally a day following Christmas when wealthy people in the United Kingdom would give a box containing a gift to their servants. Today, Boxing Day is better known as a bank or public holiday that occurs on December 26, or the first or second weekday after Christmas Day, depending on national or regional laws. It is observed in the United Kingdom, Australia, Canada, New Zealand, and some other Commonwealth nations.
	
	In South Africa, Boxing Day was renamed Day of Goodwill in 1994. In Ireland it is recognized as St. Stephen\'s Day (Irish: Lá Fhéile Stiofáin) or the Day of the Wren (Irish: Lá an Dreoilín). In the Netherlands, Latvia, Lithuania, Austria, Germany, Scandinavia and Poland, December 26 is celebrated as the Second Christmas Day.',
	  ),
	  39 => 
	  array (
		'date' => '2019-01-01',
		'name' => 'New Year\'s Day',
		'url' => 'https://en.wikipedia.org/wiki/New_Year%27s_Day',
		'description' => 'New Year\'s Day is observed on January 1, the first day of the year on the modern Gregorian calendar as well as the Julian calendar used in ancient Rome. With most countries using the Gregorian calendar as their main calendar, New Year\'s Day is the closest thing to being the world\'s only truly global public holiday, often celebrated with fireworks at the stroke of midnight as the new year starts. January 1 on the Julian calendar currently corresponds to January 14 on the Gregorian calendar, and it is on that date that followers of some of the Eastern Orthodox churches celebrate the New Year.',
	  ),
	  40 => 
	  array (
		'date' => '2019-04-19',
		'name' => 'Good Friday',
		'url' => 'https://en.wikipedia.org/wiki/Good_Friday',
		'description' => 'Good Friday (from the senses pious, holy of the word "good"), is a religious holiday observed primarily by Christians commemorating the crucifixion of Jesus Christ and his death at Calvary. The holiday is observed during Holy Week as part of the Paschal Triduum on the Friday preceding Easter Sunday, and may coincide with the Jewish observance of Passover. It is also known as Black Friday, Holy Friday, Great Friday, or Easter Friday, though the latter normally refers to the Friday in Easter week.',
	  ),
	  41 => 
	  array (
		'date' => '2019-04-21',
		'name' => 'Easter',
		'url' => 'https://en.wikipedia.org/wiki/Easter',
		'description' => 'Easter (Old English: Ēostre; Greek: Πάσχα, Paskha; Aramaic: פֶּסחא‎ Pasḥa; from Hebrew: פֶּסַח‎ Pesaḥ) is the central feast in the Christian liturgical year. According to the Canonical gospels, Jesus rose from the dead on the third day after his crucifixion. His resurrection is celebrated on Easter Day or Easter Sunday (also Resurrection Day or Resurrection Sunday). The chronology of his death and resurrection is variously interpreted to have occurred between AD 26 and 36.',
	  ),
	  42 => 
	  array (
		'date' => '2019-04-22',
		'name' => 'Easter Monday',
		'url' => 'https://en.wikipedia.org/wiki/Easter_Monday',
		'description' => 'Easter Monday is the day after Easter Sunday and is celebrated as a holiday in some largely Christian cultures, especially Roman Catholic and Eastern Orthodox cultures. Easter Monday in the Roman Catholic liturgical calendar is the second day of the octave of Easter Week and analogously in the Eastern Orthodox Church is the second day of Bright Week.',
	  ),
	  43 => 
	  array (
		'date' => '2019-05-06',
		'name' => 'Early May Bank Holiday',
		'url' => 'https://en.wikipedia.org/wiki/May_Day',
		'description' => 'A bank holiday is a public holiday in the United Kingdom or a colloquialism for public holiday in Ireland. There is no automatic right to time off on these days, although the majority of the population is granted time off work or extra pay for working on these days, depending on their contract. The first official bank holidays were the four days named in the Bank Holidays Act 1871, but today the term is colloquially used for public holidays which are not officially bank holidays, for example Good Friday and Christmas Day.',
	  ),
	  44 => 
	  array (
		'date' => '2019-05-27',
		'name' => 'Spring Bank Holiday',
		'alternate_names' => 'Monday of the Holy Spirit; Pentecost Monday; Whit Monday',
		'url' => 'https://en.wikipedia.org/wiki/Whit_Monday',
		'description' => 'Whit Monday is the holiday celebrated the day after Pentecost, a movable feast in the Christian calendar. It is movable because it is determined by the date of Easter.
	
	Whit Monday gets its English name for following "Whitsun", the day that became one of the three baptismal seasons. The origin of the name "Whit Sunday" is generally attributed to the white garments formerly worn by those newly baptized on this feast.',
	  ),
	  45 => 
	  array (
		'date' => '2019-08-26',
		'name' => 'Summer Bank Holiday',
		'url' => 'http://www.timeanddate.com/holidays/uk/summer-bank-holiday',
		'description' => 'A bank holiday is a public holiday in the United Kingdom or a colloquialism for public holiday in Ireland. There is no automatic right to time off on these days, although the majority of the population is granted time off work or extra pay for working on these days, depending on their contract. The first official bank holidays were the four days named in the Bank Holidays Act 1871, but today the term is colloquially used for public holidays which are not officially bank holidays, for example Good Friday and Christmas Day.',
	  ),
	  46 => 
	  array (
		'date' => '2019-12-25',
		'name' => 'Christmas Day',
		'url' => 'https://en.wikipedia.org/wiki/Christmas',
		'description' => 'Christmas or Christmas Day (Old English: Crīstesmæsse, literally "Christ\'s mass") is an annual commemoration of the birth of Jesus Christ, celebrated generally on December 25 as a religious and cultural holiday by billions of people around the world. A feast central to the Christian liturgical year, it closes the Advent season and initiates the twelve days of Christmastide. Christmas is a civil holiday in many of the world\'s nations, is celebrated by an increasing number of non-Christians, and is an integral part of the Christmas and holiday season.',
	  ),
	  47 => 
	  array (
		'date' => '2019-12-26',
		'name' => 'Boxing Day',
		'alternate_names' => 'Proclamation Day; St. Stephen\'s Day',
		'url' => 'https://en.wikipedia.org/wiki/Boxing_Day',
		'description' => 'Boxing Day is traditionally a day following Christmas when wealthy people in the United Kingdom would give a box containing a gift to their servants. Today, Boxing Day is better known as a bank or public holiday that occurs on December 26, or the first or second weekday after Christmas Day, depending on national or regional laws. It is observed in the United Kingdom, Australia, Canada, New Zealand, and some other Commonwealth nations.
	
	In South Africa, Boxing Day was renamed Day of Goodwill in 1994. In Ireland it is recognized as St. Stephen\'s Day (Irish: Lá Fhéile Stiofáin) or the Day of the Wren (Irish: Lá an Dreoilín). In the Netherlands, Latvia, Lithuania, Austria, Germany, Scandinavia and Poland, December 26 is celebrated as the Second Christmas Day.',
	  ),
	  48 => 
	  array (
		'date' => '2020-01-01',
		'name' => 'New Year\'s Day',
		'url' => 'https://en.wikipedia.org/wiki/New_Year%27s_Day',
		'description' => 'New Year\'s Day is observed on January 1, the first day of the year on the modern Gregorian calendar as well as the Julian calendar used in ancient Rome. With most countries using the Gregorian calendar as their main calendar, New Year\'s Day is the closest thing to being the world\'s only truly global public holiday, often celebrated with fireworks at the stroke of midnight as the new year starts. January 1 on the Julian calendar currently corresponds to January 14 on the Gregorian calendar, and it is on that date that followers of some of the Eastern Orthodox churches celebrate the New Year.',
	  ),
	  49 => 
	  array (
		'date' => '2020-04-10',
		'name' => 'Good Friday',
		'url' => 'https://en.wikipedia.org/wiki/Good_Friday',
		'description' => 'Good Friday (from the senses pious, holy of the word "good"), is a religious holiday observed primarily by Christians commemorating the crucifixion of Jesus Christ and his death at Calvary. The holiday is observed during Holy Week as part of the Paschal Triduum on the Friday preceding Easter Sunday, and may coincide with the Jewish observance of Passover. It is also known as Black Friday, Holy Friday, Great Friday, or Easter Friday, though the latter normally refers to the Friday in Easter week.',
	  ),
	  50 => 
	  array (
		'date' => '2020-04-12',
		'name' => 'Easter',
		'url' => 'https://en.wikipedia.org/wiki/Easter',
		'description' => 'Easter (Old English: Ēostre; Greek: Πάσχα, Paskha; Aramaic: פֶּסחא‎ Pasḥa; from Hebrew: פֶּסַח‎ Pesaḥ) is the central feast in the Christian liturgical year. According to the Canonical gospels, Jesus rose from the dead on the third day after his crucifixion. His resurrection is celebrated on Easter Day or Easter Sunday (also Resurrection Day or Resurrection Sunday). The chronology of his death and resurrection is variously interpreted to have occurred between AD 26 and 36.',
	  ),
	  51 => 
	  array (
		'date' => '2020-04-13',
		'name' => 'Easter Monday',
		'url' => 'https://en.wikipedia.org/wiki/Easter_Monday',
		'description' => 'Easter Monday is the day after Easter Sunday and is celebrated as a holiday in some largely Christian cultures, especially Roman Catholic and Eastern Orthodox cultures. Easter Monday in the Roman Catholic liturgical calendar is the second day of the octave of Easter Week and analogously in the Eastern Orthodox Church is the second day of Bright Week.',
	  ),
	  52 => 
	  array (
		'date' => '2020-05-04',
		'name' => 'Early May Bank Holiday',
		'url' => 'https://en.wikipedia.org/wiki/May_Day',
		'description' => 'A bank holiday is a public holiday in the United Kingdom or a colloquialism for public holiday in Ireland. There is no automatic right to time off on these days, although the majority of the population is granted time off work or extra pay for working on these days, depending on their contract. The first official bank holidays were the four days named in the Bank Holidays Act 1871, but today the term is colloquially used for public holidays which are not officially bank holidays, for example Good Friday and Christmas Day.',
	  ),
	  53 => 
	  array (
		'date' => '2020-05-25',
		'name' => 'Spring Bank Holiday',
		'alternate_names' => 'Monday of the Holy Spirit; Pentecost Monday; Whit Monday',
		'url' => 'https://en.wikipedia.org/wiki/Whit_Monday',
		'description' => 'Whit Monday is the holiday celebrated the day after Pentecost, a movable feast in the Christian calendar. It is movable because it is determined by the date of Easter.
	
	Whit Monday gets its English name for following "Whitsun", the day that became one of the three baptismal seasons. The origin of the name "Whit Sunday" is generally attributed to the white garments formerly worn by those newly baptized on this feast.',
	  ),
	  54 => 
	  array (
		'date' => '2020-08-31',
		'name' => 'Summer Bank Holiday',
		'url' => 'http://www.timeanddate.com/holidays/uk/summer-bank-holiday',
		'description' => 'A bank holiday is a public holiday in the United Kingdom or a colloquialism for public holiday in Ireland. There is no automatic right to time off on these days, although the majority of the population is granted time off work or extra pay for working on these days, depending on their contract. The first official bank holidays were the four days named in the Bank Holidays Act 1871, but today the term is colloquially used for public holidays which are not officially bank holidays, for example Good Friday and Christmas Day.',
	  ),
	  55 => 
	  array (
		'date' => '2020-12-25',
		'name' => 'Christmas Day',
		'url' => 'https://en.wikipedia.org/wiki/Christmas',
		'description' => 'Christmas or Christmas Day (Old English: Crīstesmæsse, literally "Christ\'s mass") is an annual commemoration of the birth of Jesus Christ, celebrated generally on December 25 as a religious and cultural holiday by billions of people around the world. A feast central to the Christian liturgical year, it closes the Advent season and initiates the twelve days of Christmastide. Christmas is a civil holiday in many of the world\'s nations, is celebrated by an increasing number of non-Christians, and is an integral part of the Christmas and holiday season.',
	  ),
	  56 => 
	  array (
		'date' => '2020-12-26',
		'name' => 'Boxing Day',
		'alternate_names' => 'Proclamation Day; St. Stephen\'s Day',
		'url' => 'https://en.wikipedia.org/wiki/Boxing_Day',
		'description' => 'Boxing Day is traditionally a day following Christmas when wealthy people in the United Kingdom would give a box containing a gift to their servants. Today, Boxing Day is better known as a bank or public holiday that occurs on December 26, or the first or second weekday after Christmas Day, depending on national or regional laws. It is observed in the United Kingdom, Australia, Canada, New Zealand, and some other Commonwealth nations.
	
	In South Africa, Boxing Day was renamed Day of Goodwill in 1994. In Ireland it is recognized as St. Stephen\'s Day (Irish: Lá Fhéile Stiofáin) or the Day of the Wren (Irish: Lá an Dreoilín). In the Netherlands, Latvia, Lithuania, Austria, Germany, Scandinavia and Poland, December 26 is celebrated as the Second Christmas Day.',
	  ),
	  57 => 
	  array (
		'date' => '2020-12-28',
		'name' => 'Boxing Day Bank Holiday',
		'alternate_names' => 'Proclamation Day; St. Stephen\'s Day',
		'url' => 'https://en.wikipedia.org/wiki/Boxing_Day',
		'description' => 'Boxing Day is traditionally a day following Christmas when wealthy people in the United Kingdom would give a box containing a gift to their servants. Today, Boxing Day is better known as a bank or public holiday that occurs on December 26, or the first or second weekday after Christmas Day, depending on national or regional laws. It is observed in the United Kingdom, Australia, Canada, New Zealand, and some other Commonwealth nations.
	
	In South Africa, Boxing Day was renamed Day of Goodwill in 1994. In Ireland it is recognized as St. Stephen\'s Day (Irish: Lá Fhéile Stiofáin) or the Day of the Wren (Irish: Lá an Dreoilín). In the Netherlands, Latvia, Lithuania, Austria, Germany, Scandinavia and Poland, December 26 is celebrated as the Second Christmas Day.',
	  ),
	);
	return $bankholidays;
}
