<?php
class GestionLibros
{
    /**
     * Establece una conexion con la base de datos. Es usado como metodo auxiliar de 
     * los demas metodos de la clase
     * @return object Devuelve el objeto de la conexion.
     */
    private function conexion()
    {
        $objetoConexion = new mysqli('localhost', 'outu', 'outu', 'libros');

        if ($objetoConexion->connect_error) {
            return null;
        } else {
            return $objetoConexion;
        }
    }

    /**
     * Hace una consulta a la base de datos e imprime en pantalla el nombre de los autores
     * que coincidan con los parametros dados, e imprime tambien cada uno de sus libros
     * @param string $letras Conjunto de caracteres que deben coincidir con el nombre
     * o apellido de algun autor
     */
    public function consultarAutores($letras)
    {
        $conexion = $this->conexion();

        $consultaAutor = "SELECT * FROM autor WHERE nombre LIKE '%{$letras}%' or apellidos LIKE '%{$letras}%'";

        $resultado = $conexion->query($consultaAutor);

        if ($resultado->num_rows > 0) {
            $arrayAutores = $resultado->fetch_all($resulttype = MYSQLI_ASSOC);

            foreach ($arrayAutores as $i) {
                $consultaLibros = "SELECT * FROM libro WHERE id_autor = {$i["id"]}";
                $resultado = $conexion->query($consultaLibros);
                $arrayLibros = $resultado->fetch_all($resulttype = MYSQLI_ASSOC);

                echo "Nombre: {$i["nombre"]} {$i["apellidos"]}<br>
                Libros: <ul>";
                foreach ($arrayLibros as $x) {
                    echo "<li>{$x["titulo"]}</li>";
                }
                echo "</ul>";
            }
        } else {
            echo "Ningún resultado";
        }
    }
}

if (isset($_GET['texto'])) {
    if ($_GET['texto'] == "") {
        echo "Ningún resultado";
    } else {
        $bd = new GestionLibros;
        $bd->consultarAutores($_GET['texto']);
    }
}
