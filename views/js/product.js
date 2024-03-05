$(document).ready(function () {
    searchProduct()
}); 

function searchProduct() {

    let rol = $('#rol').val()

    let params = {
        'action': 'searchProduct',
        'id': $('#id').val(),
        'nombre': $('#nombre').val()
    };

    $.ajax({
        url: 'controllerProduct.php',
        type: 'GET',
        dataType: 'JSON',
        data: params,
        success: function(response) {
            if (response.error == false) {

                let action = rol == "Administrador" ? `<th>Acciones</th>` : ``;

                let result = `<tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Producto</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Estado</th>
                                ${action}
                            </tr>`;

                count = 0;

                response.data.forEach(element => {
                    state = element.prodEstado == 1 ? 'Activo' : 'Inactivo';
                    count++;
                    let editar = rol == 'Administrador' ? 
                            `<td>
                                <a href="controllerProduct.php?action=update&id=${element.prod_Id}" class="btn btn_edit">Editar</a>
                            </td>` : ``;
                    
                    result += `
                                <tr>
                                    <td>${element.prod_Id}</td>
                                    <td>${element.prod_Nombre}</td>
                                    <td><img src="../views/img/${element.prod_Foto}" class="img_table"></td>
                                    <td>${element.prod_Descripcion}</td>
                                    <td>${element.prod_Precio}</td>
                                    <td>${state}</td>
                                    ${editar}
                                 </tr>
                                `;
                });
                $('#tableProduct').html(result);
                $('#count').html(count);
            } else {
                console.log(response.message);
            }
        },
        error: function() {
            console.log('Fallo interno del servidor');
        }
    });
}