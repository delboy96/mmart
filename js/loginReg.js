document.addEventListener('DOMContentLoaded', function () {
  var loginbtn = document.querySelector('#login-btn')
  var regbtn = document.querySelector('#reg-btn')

  if (loginbtn) {
    loginbtn.addEventListener('click', login)
  }
  if (regbtn) {
    regbtn.addEventListener('click', reg)
  }

  function login () {
    var mejlPolje = document.getElementById('mejlL').value
    var passPolje = document.getElementById('passL').value

    //skolski
    // var reMejl = /^[a-z]+\.[a-z]+\.([1-9][0-9]{0,3})\.(1[0-8])\@ict\.edu\.rs$/;

    var rePass = /^[0-9A-z]{4,}$/
    var reMejl = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

    var greske = []

    if (!reMejl.test(mejlPolje)) {
      greske.push('E-mail not valid.')
    }

    if (!rePass.test(passPolje)) {
      greske.push('Password not valid.')
    }

    if (greske.length === 0) {
      console.log('ok')

      $.ajax({
        type: 'POST',
        url: 'api/auth/login.php',
        dataType: 'text',
        data: {
          email: mejlPolje,
          password: passPolje,
          loginBtn: 'sent'
        },
        success: function (data) {
          window.location = 'index.php?page=gallery'
          console.log(data)
        },
        error: function (xhr, status, errorMsg) {
          const { message } = JSON.parse(xhr.responseText)
          switch (xhr.status) {
            case 400:
              document.querySelector('#errors').innerHTML = `<p style="color: red;">${message}</p>`
              break
            case 409:
              document.querySelector('#errors').innerHTML = `<p style="color: red;">${message}</p>`
              break
          }
        }
      })
    } else {
      let output = ''
      for (greska of greske) {
        output += `<li style="color:red;">${greska}</li>`
        document.querySelector('#errors').innerHTML = output
      }
    }
  }

  function reg () {
    var usernamePolje = document.getElementById('usernameR').value
    var mejlPolje = document.getElementById('mejlR').value
    var passPolje = document.getElementById('passR').value
    var repassPolje = document.getElementById('repassR').value

    var reUser = /^([a-zA-Z]{2,15})+$/
    var reMejl = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    var reSifra = /^[0-9A-z]{4,}$/

    var greske = []

    if (!reUser.test(usernamePolje)) {
      greske.push('Username not valid.')
    }

    if (!reMejl.test(mejlPolje)) {
      greske.push('E-mail not valid.')
    }

    if (!reSifra.test(passPolje)) {
      greske.push('Password do not answer requirements.')
    }

    if (!reSifra.test(repassPolje) && repassPolje == passPolje) {
      greske.push(
        'Password not same as first one or do not answer requirements.'
      )
    }

    if (greske.length === 0) {
      console.log('ok')

      $.ajax({
        type: 'POST',
        url: 'api/auth/register.php',
        dataType: 'text',
        data: {
          user: usernamePolje,
          email: mejlPolje,
          password: passPolje,
          repassword: repassPolje,
          registerBtn: 'sent'
        },

        success: function (data) {
          window.location = 'index.php?page=login'
          console.log(data)
        },
        error: function (xhr, status, errorMsg) {
          const { message } = JSON.parse(xhr.responseText)
          switch (xhr.status) {
            case 409:
              document.querySelector('#errors').innerHTML = message
              break
            case 422:
              console.log('greske')
            default:
              console.log('osecam se sjajnoo')
              break
          }
        }
        // console.dir(xhr)
        // alert(errorMsg.message)
        // let message = 'Kod' + xhr.status + 'je ' + errorMsg + 'je ' + status
        // console.log(message)
        // console.log(xhr.responseJSON)
      })
    } else {
      let output = ''
      for (greska of greske) {
        output += `<li style="color:red;">${greska}</li>`
        document.querySelector('#errors').innerHTML = output
      }
    }
  }

})
