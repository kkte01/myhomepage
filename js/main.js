// 로딩이 되면 불러진다.
$(function () {
  //객체참조변수선언 $으로 계속 선언 시 객체가 계속만드므로 메모리 낭비이다.
  var container = $(".slideshow"); //선언 시 이안에 있는 것들도 다 가져오게 된다.
  var slideGroup = container.find(".slideshow_slides");
  var slides = slideGroup.find("a"); //배열로 넘어온다.
  var nav = container.find(".slideshow_nav");
  var prev = nav.find(".prev");
  var next = nav.find(".next");
  var indicator = container.find(".slideshow_indicator");
  var aIndicator = indicator.find("a"); // 배열로 받는다.
  var currentIndex = -1;
  var intervalValue;

  //1. 슬라이드 자동변환
  //1-1 이미지를 가로로 배치시켜야 한다.
  for(var index = 0; index<slides.length; index++){ 
      var indexLeft = (index*100)+"%";
      slides.eq(index).css("left",indexLeft);
  }
  // //1-1 두가지 방법이 있다.
  // slides.each(function (i) {
  //     var newLeft = i * 100 + '%';
  //     $(this).css({ left: newLeft });
  // });
  //맨 처음 화면에 prev를 없애기 위해 선언
  setting(0);
  //1.2 자동으로 애니메이션으로 보이는 방법 구현
  function gotoSlide(index) {
      //애니메이션 주는 방법 객체.animate(구현내용,걸리는시간,보여주는 방법);
      //구현 내용:left값을 움직인다. 0% -100% -200% -300% 
      //걸리는 시간 :0.5초
      //보여주는 방식 : swing
      slideGroup.animate({ left: -100 * index + "%" }, 500, "swing");
      setting(index);
  }


  function setting(index) {
      //저장되어있는 클래스를 제거
      aIndicator.removeClass("active");
      aIndicator.eq(index).addClass("active");
      //index : 0번일 때 왼쪽은 안보이고 오른쪽은 보이고
      //index : 3번 일때 왼쪽은 보이고 오른쪽은 안보이고
      // 안보이는 명령어 hide, 보이는 명령어 show
      switch (index) {
          case 0: prev.hide(); next.show();
              break;
          case 3: prev.show(); next.hide();
              break;
          default: prev.show(); next.show(); break;
      }
  }
  //interval 함수를 시작하는 함수
  function startTimer() {
      intervalValue = setInterval(function () {
          var nextIndex = (currentIndex + 1) % slides.length;
          currentIndex = nextIndex;
          gotoSlide(nextIndex);
      }, 2000);
  }
  startTimer();
  //interval 함수를 제거하는 함수
  function stopTimer() {
      clearInterval(intervalValue);
  }
  //마우스가 올라갔을 때 이벤트 설정
  container.mouseenter(function () {
      stopTimer();
  });
  //마우스가 내려왔을 때 이벤트 설정
  container.mouseleave(function () {
      startTimer();
  });
  //이전 버튼 클릭 시 이벤트 설정
  prev.on("click", function (e) {
      e.preventDefault(); //원래 anker기능을 막는다.
      if (currentIndex !== 0) {
          currentIndex -= 1;
      }
      gotoSlide(currentIndex);
  });

  //다음 버튼 클릭 시 이벤트 설정
  next.on("click", function (e) {
      e.preventDefault(); //원래 anker기능을 막는다.
      if (currentIndex === -1) {
          currentIndex = 0;
      }
      if (currentIndex !== slides.length - 1) {
          currentIndex += 1;
      }
      gotoSlide(currentIndex);
  });

  aIndicator.on("click", function (e) {
      e.preventDefault();
      //그 indicator의 인덱스 값을 가져와 그에 따른 사진을 보여준다.
      indi = $(this).index();
      gotoSlide(indi);
  });
});