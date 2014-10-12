<!-- 
Copyright (c) 2010-2014 Marian Longa. All rights reserved.
Visit http://marianlonga.com for more information.
-->

<style>
#sudoku-form {
	text-align: center;
}
input.sudoku{
	width: 40px;
	height: 40px;
	padding: 2px;
	margin: 2px;
	font-size: 25px;
	text-align: center;
	background-color: rgba(240, 220, 200, 0.3);
	border: 1px solid gray;
	border-radius: 2px;
}
input.color{
	background-color: rgb(240, 220, 200);
}
input#solve{
	width: 393px;
	padding: 10px;
	margin-top: 10px;
	font-size: 16px;
}
</style>

<!-- <h1>Sudoku Solver</h1> -->
<?php 

if($_POST["sent"] != ""){//ak je to odoslane
	
	//oznacim policka s uz napisanymi cislami
	for($y=1; $y<=9; $y++){
		for($x=1; $x<=9; $x++){
			if($_POST[$x.$y] != "") $napisane[$x.$y] = 1;
		}
	}
	
	//oznacim cisla pri zadani
	$mmm=0;
	for($y=1;$y<=9;$y++){
	  for($x=1;$x<=9;$x++){
		if($_POST[$x.$y]!=""){$ddd[$mmm]=$x.$y;$mmm++;}  
	  }
	}

	//naplnenie pre kazde volne policko cislami ktore tam mozu byt
	for($y=1;$y<=9;$y++){
	  for($x=1;$x<=9;$x++){
		if($_POST[$x.$y]=="") $a[$x][$y]=array(1,2,3,4,5,6,7,8,9);  
	  }
	}

	$vyhybka=0;

	for($opakovanie=1;$opakovanie<=320;$opakovanie++){//zaciatok opakovania pokym nebude sudoku naisto vyplnene

	$vyhybka++;
	if($vyhybka==5) $vyhybka=1;

	//unsetovanie cisel ktore v prazdnych polickach nemozu byt
	for($y=1;$y<=9;$y++){
	  for($x=1;$x<=9;$x++){
		if($_POST[$x.$y]==""){
		  //stlpec
		  for($y2=0;$y2<9;$y2++){
		$y2_plus_1=$y2+1;
		    if($_POST[$x.$y2_plus_1]!=""){
		      $xqpost=$_POST[$x.$y2_plus_1]-1;
		      if($a[$x][$y][$xqpost]!=""){/*echo "<span style='color:red;'> :: ".$x.$y." ".$a[$x][$y][$xqpost]." :: </span>";*/ unset($a[$x][$y][$xqpost]);}
		    }
		  }
		  //riadok
		  for($x2=0;$x2<9;$x2++){
		$x2_plus_1=$x2+1;
		    if($_POST[$x2_plus_1.$y]!=""){
		      $xqpost=$_POST[$x2_plus_1.$y]-1;
		      if($a[$x][$y][$xqpost]!=""){/*echo "<span style='color:blue;'> :: ".$x.$y." ".$a[$x][$y][$xqpost]." :: </span>";*/ unset($a[$x][$y][$xqpost]);}
		    }
		  }
		  //stvorec
		  if(($y>=1) && ($y<=3))$y2=0;
		  if(($y>=4) && ($y<=6))$y2=3;
		  if(($y>=7) && ($y<=9))$y2=6;
		  $y2_max=$y2+3;
		  for(;$y2<($y2_max);$y2++){
		if(($x>=1) && ($x<=3))$x2=0;
		  	if(($x>=4) && ($x<=6))$x2=3;
		  	if(($x>=7) && ($x<=9))$x2=6;
		$x2_max=$x2+3;
		    for(;$x2<($x2_max);$x2++){
		  $x2_plus_1=$x2+1;
		  $y2_plus_1=$y2+1;
		      if($_POST[$x2_plus_1.$y2_plus_1]!=""){
			$xqpost=$_POST[$x2_plus_1.$y2_plus_1]-1;
		        if($a[$x][$y][$xqpost]!=""){/*echo "<span style='color:green;'> :: ".$x.$y." ".$a[$x][$y][$xqpost]." :: </span>";*/ unset($a[$x][$y][$xqpost]);}
		      }
		    }
		  } 
		}
	  }
	}

	if($vyhybka==1){
	//cislo sa vpise ak je samo vo svojom policku
	  for($y=1;$y<=9;$y++){
		for($x=1;$x<=9;$x++){
		  if($_POST[$x.$y]==""){
		    $pocet_moznych_cisel=0;
		    $cislo_human_readable="";
		    for($n=0;$n<9;$n++){
		      if($a[$x][$y][$n]!=""){
			$pocet_moznych_cisel++;
			$cislo_human_readable=$a[$x][$y][$n];
		      }
		    }
		    if($pocet_moznych_cisel==1)$_POST[$x.$y]=$cislo_human_readable;
		  }
		}  
	  }
	}

	if($vyhybka==2){
	//cislo sa vpise ak je to jedinee take cislo v riadku
	  for($y=1;$y<=9;$y++){
		for($s=0;$s<9;$s++) $aaa[$s]=0;
		for($s=0;$s<9;$s++) $bbb[$s]="";
		for($x=1;$x<=9;$x++){
		  if($_POST[$x.$y]==""){
		    for($r=0;$r<9;$r++){
		      if($a[$x][$y][$r]!=""){
		        $b=$a[$x][$y][$r];  
		        $aaa[$b]++;
		        $bbb[$b]=$x.$y;
		      }
		    }
		  }
		}
		for($s=1;$s<=9;$s++){
		  if($aaa[$s]==1){
		    $c=$bbb[$s];
		    $_POST[$c]=$s;
		  }
		}
	  }
	}

	if($vyhybka==3){
	//cislo sa vpise ak je to jedinee take cislo v stlpci
	  for($x=1;$x<=9;$x++){
		for($s=0;$s<9;$s++) $aaa[$s]=0;
		for($s=0;$s<9;$s++) $bbb[$s]="";
		for($y=1;$y<=9;$y++){
		  if($_POST[$x.$y]==""){
		    for($r=0;$r<9;$r++){
		      if($a[$x][$y][$r]!=""){
		        $b=$a[$x][$y][$r];  
		        $aaa[$b]++;
		        $bbb[$b]=$x.$y;
		      }
		    }
		  }
		}
		for($s=1;$s<=9;$s++){
		  if($aaa[$s]==1){
		    $c=$bbb[$s];
		    $_POST[$c]=$s;
		  }
		}
	  }
	}


	if($vyhybka==4){
	//cislo sa vpise ak je to jedinee take cislo v stvorci
	  for($w=1;$w<=7;$w+=3){
		for($v=1;$v<=7;$v+=3){
		  for($s=0;$s<9;$s++) $aaa[$s]=0;
		  for($s=0;$s<9;$s++) $bbb[$s]="";
		  for($y=0;$y<3;$y++){
		    for($x=0;$x<3;$x++){
		      $nove_x=$v+$x;
		      $nove_y=$w+$y;
		      if($_POST[$nove_x.$nove_y]==""){
		        for($r=0;$r<9;$r++){
		          if($a[$nove_x][$nove_y][$r]!=""){
		            $b=$a[$nove_x][$nove_y][$r];  
		            $aaa[$b]++;
		            $bbb[$b]=$nove_x.$nove_y;
		          }
		        }
		      }
		    }
		  }
		  for($s=1;$s<=9;$s++){
		    if($aaa[$s]==1){
		      $c=$bbb[$s];
		      $_POST[$c]=$s;
		    }
		  }
		}
	  }
	}

	}//koniec opakovania az kym nebude sudoku vyplnene
}//koniec ak je to odoslane

?>

This is a PHP program I've made for solving Sudoku. Just enter your unsolved Sudoku into the fields below, click Solve, and the program will solve it for you!<br><br>

<form id="sudoku-form" action="#" method="POST">
	<?php
	for($y = 1; $y <= 9; $y++){
		for($x = 1; $x <= 9; $x++){
		
			//ak bolo cislo uz predtym napisane, bude bold
			//if($napisane)
			
			//rozlisim farbou stvorce 3x3
			$color = "";
			if($x <= 3 && $y <= 3) $color = "color";
			else if($x >= 7 && $y <=3) $color = "color";
			else if($x >= 4 && $x <= 6 && $y >= 4 && $y <= 6) $color = "color";
			else if($x <= 3 && $y >= 7) $color = "color";
			else if($x >= 7 && $y >= 7) $color = "color";
			
			//vypisem policko
			echo "<input class='sudoku ".$color."' type='text' value='".$_POST[$x.$y]."' name='".$x.$y."' maxlength='1'>";
		}
		echo "<br>";
	}
	?>
	<input id="solve" name="sent" type="submit" value="Solve">
</form>
