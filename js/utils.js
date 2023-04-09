var alertaDiv = document.getElementById("alerta");
var temaActual = true; // True = Blanco

function validationLogin() {  
    var user = document.f1.user.value;
    var pass = document.f1.pass.value;

    if (user.length == "" || pass.length == "") {
        alertaDanger("Faltan campos por rellenar");
        return false;
    } else {
        $.ajax({
            url: 'login.php',
            method: 'POST',
            data: {
                user: user,
                pass: pass,
                action: 'login'
            },
            success: function (response) {
                if (response == 1) {
                    alertaDanger("Credenciales incorrectas");
                } else {
                    // Redirigir al usuario a la página de inicio
                    window.location.href = 'feed.php';
                }
            },
            error: function () {
                alertaDanger("Error de conexión");
            }
        });
    }
}

function alertaOk(texto){
    var colorBack = "#8CE38F";
    var colorText = "#418663";
    alertaDiv.style.backgroundColor = colorBack;
    alertaDiv.style.color = colorText;

    document.getElementById('alerta-mensaje').innerHTML = texto;
    alertaDiv.style.pointerEvents = "auto";
    alertaDiv.style.display = "block";

    setTimeout(function() {
        alertaDiv.style.display = "none";
    }, 5000);
}

function alertaDanger(texto){
    var colorBack = "#E69696";
    var colorText = "#934141";
    alertaDiv.style.backgroundColor = colorBack;
    alertaDiv.style.color = colorText;

    document.getElementById('alerta-mensaje').innerHTML = texto;
    alertaDiv.style.pointerEvents = "auto";
    alertaDiv.style.display = "block";

    setTimeout(function() {
        alertaDiv.style.display = "none";
    }, 5000);
}

function validationSignup()
{
    var id=document.f1.user.value;
    var ps=document.f1.pass.value;
    var em=document.f1.email.value;
    var colorBack = "#E69696";
    var colorText = "#934141";
    alertaDiv.style.backgroundColor = colorBack;
    alertaDiv.style.color = colorText;

    if(id.length=="" || ps.length=="" || em.length=="") {
        document.getElementById('alerta-mensaje').innerHTML = 'Hay campos estan sin rellenar';
        alertaDiv.style.pointerEvents = "auto";
        alertaDiv.style.display = "block";

        setTimeout(function() {
            alertaDiv.style.display = "none";
        }, 6000);
        
        return false;
    } else {
        $.ajax({
            url: 'registrarse.php',
            method: 'POST',
            data: {
                user: id,
                pass: ps,
                email: em,
                action: 'insert'
            },
            success: function (response) {
                if (response == 1) {
                    alertaOk("Registro completado");
                } else if (response == 2) {
                    alertaDiv.style.pointerEvents = "auto";
                    alertaDiv.style.display = "block";
                    document.getElementById('alerta-mensaje').innerHTML = 'El correo ya esta registrado';
                } else {
                    alertaDiv.style.pointerEvents = "auto";
                    alertaDiv.style.display = "block";
                    document.getElementById('alerta-mensaje').innerHTML = 'Error en la base de datos';
                }
            },
            error: function () {
                alertaDiv.style.pointerEvents = "auto";
                alertaDiv.style.display = "block";
                document.getElementById('alerta-mensaje').innerHTML = 'Error de conexión';
            }
        });
    }
}

function pasarDatosClase() {
    // Obtener la fila seleccionada
    var selectedRow = document.querySelector(".table .selected");

    // Verificar si se ha seleccionado una fila
    if (selectedRow !== null) {
        // Obtener los datos de la fila seleccionada
        var idclase = selectedRow.querySelector("td:nth-child(1)").innerHTML;
        var curso = selectedRow.querySelector("td:nth-child(2)").innerHTML;
        var letra = selectedRow.querySelector("td:nth-child(3)").innerHTML;
        var alumnos = selectedRow.querySelector("td:nth-child(4)").innerHTML;
        var materia = selectedRow.querySelector("td:nth-child(5)").innerHTML;

        // Redirigir a la página de modificación con los datos de la fila seleccionada como parámetros en la URL
        window.location.href = "modificarClase.php?idclase=" + idclase + "&curso=" + curso + "&letra=" + letra + "&alumnos=" + alumnos + "&materia=" + materia;
    } else {
        // Mostrar una alerta si no se ha seleccionado ninguna fila
        alertaDanger("Por favor, seleccione una fila para modificar");
    }
}

