$(document).ready(function () {
    searchBranch()
})

function searchBranch() {
    let params = {
        'action': 'searchBranch',
        'id': $('#sede_Id').val(),
        'name': $('#sede_Nombre').val()
    }   

    let rol = $('#rol').val()

    $.ajax({
        url: 'controllerBranch.php',
        type: 'GET',
        dataType: 'json',
        data: params,
        success: function (response) {

            if (response.error == false) {
                result = `<tr>
                            <th>ID</th>
                            <th>Sede</th>
                            <th>Proveedor</th>
                            <th>Ciudad</th>
                            <th>Pais</th>
                            <th>Estado</th>
                            ${rol == 'Administrador' ? '<th>Acciones</th>' : '' }
                        </tr>`
                count = 0
                response.data.forEach(element => {
                    estado = element.sedeEstado == 1 ? 'Activo' : 'Inactivo'
                    count++
                    editar = rol == 'Administrador' ? 
                            `<td>
                                <a href="controllerBranch.php?action=update&id=${element.sede_Id}" class="btn btn_edit">Editar</a>
                            </td>` : ``

                    result += `<tr>
                                <td>${element.sede_Id}</td>
                                <td>${element.sede_Nombre}</td>
                                <td>${element.prov_Nombre}</td>
                                <td>${element.ciud_Nombre}</td>
                                <td>${element.pais_Nombre}</td>
                                <td>${estado}</td>
                                ${editar}
                            </tr>`
                });
                $('#tableBranch').html(result)
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