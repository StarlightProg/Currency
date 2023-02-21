<?php
    namespace App\Classes;

    use App\Database;
    use App\View;

    class Profile{
        public function index():string{
            return View::make('profile')->render();
        }

        public static function get_currencies(){ //выводит данные о курсе валют
            $db = Database::db();

            $sql ="SELECT * FROM currencies;";
            $stmt = mysqli_stmt_init($db);
            mysqli_stmt_prepare($stmt,$sql);
                
            mysqli_stmt_execute($stmt);

            $resultData = mysqli_stmt_get_result($stmt);
            echo "<table>";
            echo "<tr>
                    <td>Валюта</td>
                    <td>Единиц</td>
                    <td>Курс".(empty($_GET["convert"]) ? "(в рублях)" : "(в данной валюте)")."</td>
                  </tr>";
            while($row = mysqli_fetch_row($resultData)){
                    echo "<tr>
                        <td>{$row[0]}</td>
                        <td>{$row[1]}</td>
                        <td>".(empty($_GET["convert"]) ? $row[2] : $row[1]/$row[2]) ."</td>
                    </tr>";
            }
            echo "</table>";
    
            mysqli_stmt_close($stmt);
        }
    }