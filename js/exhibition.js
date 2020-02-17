document.addEventListener("DOMContentLoaded", function() {
  getExhibition();
});

function getExhibition() {
  var url = window.location.href;
  var id = url.substring(url.lastIndexOf("=") + 1);

  $.ajax({
    method: "GET",
    dataType: "json",
    url: "api/exhibitions/show.php",
    data: {
      id: id
    },
    success: function(data) {
      const exhibitionsContainer = document.getElementById(
        "fh5co-projects-feed"
      );
      let output = "";
      output += ExhibitionSingle(data);
      exhibitionsContainer.innerHTML = output;
    },
    error: function(xhr, status, error) {
      //   console.error(error);
      //   switch (code) {
      //     case 404:
      //       console.log("Not found!");
      //       break;
      //     case 500:
      //       console.log("Server error!");
      //       break;
      //   }
    }
  });
}
