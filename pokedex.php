<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DWES 09</title>
</head>

<body>
  <form action="pokedex.php" method="GET">
    <input type="text" name="texto" id="texto" placeholder="nombre de un pokémon" autocomplete="off" />
    <button type="submit" id="boton">Buscar</button>

    <?php
    $pokemon = "";
    if (isset($_GET['texto'])) {
      $pokemon = strtolower($_GET['texto']);

      if ($datos = @file_get_contents("https://pokeapi.co/api/v2/pokemon/{$pokemon}")) {


        $coleccion = json_decode($datos, true);

        echo "<br><br>Nombre: " . ucfirst($coleccion['name']) . "<br>";

        echo "<br>Habilidades: ";
        foreach ($coleccion['abilities'] as $dato) {
          echo $dato['ability']['name'] . " / ";
        }

        echo "<br><br> Tipo: {$coleccion['types'][0]['type']['name']} <br>";

        $peso = $coleccion['weight'] / 10;
        echo "<br>Peso: {$peso} kg.<br>";

        $altura = $coleccion['height'] * 10;
        echo "<br>Altura: {$altura} cm. <br>";


        $pokemonarray = file_get_contents("https://www.googleapis.com/customsearch/v1?key=AIzaSyDSij1BeOsxdL4QSOWrFp6zQ4qVqHWkthc&cx=72f1ef3dff68e4885&q=pokemon%20{$pokemon}");

        $coleccionpoke = json_decode($pokemonarray, true);

        echo '<br><img src="' . $coleccionpoke["items"][1]["pagemap"]["cse_thumbnail"][0]["src"] . '">';
      } else {
        echo "<br> Sin resultados.";
      }
    }

    ?>

  </form>
</body>

</html>