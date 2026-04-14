<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap5 Navbar Dropdown</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <link href="style.css" rel="stylesheet">
    <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
  </script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=settings" />
</head>
<body>
<?php
  $name = "홍길동";

  echo "내 이름은 $name 입니다<br>";

  include "09.php";

  // 주석처리
  // 반복문 for(초기값; 조건; 증감)

  $sum = 0;
  for($i=1; $i<=77777; $i=$i+1)
  {
    $sum = $sum + $i;
  }

  echo "합 = $sum <br>";

  // 반복문2 while(조건) {}

  $i = 10;

  while($i>=0)
  {
    echo "$i<br>";
    $i = $i -1;
  }

  // 판단력, 조건문 if

  $ptr = 78;
  if($ptr>=90)
  {
    echo "A+<br>";    
  }

  if($ptr>=90)
  {
    echo "2A+<br>";    
  }else
  {
    echo "2B+<br>";
  }

  if($ptr>=90)
  {
    echo "3A+<br>";    
  }else if($ptr>=80)
  {
    echo "3B+<br>";
  }else
  {
    echo "3C+<br>";
  }

  // 프로그래밍 = 조건문과 반복문의 조합


  
?>

  HTML1 <br>
<?php
  for($i=1; $i<=31; $i=$i+1)
  {
    echo "$i ";

    if($i % 7 == 0)
      echo "<br>";
  }
?>
  HTML2 <br>
<?php

?>

</body>
</html>