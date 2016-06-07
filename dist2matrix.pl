#!/usr/bin/perl

#$usage = "Usage: $0 DistFile StuNum";
$dist_file = shift or die ($usage);
$stu_num = shift or die ($usage);
$i = 0; $j = 1;
open (DIST, $dist_file);
readline DIST;
while ($line = <DIST>) {
	chomp ($line);
	($stu1, $stu2, $dist_each) = split (/\t/, $line);
	$dist[$i][$j] = $dist_each;
	if ($stu1_old && $stu1 ne $stu1_old) {
		$i += 1;
		$j = $i + 1;
		$dist[$i][$j] = $dist_each;
	}
	$stu[$i] = $stu1;
	$j += 1;
	$stu1_old = $stu1;
}
$stu[$stu_num-1] = $stu2;
printf ("%8d\n",$stu_num);
for ($i=0;$i<$stu_num;$i++) {
	print "$stu[$i]  ";
	for ($j=0;$j<$stu_num;$j++) {
		if ($j==$stu_num - 1) {
			if ($i==$j) {
				print "0.0000\n";
			} else {
				print "$dist[$i][$j]\n";
			}
		} else {
			if ($i==$j) {
				print "0.0000    ";
			} elsif ($i<$j) {
				print "$dist[$i][$j]    ";
			} else {
				print "$dist[$j][$i]    ";
			}
		}
	}
}
