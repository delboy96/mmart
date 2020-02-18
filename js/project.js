document.addEventListener("DOMContentLoaded", function() {
  getProject();
});

function getProject() {
  var url = window.location.href;
  var id = url.substring(url.lastIndexOf("=") + 1);

  $.ajax({
    method: "GET",
    dataType: "json",
    url: "api/projects/show.php",
    data: {
      id: id
    },
    success: function(data) {
      const projectsContainer = document.getElementById("projectsContainer");
      let output = "";
      output += ProjectSingle(data);
      projectsContainer.innerHTML = output;
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
