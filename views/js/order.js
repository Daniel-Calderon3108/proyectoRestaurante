$(document).ready(function () {
    searchOrder()
})

function searchOrder() {
    let params = {
        'action': 'searchOrder',
        'id': $('#Id').val(),
        'customerName': $('#customerName').val(),
        'customerLastName': $('#customerLastName').val(),
        'fecha': $('#fecha').val()
    }

    let rol = $('#rol').val()

    $.ajax({
        url: 'controllerOrder.php',
        type: 'GET',
        dataType: 'json',
        data: params,
        success: function (response) {
            if (response.error == false) {
                result = `<tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Cada Uno</th>
                            <th>Total</th>
                            <th>Fecha Pedido</th>
                            <th>Fecha Llegada</th>
                            ${rol != 'Empleado' ? 
                            '<th>Acciones</th>' : ''}
                        </tr>`
                count = 0
                response.data.forEach(element => {
                    count++
                    editar = rol != 'Empleado'  ? 
                            `<td>
                                <a href="FormPedido.php?ped_Id=${element.ped_Id}" class="btn btn_edit">Editar</a>
                            </td>` : ``

                    result += `<tr>
                                <td>${element.ped_Id}</td>
                                <td>${element.clie_Nombre+" "+ element.clie_Apellido}</td>
                                <td>${element.prod_Nombre}</td>
                                <td>${element.ped_Cantidad}</td>
                                <td>${element.precio_unidad}</td>
                                <td>${element.ped_Total}</td>
                                <td>${element.ped_FechaPedido}</td>
                                <td>${element.ped_FechaLlegada}</td>
                                ${editar}
                            </tr>`                   
                });
                $('#tableOrder').html(result)
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