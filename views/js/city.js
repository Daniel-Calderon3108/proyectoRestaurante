$(document).ready(function () {
    searchCity()
})

function searchCity() {
    let params = {
        'action': 'searchCity',
        'id': $('#ciud_Id').val(),
        'city': $('#ciud_Nombre').val(),
        'country': $('#pais_Nombre').val(),
    }   

    let rol = $('#rol').val()

    $.ajax({
        url: 'controllerCity.php',
        type: 'GET',
        dataType: 'json',
        data: params,
        success: function (response) {

            if (response.error == false) {
                result = `<tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>País</th>
                            <th>Estado</th>
                            ${rol == 'Administrador' ? '<th>Acciones</th>' : '' }
                        </tr>`
                count = 0
                response.data.forEach(element => {
                    estado = element.ciudEstado == 1 ? 'Activo' : 'Inactivo'
                    count++
                    editar = rol == 'Administrador' ? 
                            `<td>
                                <a href="controllerCity.php?action=update&id=${element.ciud_Id}" class="btn btn_edit">Editar</a>
                            </td>` : ``

                    result += `<tr>
                                <td>${element.ciud_Id}</td>
                                <td>${element.ciud_Nombre}</td>
                                <td>${element.pais_Nombre}</td>
                                <td>${estado}</td>
                                ${editar}
                            </tr>`
                });
                $('#tableCity').html(result)
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