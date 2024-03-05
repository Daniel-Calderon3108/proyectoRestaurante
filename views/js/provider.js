$(document).ready(function () {
    searchProvider()
})

function searchProvider() {
    let params = {
        'action': 'searchProvider',
        'id': $('#prov_Id').val(),
        'name': $('#prov_Nombre').val()
    }   

    let rol = $('#rol').val()

    $.ajax({
        url: 'controllerProvider.php',
        type: 'GET',
        dataType: 'json',
        data: params,
        success: function (response) {

            if (response.error == false) {
                result = `<tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tipo Documento</th>
                            <th>Documento</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th>Página Web</th>
                            <th>Estado</th>
                            ${rol == 'Administrador' ? '<th>Acciones</th>' : '' }
                        </tr>`
                count = 0
                response.data.forEach(element => {
                    estado = element.UsEstado == 1 ? 'Activo' : 'Inactivo'
                    count++
                    editar = rol == 'Administrador' ? 
                            `<td>
                                <a href="controllerProvider.php?action=update&id=${element.prov_Id}" class="btn btn_edit">Editar</a>
                            </td>` : ``

                    result += `<tr>
                                <td>${element.prov_Id}</td>
                                <td>${element.prov_Nombre}</td>
                                <td>${element.tipo}</td>
                                <td>${element.prov_Documento}</td>
                                <td>${element.prov_Correo}</td>
                                <td>${element.prov_Telefono}</td>
                                <td>${element.prov_Link_Pagina}</td>
                                <td>${estado}</td>
                                ${editar}
                            </tr>`
                });
                $('#tableProvider').html(result)
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