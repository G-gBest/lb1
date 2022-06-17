<?php

class Car
{
    private PDO $db;

    public function __construct()
    {
        $this->db = new PDO("mysql:host=127.0.0.1;dbname=car", "root", "");
    }

    public function vendors(): void
    {
        $statement = $this->db->query("SELECT DISTINCT * FROM vendors");
        while ($data = $statement->fetch()) {
            echo "<option value='$data[0]'>$data[1]</option>";
        }
    }

    public function cars(): void
    {
        $statement = $this->db->query("SELECT DISTINCT ID_Cars, name FROM cars");
        while ($data = $statement->fetch()) {
            echo "<option value='$data[0]'>$data[1]</option>";
        }
    }

    public function cost(string $date): void
    {
        $statement = $this->db->prepare("SELECT name, date_start, time_start, cost FROM cars INNER JOIN rent ON ID_Cars=FID_Car WHERE ? BETWEEN date_start and date_end");
        $statement->execute([$date]);
        echo "<table style='text-align: center'>";
        echo " <tr>
         <th> Марка  </th>
         <th> Цена </th>
        </tr> ";
        while ($data = $statement->fetch()) {
            $cost = (strtotime($date) - strtotime($data["date_start"]."T".$data["time_start"]))/3600*$data["cost"];
            echo " <tr>
             <td> {$data['name']}  </td>
             <td> {$cost} </td>
            </tr> ";
        }
        echo "</table>";
    }

    public function car(string $vendor): void
    {
        $statement = $this->db->prepare("SELECT name, release_date, race FROM cars WHERE FID_Vendors=?");
        $statement->execute([$vendor]);
        echo "<table style='text-align: center'>";
        echo " <tr>
         <th> Марка  </th>
         <th> Дата выпуска </th>
         <th> Пробег </th>
        </tr> ";
        while ($data = $statement->fetch()) {
            echo " <tr>
             <td> {$data['name']}  </td>
             <td> {$data['release_date']} </td>
             <td> {$data['race']} </td>
            </tr> ";
        }
        echo "</table>";
    }

    public function freeCar(string $free_car): void
    {
        $statement = $this->db->prepare("SELECT name, release_date, race FROM cars INNER JOIN rent ON ID_Cars=FID_Car WHERE ? NOT BETWEEN date_start and date_end");
        $statement->execute([$free_car]);
        echo "<table style='text-align: center'>";
        echo " <tr>
         <th> Марка  </th>
         <th> Дата выпуска </th>
         <th> Пробег </th>
        </tr> ";
        while ($data = $statement->fetch()) {
            echo " <tr>
             <td> {$data['name']}  </td>
             <td> {$data['release_date']} </td>
             <td> {$data['race']} </td>
            </tr> ";
        }
        echo "</table>";
    }

    public function addCar(string $car, string $date_start, string $date_end, string $cost): void
    {
        $statement = $this->db->prepare("INSERT INTO rent (FID_Car, date_start, date_end, cost) VALUES (?, ?, ?, ?)");
        $statement->execute([$car, $date_start, $date_end, $cost]);
    }

    public function updateRace(string $car, string $race): void
    {
        $statement = $this->db->prepare("UPDATE cars SET race = ? WHERE ID_Cars = ?");
        $statement->execute([$race, $car]);
    }
}