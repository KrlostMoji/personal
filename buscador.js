const buscar = document.querySelector('#busqueda');

const nombre = document.querySelector('#nombre');
const ciudad = document.querySelector('#ciudad');
const cp = document.querySelector('#cp');
const estado = document.querySelector('#estado');
const tipo = document.querySelector('#tipoTurismo');

const datosBusqueda = {

    nombre : '',
    ciudad : '',
    estado : '',
    cp : '',
    tipo : ''

}


eventListeners();



function eventListeners () {

    
    document.addEventListener('DOMContentLoaded', () => {

        mostrarSitios(lugares);

    });

    nombre.addEventListener('blur', e => {

        datosBusqueda.nombre = e.target.value.toLowerCase();
        busqueda();

    });

    ciudad.addEventListener('blur', e => {

        datosBusqueda.ciudad = e.target.value;
        busqueda();
        
    });

    cp.addEventListener('blur', e => {

        datosBusqueda.cp = e.target.value;
        busqueda();

    });

    estado.addEventListener('blur', e => {

        datosBusqueda.estado = e.target.value;
        busqueda(); 

    });

    tipo.addEventListener('blur', e => {

        datosBusqueda.tipo = e.target.value.toLowerCase();
        busqueda();

    });


}


function mostrarSitios(lugares){

    limpiarResultados();

    const tablaResultado = document.querySelector('.resultados')

    lugares.forEach(lugar => {
        
        const sitioHTML = document.createElement('div');
        sitioHTML.innerHTML = `<p>${lugar.nombre}</p`;
        sitioHTML.classList.add('resultado');
        tablaResultado.appendChild(sitioHTML);
    });

}

function limpiarResultados (){

    const contenedor = document.querySelector('.resultados');
    const errores = document.querySelector('.mensaje-error')

    while(contenedor.firstChild){

        contenedor.removeChild(contenedor.firstChild);

    }

    while(errores.firstChild){

        errores.removeChild(errores.firstChild);
    
    }

}


function busqueda (){

    if(datosBusqueda.ciudad === '' && datosBusqueda.cp === '' && datosBusqueda.estado ==='' && datosBusqueda.nombre === '' && datosBusqueda.tipo === ''){

        mostrarSitios(lugares);

    } else {

        const consulta = lugares.filter(filtrarCiudad).filter(filtrarEstado).filter(filtrarCp).filter(filtrarNombre).filter(filtrarTipo);

        if (consulta.length){
            mostrarSitios(consulta);
    
        } else {
    
            sinresultados();
    
        }

    }
    



}



function sinresultados(){

    limpiarResultados();

    const divResultados= document.querySelector('.mensaje-error');
    const noResultados = document.createElement('p');
    noResultados.innerHTML = 'No hay resultados. Intenta otra palabra, o revisa que estén bien escritas.';
    noResultados.classList.add('p-error');
    divResultados.appendChild(noResultados); 


}


//Funciones para el filtrado 


function filtrarCiudad (lugar){

    if(datosBusqueda.ciudad){
        return lugar.ciudad === datosBusqueda.ciudad;
    }
    
    return lugar;
}


function filtrarCp (lugar){

    if(datosBusqueda.cp){
        return lugar.cp === datosBusqueda.cp;
    } 

    return lugar;

}


function filtrarEstado (lugar){

    if(datosBusqueda.estado){
        return lugar.estado === datosBusqueda.estado;
    } 

    return lugar;

}



function filtrarNombre (lugar){

    if(datosBusqueda.nombre){

        if(!lugar.nombre.includes(datosBusqueda.nombre))
        {
            return lugar.nombre === datosBusqueda.nombre;
        }
            
    } 

    return lugar;

}


function filtrarTipo (lugar){

    if(datosBusqueda.tipo){
        return lugar.tipoTurismo === datosBusqueda.tipo || lugar.tipoTurismo2 === datosBusqueda.tipo;
    } 

    return lugar;

}