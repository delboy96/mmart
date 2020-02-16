document.addEventListener('DOMContentLoaded', function () {
  getProjects()
})

function getProjects(){
  $.ajax({
    method: 'GET',
    dataType: 'json',
    url: 'api/projects.php',
    success: function (data) {
      const projectsContainer = document.getElementById('projectsContainer')
      let output = ''
      for (let i = 0; i < data.length; i++) {
        output += Project(data[i])
      }
      projectsContainer.innerHTML = output
    },
    error: function (xhr, status, error) {
      console.error(error)
    }
  })
}