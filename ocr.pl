#!/usr/bin/perl

$host = $ARGV[0];
$db = $ARGV[1];
$usr = $ARGV[2];
$pwd = $ARGV[3];

use DBI();

my $dbh=DBI->connect("DBI:mysql:database=$db;host=$host","$usr","$pwd");

$sth11d=$dbh->prepare("DROP TABLE IF EXISTS ocr");
$sth11d->execute();
$sth11d->finish();

$sth11=$dbh->prepare("CREATE TABLE ocr(volume varchar(10),
part varchar(10),
cur_page varchar(10),
text varchar(5000)) ENGINE=MyISAM");

$sth11->execute();
$sth11->finish(); 
@volumes = `ls Text/`;

print "\n\nText Insertion-------------------\n";

for($i1=0;$i1<@volumes;$i1++)
{
	print $volumes[$i1];
	chop($volumes[$i1]);
	
	@parts = `ls Text/$volumes[$i1]/`;

	for($i2=0;$i2<@parts;$i2++)
	{
		chop($parts[$i2]);

		@files = `ls Text/$volumes[$i1]/$parts[$i2]/`;
		
		for($i3=0;$i3<@files;$i3++)
		{
			chop($files[$i3]);
			if($files[$i3] =~ /\.txt/)
			{
				$vol = $volumes[$i1];
				$iss = $parts[$i2];
				$cur_page = $files[$i3];
				
				open(DATA,"Text/$vol/$iss/$cur_page")or die ("cannot open Text/$vol/$iss/$cur_page");
				
				$cur_page =~ s/\.txt//g;
				
				$line=<DATA>;
				$line =~ s/'/\\'/g;
				
				$sth1=$dbh->prepare("INSERT INTO ocr VALUES ('$vol','$iss','$cur_page','$line')");
				$sth1->execute();
				$sth1->finish();
				
				close(DATA);
			}
		}
	}
}
