<?php
    session_save_path("sess");
    session_start();

    include "db.php";
    include "head.php";

    $conn = connectDB();
?>
<body>

<?php
    $cmd = isset($_GET["cmd"]) ? $_GET["cmd"] : "init";
    echo "cmd = $cmd<br>";
?>

  <div class="container full-height">

    <!-- 상단 메뉴 -->
    <div class="row">
      <div class="col">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mt-2 rounded">
          <div class="container-fluid">

            <a class="navbar-brand" href="index.php">디지털</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
              <ul class="navbar-nav me-auto">

                <!-- 메뉴1 -->
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    메뉴1
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="index.php?cmd=sino">한문학과</a></li>
                    <li><a class="dropdown-item" href="index.php?cmd=math">수학과</a></li>
                    <li><a class="dropdown-item" href="index.php?cmd=trade">무역학과</a></li>
                  </ul>
                </li>

                <!-- 메뉴2 -->
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    데이터베이스
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="index.php?cmd=list">학생 목록</a></li>
                    <li><a class="dropdown-item" href="index.php?cmd=dbtest">통합DB</a></li>
                    <li><a class="dropdown-item" href="index.php?cmd=ngram">N-gram분석기</a></li>
                    <li><a class="dropdown-item" href="index.php?cmd=chart">구글차트</a></li>
                    
                    <li><a class="dropdown-item" href="#">메뉴 2-2</a></li>
                  </ul>
                </li>

                <!-- 메뉴3 -->
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    메뉴3
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">논어</a></li>
                    <li><a class="dropdown-item" href="#">맹자</a></li>
                  </ul>
                </li>

              </ul> 
            </div>

          </div>
        </nav>

      </div>
    </div>

    <!-- 내용 영역 -->

    <?php
        if(isset($_SESSION["cnuid"]))
        {
            echo "$_SESSION[cnuname] 님 ";
            ?>
                 
                <button type="button" class="btn btn-primary" onClick="location.href='index.php?cmd=logout'">Exit</button>

            <?php            
        }else
        {
            echo "<button type='button' class='btn btn-primary' onClick=\"location.href='index.php?cmd=login'\">로그인</button>";

        }
    ?>

    <div class="row content-grow">
        <div class="col">
    <?php
        include "$cmd.php";
    ?>
        </div>
    </div>

    <!-- 사이트 정보 -->
    <div class="row">
      <div class="col bg-secondary text-white text-center py-3 mb-2 rounded">
        사이트정보
      </div>
    </div>

  </div>

  <!-- Bootstrap JS -->
  
</body>
</html>