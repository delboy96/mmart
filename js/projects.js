document.addEventListener("DOMContentLoaded", function() {
  getProjects();
});

function getProjects() {
  var url = window.location.href;
  var id = url.substring(url.lastIndexOf("=") + 1);

  $.ajax({
    method: "GET",
    dataType: "json",
    url: "api/projects/index.php",
    success: function(data) {
      const projectsContainer = document.getElementById("projectsContainer");
      let output = "";
      for (let i = 0; i < data.length; i++) {
        output += Project(data[i]);
      }
      projectsContainer.innerHTML = output;
    },
    error: function(xhr, status, error) {
      console.error(error);
    }
  });
}
