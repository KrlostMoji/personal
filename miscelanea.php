<?php 

  require 'build/config/database.php';

  $consulta = "SELECT * FROM sitios";

  $resultado = mysqli_query($bd, $consulta);


  $nombre = '';
  $ciudad = '';
  $estado = '';
  $turismo = '';
  $nombrePorcentaje = '';
 
  // echo '<pre>';
  // var_dump($_SERVER);
  // echo $_SERVER;
  // echo '</pre>';
  // exit;



  if(isset($_SERVER)){

    if($_SERVER['REQUEST_METHOD'] === "GET" && $_SERVER['REQUEST_URI'] !== "/miscelanea.php"){

      $nombre = $_GET['nombre'];
      $ciudad = $_GET['ciudad'];
      $estado = $_GET['estado'];
      $turismo = $_GET['turismo'];
  


  
      if($nombre !== ''){
        $nombrePorcentaje = '%'.$nombre.'%';
      } else {
        $nombrePorcentaje = $nombre;
      }
  
      $consultaLugares = "SELECT sitios.sitio, sitios.descripcion, sitios.imagen, tipo_turismo.turismo AS turismo1, tipo_turismo2.turismo AS turismo2, localidad.localidad, municipios.municipio, estados.estados, paises.paises, localidad.cp FROM sitios 
      INNER JOIN localidad ON sitios.localidadId = localidad.id
      INNER JOIN municipios ON localidad.municipioId = municipios.id
      LEFT JOIN tipo_turismo ON sitios.tipo1 = tipo_turismo.id
      LEFT JOIN tipo_turismo2 ON sitios.tipo2 = tipo_turismo2.id
      INNER JOIN estados ON municipios.estadoId = estados.id
      INNER JOIN paises ON estados.paisId = paises.id
      WHERE sitios.sitio LIKE '${nombrePorcentaje}' OR 
      tipo_turismo.turismo LIKE '${turismo}' OR
      tipo_turismo2.turismo LIKE '${turismo}' OR 
      localidad.localidad LIKE '${ciudad}' OR 
      municipios.municipio LIKE '${ciudad}' OR 
      estados.estados LIKE '${estado}'";
  
      $resultadoLugares = mysqli_query($bd, $consultaLugares);

    }
  


  }
  


  

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="build/css/app.css">
    <title>Moji's Web</title>
</head>
<body>
    <header class="header inicio">
        <div class="header-contenido">
            <div class="logo">
                <a href="index.html"><h1>Mojica</h1></a>
            </div>
            <div class="navegacion">
                <nav class="navegacion-contenido">
                    <a href="redes.html">Redes</a>
                    <a href="contacto.html">Contacto</a>
                    <a href="miscelanea.php">Miscélanea</a>
                </nav>
            </div>
        </div>
    </header>
    <main class="contenedor informacion sombra min-height">
        <div class="informacion-contenido">
          <h1 class="informacion-header">Un mundo por conocer</h1>
          <p>En esta sección podrás filtrar por ciudad, estado, C.P. o nombre, una lista de sitios turísticos alrededor del mundo, los más relevantes. Sé paciente, aún nos encontramos en desarrollo, poco a poco se irán subiendo más sitios.</p>
          <p>Escribe palabras claves y utiliza sólo un campo para la búsqueda.</p>
        </div>
          <form class="formulario sombra contenido-centrado" method="GET">
            <fieldset>
              <legend>Filtrado.</legend>
              <div class="campos filtro">
                <div class="campo">
                  <label>Ciudad</label>
                  <input id="ciudad" class="input-text" type="text" placeholder="Ciudad" name="ciudad" value="<?php echo $ciudad; ?>" />
                </div>
                <div class="campo">
                  <label>Estado</label>
                  <input id="estado" class="input-text" type="text" placeholder="Estado" name="estado" value="<?php echo $estado; ?>"/>          
                </div>
                <div class="campo">
                  <label>Tipo de turismo</label>
                  <input id="tipoTurismo" class="input-text" type="text" placeholder="Tipo de Turismo" name="turismo" value="<?php echo $turismo?>"/>
                </div>
                <div class="campo">
                  <label>Nombre</label>
                  <input id="nombre" class="input-text" type="text" placeholder="Nombre" name="nombre" value="<?php echo $nombre?>" />
                </div>
              </div>
              <div class="botones-formulario">
                <a class="boton-primario" href="/mojisweb/miscelanea.php">Limpiar</a>
                <button class="boton-primario" type="submit">Buscar</button>
              </div>
            </fieldset>    
          </form>
        </div>
        <br>
        <br>
        <h1 class=resultado-header>Lugares de interés turístico</h1>
        <div class="resultados">
            <?php if(isset($resultadoLugares)){ 
                    while($row = mysqli_fetch_assoc($resultadoLugares)): ?>
                      <div class="resultado">
                      <img src="build/img/<?php echo $row['imagen']; ?>" alt="imagen sitio" />
                      <p><?php echo $row['sitio']; ?></p>
                      <p class="descripcion"><?php echo $row['descripcion']; ?></p>
                      </div>
            <?php   endwhile; ?>
            <?php   } else {
                  while($row = mysqli_fetch_assoc($resultado)): ?>
                    <div class="resultado">
                      <img src="build/img/<?php echo $row['imagen']; ?>" alt="imagen sitio" />
                      <p><?php echo $row['sitio']; ?></p>
                      <p class="descripcion"><?php echo $row['descripcion']; ?></p>
                    </div>
            <?php endwhile; ?>
            <?php }   ?>
        </div>
          
        <div class="mensaje-error">
        </div>
    </main>
    <footer class="footer">
      <p>Todos los derechos reservados. Carlos Mojica - Desarrollador Web Freelancer - ©2022.</p>
    </footer>
    <!-- <script src='buscador.js'></script> -->
    <!-- <script src='base.js'></script> -->
    <script src="build/js/bundle.min.js"></script>
    <?php
    mysqli_close($bd);
    ?>
  </body>
</html>