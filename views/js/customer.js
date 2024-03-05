$(document).ready(function () {
    searchCustomer()
})

function searchCustomer() {

    let params = {
        'action': 'searchCustomer',
        'id': $('#clie_Id').val(),
        'name': $('#clie_Nombre').val(),
        'lastName': $('#clie_Apellido').val(),

    }

    let rol = $('#rol').val()

    $.ajax({
        url: 'controllerCustomer.php',
        type: 'GET',
        dataType: 'json',
        data: params,
        success: function (response) {

            if (response.error == false) {
                result = `<tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                           <th>Correo</th>
                            <th>Dirección</th>
                            <th>Celular</th>
                            <th>Estado</th>
                            ${rol == 'Administrador' ? '<th>Acciones</th>' : '' }
                        </tr>`
                count = 0
                response.data.forEach(element => {
                    estado = element.clieEstado == 1 ? 'Activo' : 'Inactivo'
                    count++
                    editar = rol == 'Administrador' ? 
                            `<td>
                                <a href="controllerCustomer.php?action=update&id=${element.clie_Id}" class="btn btn_edit">Editar</a>
                            </td>` : ``

                    result += `<tr>
                                <td>${element.clie_Id}</td>
                                <td>${element.clie_Nombre}</td>
                                <td>${element.clie_Apellido}</td>
                                <td>${element.clie_Correo}</td>
                                <td>${element.clie_Direccion}</td>
                                <td>${element.clie_Celular}</td>
                                <td>${estado}</td>
                                ${editar}
                            </tr>`
                });
                $('#tableCustomer').html(result)
                $('#count').html(count)
            } else {
                console.log(response.message)
            }
        },
        error: function () {
            console.log('Fallo interno del servidor');
        }
    })
}