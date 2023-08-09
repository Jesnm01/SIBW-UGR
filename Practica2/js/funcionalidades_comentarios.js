
const months = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
]
  
const days = [
    'Sun',
    'Mon',
    'Tue',
    'Wed',
    'Thu',
    'Fri',
    'Sat'
]

const emailRegExp = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
const banned_words = ["de locos","amputar","joder","joputa","fuck","moron","imbecil"];

function mostarFormulario(id){
    if (document.getElementById){ //se obtiene el id
        var section = document.getElementById(id); //se define la variable "el" igual a nuestro div
        section.style.display = (section.style.display == 'none') ? 'block' : 'none'; //damos un atributo display:none que oculta la section de comentarios
    }
}

//Esta es una funcion que se ejecuta cuando cargamos la pagina
// Lo que hace es llamar a la funcion que muestra/oculta la seccion de comentarios
// Esto lo hago para que nada más entrar en la pagina se oculte la caja de comentarios, y se inicialice la variable 'display = none' y que la funcion de arriba no de problemas (tenia que darle doble click la primera vez para que funcionase, ahora no)
window.onload = function(){
    mostarFormulario('comment-section');
}

//Funcion para crear un nuevo comentario, directamente modificando el innerHTML de la caja de comentarios
function crearComentario(){
    var fecha = new Date();
    var fecha_formateada = '' + days[fecha.getDay()] + ' ' 
    + months[fecha.getMonth()] + ' ' + fecha.getDate() + ' ' 
    + fecha.getFullYear() + ' ' + fecha.getHours() + ':' 
    + fecha.getMinutes() + ':' + fecha.getSeconds();

    var comentarios = document.getElementById('uploaded-comments');
    comentarios.innerHTML += '<div class="comment"><h4 class="comment-author-date">' 
    + document.getElementById('nombre').value + ', comentado el: ' + fecha_formateada + '</h4>'
    + '<p class="comment-content">' + document.getElementById('msg').value + '</p></div>';
}

function enviarComentario(){
    // Realizamos la validacion de campos
    var valor_nick = document.getElementById('nombre').value;
    var valor_email = document.getElementById('mail').value;
    var valor_mensaje = document.getElementById('msg').value;

    if(valor_nick == null || valor_nick.length == 0){
        alert("Introduce un nickname para el comentario");
        return false; //Para cortar la propagacion del evento
    }
    else
        if(valor_email == null || valor_email.length == 0){
            alert("Introduce un email para el comentario");
            return false; //Para cortar la propagacion del evento
        }
        else
            if(!emailRegExp.test(valor_email)){
                alert("Introduce un email con formato valido");
                return false; //Para cortar la propagacion del evento
            }
            else
                if(valor_mensaje == null || valor_mensaje.length == 0){
                    alert("El comentario no puede estar vacio");
                    return false; //Para cortar la propagacion del evento
                }
    
    // Si ha pasado todos los filtros anteriores, se crea el comentario
    crearComentario();
}

//Cada vez que el usuario escribe un caracter en el chat se llama a esta funcion
function censurar(){
    var mensaje = document.getElementById("msg").value;
    // Se comprueban todas las palabras baneadas, y si coincide con el texto, se sustituye por tantos asteriscos como tenga la palabra
    for(i=0; i<banned_words.length; i++){
        if(mensaje.includes(banned_words[i])){
            mensaje = mensaje.replace(banned_words[i],"*".repeat(banned_words[i].length))
        }
    }
    document.getElementById("msg").value = mensaje;
}