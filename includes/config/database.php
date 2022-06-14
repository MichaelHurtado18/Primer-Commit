<?php

function conectarBD()
{
    $mysqli = new mysqli('localhost', 'root', 'HURMAR1218presidente', 'mydb');
    return $mysqli;
}
