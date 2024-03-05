function message(type,message){
    Swal.fire({
        icon: type,
        title: 'DaCaAr System',
        text: message,
      })
}

function validate() {
    
    if ($('#user').val() == '') {
        message('error','El campo usuario no puede estar vacio')
    } else if ($('#password').val() == '') {
        message('error','El campo contraseña no puede estar vacio')
    } else {
        return true
    }
}

function validateLogin() {
    
    if (validate() == true) {
        
        params = {
            'action': 'validateLogin',
            'user': $('#user').val(),
            'password': $('#password').val()
        }

        $.ajax({
            url: 'controllerLogin.php',
            type: 'GET',
            dataType: 'json',
            data: params,
            success: function (response) {
                if (response.error == false) {

                    window.location.href = response.data.url
                } else {
                    message('error',response.message)
                }
            },
            error: function () {
                message('error','Hubo un problema interno con el servidor')
            }
        })
    }
}