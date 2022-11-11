<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopPeliculas</title>  
</head>
<body>
    <?php

    require('Pelicula.php');

    class TopPeliculas
    {
        private $peliculaArray=[];

        public function __construct()
        {

        }

        public function anadirPelicula($pelicula)
        {
            if (($pelicula->getNombre() == "") && ($pelicula->getID() == "")) 
            {
                //Advertencia si nombre y isan estan vacios
                echo 'Los campos nombre y isan estan vacios<br>';
                unset($this->peliculaArray[null]);
            }
            else
            {
                foreach ($this->peliculaArray as $key => $value)
                {
                    if($key==$pelicula->getID())
                    {
                        if($pelicula->getNombre() == "")
                        {
                            //Si el user introduce un número ISAN y no deja el nombre de la película vacío, la película se eliminará de la lista
                            unset($this->peliculaArray[$pelicula->getID()]);
                        }
                        if($pelicula->getNombre() != "" && $pelicula->getAño() != "" && $pelicula->getPuntuacion())
                        {
                            //Si el número ISAN que se introdujo YA existe en la lista y el resto de apartados no están vacíos se actualizará con la información introducida en el formulario
                            $value->setNombre($pelicula->getNombre());
                            $value->getAño($pelicula->getAño());
                            $value->getPuntuacion($pelicula->getPuntuacion());
                        }
                    }
                    else
                    {
                        //Caso 3
                        if(($pelicula->getNombre() != "") && ($pelicula->getID() == ""))
                        {
                            //Si sólo el ISAN está vacío mostrará la lista de películas que contienen ese nombre
                            if(str_contains($value->getNombre(),$pelicula->getNombre()))
                            {
                                echo $value->getNombre()." Año: ".$value->getAño()." Puntuacion: ".$value->getPuntuacion(). "<br>";
                                unset($this->peliculaArray[null]);
                            }
                        }
                        else
                        {
                            $this->peliculaArray[$pelicula->getID()]=$pelicula;
                        }
                    }
                } 
            }
        }

    //metodo para convertir el Array en String
    public function arrayToString()
    {
        $string="";
        foreach ($this->peliculaArray as $key => $value)
        {
            if($value->getID()!=" " && $value->getNombre()!=" " && $value->getPuntuacion()!=" " && $value->getAño()!=1)
            {
                $string .= $value->getID().",".$value->getNombre().",".$value->getPuntuacion().",".$value->getAño()."/";
            }
        }
        return $string;
    }

    //metodo para convertir el String en Array
    public function stringToArray($texto)
    {
        $array=explode("/",$texto);
        for ($i=0; $i < count($array); $i++) 
        { 
            $array_peli=explode(",",$array[$i]);
            if($array[$i]!="" || $texto="")
            {
                $peli=new Pelicula($array_peli[0],$array_peli[1],$array_peli[2],$array_peli[3]);
                $this->peliculaArray[$array_peli[0]]=$peli;
            }
        }
    }

    //metodo para mostrar los datos
    public function mostrarDatos()
    {
        $datos="";
        foreach($this->peliculaArray as $key => $value)
        {
            $datos.="Nombre: ".$value->getNombre()." ISAN: ".$value->getID()." Puntuacion: ".$value->getPuntuacion()." Año: ".$value->getAño()."<br>";
        }
        return $datos;
    }
}
?>



<pre>
    <?php

        //Concatenar peliculas
            $concatenado = new TopPeliculas();
            if (isset($_POST['concatenado'])) 
            {
                $concatenado->stringToArray($_POST['concatenado']."/".$_POST['id'].",".$_POST['nombre'].",".$_POST['combo'].",".$_POST['año']."/");
            }

        //comprobacion de nombre de user
            $user;
            if(isset($_POST["user"]))
            {
                $user= ($_POST["user"]);
            }
            else
            {
                $_POST["user"]="";
            }
    ?>
</pre>



<h1>Usuario: <?php { echo $_POST["user"] ; } ?></h1>


<form action="TopPeliculas.php" method="post">
        <p>Nombre de la pelicula: </p>
        <input type="text" id="nombre" name="nombre" value="<?php if(isset($_POST['nombre'])){echo $_POST['nombre'];}else{echo "";} ?>">
        <p>ISAN: </p>
        <input type="text" id="id" name="id" value="<?php if(isset($_POST['id'])){echo $_POST['id'];}else{echo "";} ?>">
        <br>
        <p>Año:</p>
        <input type="text" id="año" name="año" value="<?php if(isset($_POST['año'])){echo $_POST['año'];}else{echo "";} ?>">
        <br><br>
        <p>Puntuacion:</p>
        <select name="combo">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <br><br><br>
        <button type="submit">Añadir</button><br><br>

        <pre><?php echo "<input type='hidden' name='user' value='".$_POST["user"]."' >" ?></pre>


        <?php

        if(isset($_POST["id"]) && isset($_POST["nombre"]) && isset($_POST["año"]) && isset($_POST["combo"])){
            $peli=new Pelicula(htmlentities($_POST['id']),htmlentities($_POST['nombre']),htmlentities($_POST['combo']),htmlentities($_POST['año']));

            //concateno las peliculas
            $concatenado->anadirPelicula($peli);

            //muestro los datos
            echo $concatenado->mostrarDatos();
        }

        ?>

        <pre><?php echo "<input type='hidden' name='concatenado' value='".$concatenado->arrayToString()."' >" ?></pre>
    </form>
</body>
</html>
