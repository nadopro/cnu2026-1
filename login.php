<!-- 로그인 영역 시작 -->
<form method="post" action="index.php?cmd=doLogin">
<div class="row justify-content-center my-5">
  <div class="col-md-8 col-lg-6">

    <!-- 아이디 -->
    <div class="row align-items-center mb-3">
      <div class="col-4">
        <div class="border rounded text-center py-3 bg-light">
          아이디
        </div>
      </div>
      <div class="col-8">
        <input type="text" name="id" class="form-control border border-primary-subtle py-3" placeholder="아이디를 입력하세요">
      </div>
    </div>

    <!-- 비밀번호 -->
    <div class="row align-items-center mb-4">
      <div class="col-4">
        <div class="border rounded text-center py-3 bg-light">
          비밀번호
        </div>
      </div>
      <div class="col-8">
        <input type="password" name="pass" class="form-control border border-primary-subtle py-3" placeholder="비밀번호를 입력하세요">
      </div>
    </div>

    <!-- 버튼 영역 -->
    <div class="row text-center">
      <div class="col-6">
        <button type="submit" class="btn btn-primary w-100 py-3">
          로그인(버튼)
        </button>
      </div>
      <div class="col-6">
        <button class="btn btn-primary w-100 py-3">
          회원가입
        </button>
      </div>
    </div>

  </div>
</div>
</form>
<!-- 로그인 영역 끝 -->