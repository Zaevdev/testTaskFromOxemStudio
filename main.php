<?php

class Farm
{
    // Массив с животными
    public $animals = [];

    // Массив с продукцией
    public $products = [];

    // Массив с общим количеством продукции
    public $products_all = [];

    // Добавляем животных массивом
    public function createAnimals(array $animals)
    {
        foreach ($animals as $type => $value) {
            $animalType = $type;
            $animalCount = $value;
            for ($i = 1; $i <= $animalCount; $i++) {
                $this->animals["$animalType"][] = new $animalType();
                if (!isset($this->products_all["$animalType"])) {
                    $this->products_all["$animalType"] = 0;
                }
            }
        }
    }

    // Собираем всю продукцию с животных за кол-во дней ($days)
    public function collectionProducts($days)
    {
        foreach ($this->animals as $key => $value) {
            $product = 0;
            for ($i = 1; $i <= $days; $i++) {
                foreach ($value as $animal) {
                    $product += $animal->getProducts();
                }
                $this->products["$key"] = $product;
            }
            $this->products_all["$key"] += $product;
        }
    }
}

// Класс хлева
class Barn extends Farm
{
    // Вывод данных о собранной продукции в консоль
    public function printProduct()
    {
        foreach ($this->products as $key => $value) {
            echo 'Собрано продукции от ' . $key . ' : ' . $value . PHP_EOL;
        }
    }

    // Вывод данных о собранной продукции в консоль
    public function printProductAll()
    {
        foreach ($this->products_all as $key => $value) {
            echo 'За всё время собрано продукции от ' . $key . ' : ' . $value . PHP_EOL;
        }
    }

    // Вывод данных о количестве животных в хлеву в консоль
    public function printAnimalsType()
    {
        foreach ($this->animals as $key => $value) {
            echo 'Количество ' . $key . ' : ' . count($this->animals["$key"]) . PHP_EOL;
        }
    }
}

// Класс животных
abstract class Animal
{
    // Уникальный номер животного и счётчик
    static $id = 1;
    public $animalId = 0;

    public function __construct()
    {
        // Задаем уникальный номер
        $this->animalId = self::$id++;
    }

    // Вовращает количество полученной продукции
    abstract public function getProducts();

}

// Класс коров
class Cow extends Animal
{
    // Получаем случайное количество продукции
    public function getProducts()
    {
        return rand(8, 12);
    }
}

// Класс куриц
class Chicken extends Animal
{
    // Получаем случайное количество продукции
    public function getProducts()
    {
        return rand(0, 1);
    }
}

$factory = new Barn();
$factory->createAnimals(['Cow' => 10, 'Chicken' => 20]); // Система должна добавить животных в хлев (10 коров и 20 кур).
$factory->printAnimalsType(); // Вывести на экран информацию о количестве каждого типа животных на ферме.
$factory->collectionProducts(7); // 7 раз (неделю) произвести сбор продукции (подоить коров и собрать яйца у кур).
$factory->printProduct(); // Вывести на экран общее кол-во собранных за неделю шт. яиц и литров молока.
$factory->createAnimals(['Cow' => 1, 'Chicken' => 5]); // Добавить на ферму ещё 5 кур и 1 корову (съездили на рынок, купили животных).
$factory->printAnimalsType(); // Снова вывести информацию о количестве каждого типа животных на ферме.
$factory->collectionProducts(7); // Снова 7 раз (неделю) производим сбор продукции
$factory->printProduct(); // и выводим результат на экран.
$factory->printProductAll(); // и выводим общий результат на экран.

