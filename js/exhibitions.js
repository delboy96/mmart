document.addEventListener("DOMContentLoaded", function() {
  getExhibitions();
});

function getExhibitions() {
  $.ajax({
    method: "GET",
    dataType: "json",
    url: "api/exhibitions/index.php",
    success: function(data) {
      const exhibitionsContainer = document.getElementById(
        "fh5co-projects-feed"
      );
      let output = "";
      for (let i = 0; i < data.length; i++) {
        output += Exhibition(data[i]);
      }
      exhibitionsContainer.innerHTML = output;
    },
    error: function(xhr, status, error) {
      console.error(error);
      switch (code) {
        case 404:
          console.log("Not found!");
          break;
        case 500:
          console.log("Server error!");
          break;
      }
    }
  });
}
