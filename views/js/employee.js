$(document).ready(function () {
    searchEmployee()
}) 

function searchEmployee() {
    
    let params = {
        'action': 'searchEmployee',
        'id': $('#empl_Id').val(),
        'name': $('#empl_Nombre').val(),
        'lastName': $('#empl_Apellido').val()
    }

    $.ajax({
        url: 'controllerEmployee.php',
        type: 'GET',
        dataType: 'json',
        data: params,
        success: function (response) {
            if (response.error == false) {
                result = `<tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Tipo Documento</th>
                            <th>Documento</th>
                            <th>Telefono</th>
                            <th>Cargo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>`
                count = 0
                response.data.forEach(element => {
                    estado = element.UsEstado == 1 ? 'Activo' : 'Inactivo'
                    count++

                    result += `<tr>
                                <td>${element.empl_Id}</td>
                                <td>${element.empl_Nombre}</td>
                                <td>${element.empl_Apellido}</td>
                                <td>${element.tipo}</td>
                                <td>${element.empl_Documento}</td>
                                <td>${element.empl_Telefono}</td>
                                <td>${element.carg_Nombre}</td>
                                <td>${estado}</td>
                                <td>
                                    <a href="controllerEmployee.php?action=update&id=${element.empl_Id}" class="btn btn_edit">Editar</a>
                                </td>
                            </tr>`
                });
                $('#tableEmployee').html(result)
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