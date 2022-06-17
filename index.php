<?php
require_once "Car.php";
$car = new Car();

if (isset($_POST["car"])) {
    $car->addCar($_POST["car"], $_POST["date_start"], $_POST["date_end"], $_POST["cost"]);
} elseif (isset($_POST["carUpd"])) {
    $car->updateRace($_POST["carUpd"], $_POST["race"]);
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vlad</title>
</head>
<body>
<form action="" method="post">
    <input type="datetime-local" name="date">
    <input type="submit" value="Поиск цены"><br>
</form>

<?php
if (isset($_POST["date"])) {
    $car->cost($_POST["date"]);
}
?>

<form action="" method="post">
    <select name="vendor">
        <?php
        $car->vendors();
        ?>
    </select>
    <input type="submit" value="Поиск по производителю"><br>
</form>

<?php
if (isset($_POST["vendor"])) {
    $car->car($_POST["vendor"]);
}
?>

<form action="" method="post">
    <input type="date" name="free_car">
    <input type="submit" value="Поиск свободных машин"><br>
</form>

<?php
if (isset($_POST["free_car"])) {
    $car->freeCar($_POST["free_car"]);
}
?>

<form action="" method="post">
    <select name="car">
        <?php
        $car->cars();
        ?>
    </select>
    <input type="date" name="date_start">
    <input type="date" name="date_end">
    <input type="number" name="cost">
    <input type="submit" value="Добавить"><br>
</form>

<form action="" method="post">
    <select name="carUpd">
        <?php
        $car->cars();
        ?>
    </select>
    <input type="number" name="race">
    <input type="submit" value="Добавить"><br>
</form>
</body>
</html>

