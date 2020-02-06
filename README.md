# Isolation de notre framework en E09 !

[=> Voir les notes de Fanny](https://github.com/O-clock-Titan/notes-S06-Fanny42/blob/master/S06-E09.md) :) merci à elle :kissing_heart: :pray: !


# Backend :heart_eyes:

Ce qui est bien avec l'architecture de notre code produit en saison 5, c'est qu'on a presque tout codé avec des objets.  
On peut assez facilement réutiliser ce code dans d'autres projets.

On est des fainéants (enfin j'espère) donc va se baser sur ce code :wink:

## Etapes

La structure des répertoires a peut-être un peu changé par rapport à la saison 5.  
Ce n'est pas grave, au contraire, cela correspond aux structures MVC les plus utilisées.  
Les fichiers `.gitkeep` ne servent qu'à versionner les dossiers dans lesquelles ils se trouvent (_Git_ ne versionne que les fichiers, pas les dossiers)

### #1 FrontController :gun:

- le seul répertoire accédé par le navigateur est le répertoire `public`
- et notre fichier _FrontController_ est `public/index.php`
- placer un fichier `.htaccess` dans `public` pour qu'il renvoit toutes les requêtes HTTP vers le fichier _FrontController_
- on ne veut pas que le répertoire `app` soit accessible aux internautes
  - créer un fichier `.htaccess` dans le dossier `app`
  - coller ce code dans le fichier créé : `Deny from all`

### #2 Composer & AltoRouter :musical_keyboard:

- initialiser _Composer_ dans ce projet (`composer init`)
- installer _AltoRouter_ via _Composer_ (`composer require author/dependency`)
- on peut en profiter pour installer _var-dumper_

### #3 .gitignore :see_no_evil:

- ce fichier permet de définir les fichiers que _Git_ doit ignorer
  - par exemple notre fichier de configuration spécifique à chaque machine et contenant des infos sensibles
  - ou bien le répertoire `vendor` généré et rempli par _Composer_

### #4 CoreModel :dancers:

- classe "mère" de chaque classe _Model_
- permet de regrouper méthodes et propriétés utiles pour tous les _Models_
- coder la classe dans le dossier `app/Models`

### #5 CoreController :older_woman:

- classe "mère" de chaque classe _Controller_
- permet de regrouper méthodes et propriétés utiles pour tous les _Controllers_
- coder la classe dans le dossier `app/Controllers`

### #6 API = JSON :ear:

- le backend va afficher des données encodées en JSON
- donc la méthode `show` qui permettait d'afficher du code HTML sera peu utile
- on va se créer une méthode `showJson()` :
  - dans quelle classe on place cette méthode pour qu'elle soit disponible à tous les _Controllers_ ? :smiling_imp:
  - premier paramètre `$data`, la donnée à convertir et afficher
  - envoyer les entêtes HTTP permettant de définir le type `JSON`
  - envoyer les entêtes HTTP autorisant les accès depuis n'importe quel domaine (_CORS_)

<details><summary>Code de la méthode showJson()</summary>

```php
<?php

// ...

/**
* Méthode permettant d'afficher/retourner un JSON à l'appel Ajax effectué
*
* @param mixed $data
*/
protected function showJson($data)
{
    // Autorise l'accès à la ressource depuis n'importe quel autre domaine
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    // Dit au navigateur que la réponse est au format JSON
    header('Content-Type: application/json');
    // La réponse en JSON est affichée
    echo json_encode($data);
}

// ...

```

</details>

### #7 DBData :floppy_disk:

- en fait non, cette fois, on va voir une autre façon de regrouper les requêtes à la base de données
- pour les plus curieux : https://www.culttt.com/2014/06/18/whats-difference-active-record-data-mapper/
- pour les moins curieux : on verra ça en cours :wink:

### #8 Fichier de config :bow:

- créer le fichier
- placer les données nécessaires à la connexion à la base de données
- créer la version "dist"

### #9 Inclure les classes :loudspeaker:

- dans le _FrontController_
- inclure les classes utiles, dans le bon ordre :wink:
- ne pas oublier _Composer_ :wink:

### #10 Classe Application

- déclare les routes
- dispatch chaque requête HTTP vers la bonne méthode du bon controleur (méthode `run`)

:raised_hand: **Halte** !  
On s'arrête là. La suite, c'est à faire en autonomie après le cours :tada:

### #11 404

- gérer correctement les 404
- créer et utiliser un _Controller_ `ErrorController`

### #12 Views

- créer les _views_ permettant d'afficher la page d'accueil et la page 404

### #13 :thinking:

- il reste des choses à faire ?
  - c'est possible en effet
  - on peut toujours améliorer notre code (amélioration continue = agilité :boom:)
  - alors faisons-le :tada:
