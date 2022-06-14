<?php

require 'app.php';


function incluirTemplates($nombre){
   include  TEMPLATES__URL .  "/{$nombre}.php";
}