function pasarDatosAlumno() {
    // Obtener la fila seleccionada
    var selectedRow = document.querySelector(".table .selected");

    // Verificar si se ha seleccionado una fila
    if (selectedRow !== null) {
        // Obtener los datos de la fila seleccionada
        var idalumno = selectedRow.querySelector("td:nth-child(1)").innerHTML;
        var nombre = selectedRow.querySelector("td:nth-child(2)").innerHTML;
        var apellido = selectedRow.querySelector("td:nth-child(3)").innerHTML;
        var correo = selectedRow.querySelector("td:nth-child(4)").innerHTML;
        var ano = selectedRow.querySelector("td:nth-child(5)").innerHTML;
        var numero = selectedRow.querySelector("td:nth-child(6)").innerHTML;
        var estado = selectedRow.querySelector("td:nth-child(7)").innerHTML;
        var clase = selectedRow.querySelector("td:nth-child(8)").innerHTML;

        // Redirigir a la página de modificación con los datos de la fila seleccionada como parámetros en la URL
        window.location.href = "modificarAlumno.php?idalumno=" + idalumno + "&nombre=" + nombre + "&apellido=" + 
        apellido + "&correo=" + correo + "&ano=" + ano + "&numero=" + numero + "&estado=" + estado + "&clase=" + clase;
    } else {
        // Mostrar una alerta si no se ha seleccionado ninguna fila
        alertaDanger("Por favor, seleccione una fila para modificar");
    }
}

function modificarClase(){

    var idclaseActual = document.getElementById("idclaseActual").textContent;
    var cursoNuevo = document.getElementById("curso-select").value;
    var letranum = document.getElementById("letra-select");
    var letraNueva = letranum.options[letranum.selectedIndex].text;
    var materiaNueva = document.getElementById("materia-select").value;

    $.ajax({
        url: 'procesarModClase.php',
        method: 'POST',
        data: {
            idclaseActual: idclaseActual,
            cursoNuevo: cursoNuevo,
            materiaNueva: materiaNueva,
            letraNueva: letraNueva,
            action: 'modificarClase'
        },
        success: function(response) {
            if (response == 1) {
                alertaOk("Clase modificada con éxito");
            } else if (response == 2) {
                alertaDanger("Ya existe una clase con esos datos");
            } else {
                alertaDanger("Error en la base de datos");
            }
        },
        error: function() {
            alertaDanger("Error de conexión");
        }
    });
}

function modificarAlumno(){

    var al_name = document.getElementById("al_name").value;
    var al_apellido = document.getElementById("al_apellido").value;
    var al_correo = document.getElementById("al_correo").value;
    var al_fecha = document.getElementById("al_fecha").value;
    var al_numero = document.getElementById("al_numero").value;
    var al_id = document.getElementById("idalumnoActual").textContent;
    

    var al_estado_num = document.getElementById("al_estado");
    var al_estado = al_estado_num.options[al_estado_num.selectedIndex].value;

    var al_clase_num = document.getElementById("al_clase");
    var al_clase = al_clase_num.options[al_clase_num.selectedIndex].value;

    if(al_name.length=="" || al_apellido.length=="" || al_correo.length=="" || al_fecha.length=="" || al_numero.length=="" || al_estado.length=="" || al_clase.length==""){
        alertaDanger("Hay campos sin rellenar");
    } else {
        $.ajax({
            url: 'procesarModAlumno.php',
            method: 'POST',
            data: {
                al_name: al_name,
                al_apellido: al_apellido,
                al_correo: al_correo,
                al_fecha: al_fecha,
                al_numero: al_numero,
                al_estado: al_estado,
                al_clase: al_clase,
                al_id: al_id,
                action: 'modificarAlumno'
            },
            success: function(response) {
                if (response == 1) {
                    alertaOk("Alumno guardado");
                } else if (response == 2) {
                    alertaDanger("Los datos son los mismos");
                } else {
                    alertaDanger("Error en la base de datos");
                }
            },
            error: function() {
                alertaDanger("Error de conexión");
            }
        });
    }
}

