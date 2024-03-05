$(document).ready(function () {
    searchInventory()
})

function searchInventory() {
    let params = {
        'action': 'searchInventory',
        'id': $('#detIng_Id').val(),
        'inventory': $('#ing_Nombre').val(),
        'provider': $('#prov_Nombre').val(),
        'branch': $('#sede_Nombre').val()
    }

    let rol = $('#rol').val()

    $.ajax({
        url: 'controllerInventory.php',
        type: 'GET',
        dataType: 'json',
        data: params,
        success: function (response) {
            if (response.error == false) {
                result = `<tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Proveedor</th>
                            <th>Sede</th>
                            <th>Ciudad</th>
                            <th>País</th>
                            <th>Estado</th>
                            ${rol == 'Administrador' || $rol == 'Proveedor' ? 
                            '<th>Acciones</th>' : ''}
                        </tr>`
                count = 0
                response.data.forEach(element => {
                    estado = element.ingEstado == 1 ? 'Activo' : 'Inactivo'
                    count++
                    editar = rol == 'Administrador' || rol == 'Proveedor' ? 
                            `<td>
                                <a href="controllerInventory.php?action=update&id=${element.detIng_Id}" class="btn btn_edit">Editar</a>
                            </td>` : ``

                    result += `<tr>
                                <td>${element.detIng_Id}</td>
                                <td>${element.ing_Nombre}</td>
                                <td><img src="../Views/img/${element.ing_Foto}" class="img_table"></td>
                                <td>${element.detIng_cantidad}</td>
                                <td>${element.detIng_precio}</td>
                                <td>${element.prov_Nombre}</td>
                                <td>${element.sede_Nombre}</td>
                                <td>${element.ciud_Nombre}</td>
                                <td>${element.pais_Nombre}</td>
                                <td>${estado}</td>
                                ${editar}
                            </tr>`                   
                });
                $('#tableInventory').html(result)
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