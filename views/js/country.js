$(document).ready(function () {
    searchCountry()
})

function searchCountry() {
    let params = {
        'action': 'searchCountry',
        'id': $('#pais_Id').val(),
        'name': $('#pais_Nombre').val()
    }   

    let rol = $('#rol').val()

    $.ajax({
        url: 'controllerCountry.php',
        type: 'GET',
        dataType: 'json',
        data: params,
        success: function (response) {

            if (response.error == false) {
                result = `<tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Bandera</th>
                            <th>Estado</th>
                            ${rol == 'Administrador' ? '<th>Acciones</th>' : '' }
                        </tr>`
                count = 0
                response.data.forEach(element => {
                    estado = element.paisEstado == 1 ? 'Activo' : 'Inactivo'
                    count++
                    editar = rol == 'Administrador' ? 
                            `<td>
                                <a href="controllerCountry.php?action=update&id=${element.pais_Id}" class="btn btn_edit">Editar</a>
                            </td>` : ``

                    result += `<tr>
                                <td>${element.pais_Id}</td>
                                <td>${element.pais_Nombre}</td>
                                <td><img src="../Views/img/${element.bandera}" class="img_table"></td>
                                <td>${estado}</td>
                                ${editar}
                            </tr>`
                });
                $('#tableCountry').html(result)
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