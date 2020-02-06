<?php

class Student
{
    // static = de classe
    private static $studentsNumber = 0;
    // propriété d'objet
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
        // Ajoutons 1 à chaque fois qu'on crée un étudiant
        self::$studentsNumber++;
    }

    public function sayHello()
    {
        echo 'Je m\'appelle '.$this->name.'<br>';
    }

    public static function getStudentsNumber()
    {
        return self::$studentsNumber;
    }
}

$marie = new Student('Marie');
$marie->sayHello();

$francois = new Student('François');
$francois->sayHello();

echo 'Le nombre d\'étudiant est '.Student::getStudentsNumber();