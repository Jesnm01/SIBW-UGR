const urlParams = new URLSearchParams(window.location.search);

$(document).ready(function(){

    // Para el resaltado de las querys buscadas en el search box
    var query;
    if(query = urlParams.get("q")){
        $("#titulo_evento").mark(query);
        $("#descripcion_evento").mark(query);
        $(".md-chip").mark(query);

        setTimeout(function(){
            $("#titulo_evento").unmark(query);
            $("#descripcion_evento").unmark(query);
            $(".md-chip").unmark(query);
        }, 10000);
    }

    // Para el buscador principal del header
    $("#busqueda").on("input focus", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings("#result");
        if(inputVal.length){
            $.ajax({
                data:{term:inputVal},
                url: 'busquedaAjax.php',
                type: 'get',
                beforeSend:function() {
                    resultDropdown.show(); 
                },
                success:function(respuesta){
                    generarListaDropDown(JSON.parse(respuesta), inputVal); //Con JSON.parse generamos un objeto a partir del string de respuesta
                },
                error:function (error, textStatus, errorThrown) {
                    alert("Ha ocurrido un error: " + error.status + " " + error.statusText + " " + " " + textStatus + " " + errorThrown);
                }

            });
        } else{
            resultDropdown.empty();
        }
    });


    // Para el buscador secundario de filtrado en el panel de eventos
    $("#busqueda2").on("input focus", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var tbody = $("body_tabla");
        if(inputVal.length){
            $.ajax({
                data:{term:inputVal},
                url: 'busquedaAjax.php',
                type: 'get',
                beforeSend:function() {
                    tbody.show(); 
                },
                success:function(respuesta){
                    generarTabla(JSON.parse(respuesta)); //Con JSON.parse generamos un objeto a partir del string de respuesta
                },
                error:function (error, textStatus, errorThrown) {
                    alert("Ha ocurrido un error: " + error.status + " " + error.statusText + " " + " " + textStatus + " " + errorThrown);
                }

            });
        } 
        else{
            tbody.empty();
        }
    });

    // Set search input value on click of result item
    // $(document).on("click", "#result p", function(){
    //     $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
    //     $(this).parent("#result").empty();
    // });
});


function generarListaDropDown(json, inputVal){
    // Hago la lista
    var resultDropdown = $("#result");
    var res = "";
console.log(inputVal);
    for (var i = 0 ; (i < json.length && i < 5); i++){
        res += "<a class='respuesta' href=" + "evento.php?ev=" + json[i].id + "&q=" + inputVal + ">" + json[i].nombre + "</a>";
    }

    resultDropdown.html(res);

    // Si hago click en otro lado, desaparece el campo de búsqueda
    // document.getElementById("result").addEventListener("focusout",function(){
    //     this.style.display = "none";
    //     console.log(this);
    // })
}

function generarTabla(json){
    // Hago la lista
    var tbody = $("#body_tabla");
    // tbody.empty();
    var res = "";
    for (var i = 0 ; (i < json.length); i++){
        res += "<tr><td>" + json[i].id + "</td><td><img src='" + json[i].path_foto_cabecera + "' width='40%'></td>" + "<td>" + json[i].nombre + "</td><td>" + json[i].lugar + "</td><td>" + json[i].fecha + "</td>";
        res += "<td><div class='botones-accion-comentario'><a id='boton_editar_comentario' href=editarEvento.php?id=" + json[i].id + ">Editar</a>";
        res += "<form action='borrarEvento.php' method='post' onsubmit= 'return confirmacion_modal()'><input type='hidden' name='id_evento' value='" + json[i].id + "'><input class='boton_borrar_comentario' type='submit' value='Borrar'/></form>";
        res += "</div>";

        res += "<form action='publicarEvento.php' method='post'><input type='hidden' name='id_evento' value='" + json[i].id + "'>";
        if (json[i].publicado == 0){
            res += "<p style='font-size: 17px; display: flex; justify-content: center;'>Publicado: <input type='checkbox' name='checkbox' value='" + json[i].id + "'></p>";
        }
        else{
            res += "<p style='font-size: 17px; display: flex; justify-content: center;'>Publicado: <input type='checkbox' name='checkbox' value='" + json[i].id + "' checked></p>";
        }
        res += "<input class='boton_borrar_comentario' type='submit' value='Cambiar publicacion'/></form>";
    }

    tbody.html(res);
}