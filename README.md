Proyecto JagHours

Por si no saben como hacerlo y cosas que deben agregar
-Git
En algun otro lado de su preferencia hacen una carpeta y hacen clone -> git clone "link ssh o http"
Se les va a crear una carpeta "Proyecto-Jaghours" y dentro "jaghours" 
(su repositorio para hacer push y eso lo van a hacer DENTRO DE "Proyecto-Jaghours", 
osea que van a tener el .git y la carpeta "jaghours" juntos)

Deben mover esa carpeta "jaghours" dentro de laragon->www
Cuando hagan su parte van a mover esa carpeta de vuelta donde estaba al inicio y ahi hacen el push

-Vamos a trabajar con branchs
git branch "su nombre"
git checkout "su nombre"
CUANDO HAGAN CHECKOUT REVISEN QUE SE MOVIERON A SU RAMA
git add .
git commit -m "mensaje"
git push -u origin "su nombre"

-Ya en VS en la terminal
composer install
Para que instale todas las dependencias

copy .envexample .env
Para que se les cree el .env y en el punto env modificar app name con "jaghours" y db con "dbjaghours"

php artisan key:generate 
Revisar si se les puso app key en .env, sino no les va a servir en la web

php artisan migrate
Para que se cree su base y tablas

-Y a sobrevivir pues-


