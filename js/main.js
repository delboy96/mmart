$(document).ready(main);

var main = function() {
  var paused = false;

  //login/reg

  var imgbtn = document.querySelector(".img__btn");
  var cont = document.querySelector(".cont");

  if (imgbtn) {
    imgbtn.addEventListener("click", function() {
      cont.classList.toggle("s--signup");
    });
  }

  $(".arrowR").click(function() {
    event.preventDefault();
    paused = true;
    $("#slidesho > div:first")
      .hide()
      .next()
      .fadeIn()
      .end()
      .appendTo("#slidesho");
  });

  $(".arrowL").click(function() {
    event.preventDefault();
    paused = true;
    $("#slidesho > div:last")
      .hide(1000)
      .prependTo("#slidesho")
      .next()
      .show()
      .next()
      .hide()
      .end();
  });

  setInterval(function() {
    if (paused === false) {
      $("#slidesho > div:first")
        .hide()
        .next()
        .fadeIn()
        .end()
        .appendTo("#slidesho");
    }
  }, 5000);
};

// fancybox

$(document).ready(function() {
  //FANCYBOX
  //https://github.com/fancyapps/fancyBox
  $(".fancybox").fancybox({
    openEffect: "none",
    closeEffect: "none"
  });
});
