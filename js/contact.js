document.addEventListener("DOMContentLoaded", function() {
  var btn = document.querySelector("#con-sub");
  if (btn) {
    btn.addEventListener("click", contact);
  }
});

function contact() {
  var imePolje = document.getElementById("name").value;
  var mejlPolje = document.getElementById("email").value;
  var messagePolje = document.getElementById("message").value;

  var reMejl = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  var reIme = /^([a-zA-Z]{2,15})+$/;

  var greske = [];

  if (!reIme.test(imePolje)) {
    greske.push("Name not valid.");
  }

  if (!reMejl.test(mejlPolje)) {
    greske.push("E-mail not valid.");
  }

  if (greske.length === 0) {
    console.log("ok");

    $.ajax({
      type: "POST",
      url: "php/email.php",
      dataType: "text",
      data: {
        name: imePolje,
        email: mejlPolje,
        message: messagePolje,
        emailB: "sent"
      },
      success: function(response) {
        console.log("Poslato ajaxom.");
        // window.location = "php/email.php";
      },
      error: function(xhr, status, errorMsg) {
        let message = "Kod" + xhr.status + "je " + errorMsg;
        console.log(message);
      }
    });
  } else {
    let output = "";
    for (greska of greske) {
      output += `<li>${greska}</li>`;
      document.querySelector("#errorsCon").innerHTML = output;
    }
  }
}