function modificarUsuario(){

    var nombre = document.getElementById("nombre").value;
    var correo = document.getElementById("correo").value;
    var pass_actual = document.getElementById("pass-actual").value;
    var pass_nueva = document.getElementById("pass-nueva").value;

    if(nombre.length=="" || correo.length=="" || pass_actual.length=="" || pass_nueva.length==""){
        alertaDanger("Hay campos sin rellenar");
    }else{
        $.ajax({
            url: 'procesarModUsuario.php',
            method: 'POST',
            data: {
                nombre: nombre,
                correo: correo,
                pass_actual: pass_actual,
                pass_nueva: pass_nueva,
                action: 'modificarUsuario'
            },
            success: function(response) {
                if (response == 1) {
                    alertaOk("Usuario guardado");
                } else if (response == 2) {
                    alertaDanger("Los datos son los mismos");
                } else if (response == 3){
                    alertaDanger("Contraseña incorrecta");
                } else {
                    alertaDanger("Error en la base de datos");
                }
            },
            error: function() {
                alertaDanger("Error de conexión");
            }
        });
    }
}
  

function crearClase(){

    var curso = document.getElementById("curso-select").value;
    var letranum = document.getElementById("letra-select");
    var letra = letranum.options[letranum.selectedIndex].text;
    var materia = document.getElementById("materia-select").value;

    $.ajax({
        url: 'procesarCrearClase.php',
        method: 'POST',
        data: {
            curso: curso,
            letra: letra,
            materia: materia,
            action: 'insertClase'
        },
        success: function(response) {
            if (response == 1) {
                alertaOk("Clase creada");
            } else if (response == 2) {
                alertaDanger("La clase ya existe");
            } else {
                alertaDanger("Error en la base de datos");
            }
        },
        error: function() {
            alertaDanger("Error de conexión");
        }
    });
}

function crearAlumno(){

    var al_name = document.getElementById("al_name").value;
    var al_apellido = document.getElementById("al_apellido").value;
    var al_correo = document.getElementById("al_correo").value;
    var al_fecha = document.getElementById("al_fecha").value;
    var al_numero = document.getElementById("al_numero").value;

    var al_estado_num = document.getElementById("al_estado");
    var al_estado = al_estado_num.options[al_estado_num.selectedIndex].value;

    var al_clase_num = document.getElementById("al_clase");
    var al_clase = al_clase_num.options[al_clase_num.selectedIndex].value;

    if(al_name.length=="" || al_apellido.length=="" || al_correo.length=="" || al_fecha.length=="" || al_numero.length=="" || al_estado.length=="" || al_clase.length==""){
        alertaDanger("Hay campos sin rellenar");
    } else {
        $.ajax({
            url: 'procesarCrearAlumno.php',
            method: 'POST',
            data: {
                al_name: al_name,
                al_apellido: al_apellido,
                al_correo: al_correo,
                al_fecha: al_fecha,
                al_numero: al_numero,
                al_estado: al_estado,
                al_clase: al_clase,
                action: 'insertAlumno'
            },
            success: function(response) {
                if (response == 1) {
                    alertaOk("Alumno creado");
                } else if (response == 2) {
                    alertaDanger("El alumno ya existe");
                } else {
                    alertaDanger("Error en la base de datos");
                }
            },
            error: function() {
                alertaDanger("Error de conexión");
            }
        });
    }
}

function redirectNuevoAlumno(){
    if (!location.pathname.includes("alumnos.php")) {
        window.history.back();
    } else if (location.pathname.includes("alumnos.php")) {
        // Si la URL actual incluye "otra-pagina.html", redirigir a "pagina2.html"
        window.location.href = "nuevoAlumno.php";
    }
}

function redirectModificarClase(){
    if (!location.pathname.includes("feed.php")) {
        window.history.back();
    } else if (location.pathname.includes("feed.php")) {
        // Si la URL actual incluye "otra-pagina.html", redirigir a "pagina2.html"
        window.location.href = "modificarClase.php";
    }
}

function redirectRegister(){
    if (!location.pathname.includes("signup.html")) {
        // Si la URL actual incluye "index.html", redirigir a "pagina1.html"
        window.location.replace("signup.html");
    } else if (location.pathname.includes("signup.html")) {
        // Si la URL actual incluye "otra-pagina.html", redirigir a "pagina2.html"
        window.location.replace("index.html");
    }
}

function redirectNuevaClase(){
    if (!location.pathname.includes("feed.php")) {
        window.history.back();
    } else if (location.pathname.includes("feed.php")) {
        // Si la URL actual incluye "otra-pagina.html", redirigir a "pagina2.html"
        window.location.href = "nuevaClase.php";
    }
}

function redirectModificarAlumno() {
    if (!location.pathname.includes("alumno.php")) {
        window.history.back();
    } else if (location.pathname.includes("alumno.php")) {
        // Si la URL actual incluye "otra-pagina.html", redirigir a "pagina2.html"
        window.location.href = "modificarAlumno.php";
    }
}

function redirect(){
    window.history.back();
}