<?php
// Ver el ejemplo de password_hash() para ver de dónde viene este hash.
$hash = '$2y$12$RwHw3lOW6n4HK5VJfglApe8pU4Nza7AwPfaLbmouClZzClUGR9J7u';



if (password_verify('24660071','$2y$10$mqZfMIdncBRfA/opvbdQB.lw3bzYeAsONvvm.WAx1zQJtP628fFcC')) {
    echo 'La contraseña es válida!';
} else {
    echo 'La contraseña no es válida.';
}

// Establece la contraseña
$password = '24660071';

// Obtiene el hash, dejando que el salt sea generado be automáticamente
echo $hash = crypt($password);
?>