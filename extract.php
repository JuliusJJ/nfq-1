<?php
if(!isset($_GET['page']))
{
    header("Location: duomenys.php?page=1");
}

    require 'connect.php';
    error_reporting(0);
    
    $per_page = 15;

    $desc = "DESC";

    $date_cur = date('Y-m-d', strtotime('+1 day', strtotime(date("Y-m-d"))));
    $date_nuo = date('Y-m-d', strtotime('-7 day', strtotime($date_cur)));

    $sql_cur = 'SELECT * FROM sys.uzsakymai WHERE dat >="' . $date_nuo . '"' . ' AND dat <="' . $date_cur . '"';  //default istraukiami 1 savaites duomenys
    if($result = $conn->query($sql_cur))
    {
        if($count = $result->num_rows)
        {
        }
        else die("Nera duomenu");

        
        $pages = ceil($count / $per_page);  //total pages

        if(isset($_POST['nuo'])) header("Location: duomenys.php?page=1&nuo=" . $_POST['nuo'] . "&iki=" . $_POST['iki'] . "&byid=" . $_POST['byid']);  //perduodu datas i url, nes taip galiu issaugoti jas kaskart atidarydamas nauja psl. su paging


        if(isset($_GET['nuo']))  //JEIGU PASIRINKTA DATA
        {

                $nuo = $_GET['nuo'];
                $iki = $_GET['iki'];
                $byid = $_GET['byid'];

                if($_GET['orderby']!="")
                {
                    $order = $_GET['orderby'];
                    if($byid == "") {  //jei nėra ID , o stulpelis rikiuojamas
                        if($_GET['pagal']=="DESC")
                        {
                            $sql = 'SELECT * FROM sys.uzsakymai WHERE dat >="' . $nuo . '"' . ' AND dat <="' . date('Y-m-d', strtotime('+1 day', strtotime($iki))) . '" ORDER BY ' . $order . ' DESC';
                            $desc = "ASC";
                        }
                        else 
                        {
                            $sql = 'SELECT * FROM sys.uzsakymai WHERE dat >="' . $nuo . '"' . ' AND dat <="' . date('Y-m-d', strtotime('+1 day', strtotime($iki))) . '" ORDER BY ' . $order . ' ASC';
                            $desc = "DESC";
                        }
                    }//jei yra id, ieskoma nustatytoje datoje
                    else $sql = 'SELECT * FROM sys.uzsakymai WHERE iduzsakymai = ' . $byid . ' AND dat >="' . $nuo . '"' . ' AND dat <="' . date('Y-m-d', strtotime('+1 day', strtotime($iki))) . '"';
                }
                else{
                    if($byid == "") //jei nera id
                    $sql = 'SELECT * FROM sys.uzsakymai WHERE dat >="' . $nuo . '"' . ' AND dat <="' . date('Y-m-d', strtotime('+1 day', strtotime($iki))) . '"';
                    else //jei yra id, ieskoma datoje
                    $sql = 'SELECT * FROM sys.uzsakymai WHERE iduzsakymai = ' . $byid . ' AND dat >="' . $nuo . '"' . ' AND dat <="' . date('Y-m-d', strtotime('+1 day', strtotime($iki))) . '"';
                }

           

            if($resul = $conn->query($sql . ' LIMIT ' . ($_GET['page']-1)*$per_page . ',' . $per_page))
            {
                if($count = $resul->num_rows)
        {
            $pages = ceil($conn->query($sql)->num_rows / $per_page);
                
                echo '
        <table>
        <tr class="tarpai">
            <th><img src="images/arrow.png" height="20" width="20"><a class="order" href="duomenys.php?page=1&nuo=' . $_GET['nuo'] . '&iki=' . $_GET['iki'] . '&orderby=iduzsakymai&pagal=' . $desc . '">ID</a></th>
            <th><img src="images/arrow.png" height="20" width="20"><a class="order" href="duomenys.php?page=1&nuo=' . $_GET['nuo'] . '&iki=' . $_GET['iki'] . '&orderby=vardas&pagal=' . $desc . '">Vardas</a></th>
            <th><img src="images/arrow.png" height="20" width="20"><a class="order" href="duomenys.php?page=1&nuo=' . $_GET['nuo'] . '&iki=' . $_GET['iki'] . '&orderby=pavarde&pagal=' . $desc . '">Pavardė</a></th>
            <th>Tipas</th>
            <th>Kiekis</th>
            <th><img src="images/arrow.png" height="20" width="20"><a class="order" href="duomenys.php?page=1&nuo=' . $_GET['nuo'] . '&iki=' . $_GET['iki'] . '&orderby=kaina&pagal=' . $desc . '">Kaina</a></th>
            <th><img src="images/arrow.png" height="20" width="20"><a class="order" href="duomenys.php?page=1&nuo=' . $_GET['nuo'] . '&iki=' . $_GET['iki'] . '&orderby=dat&pagal=' . $desc . '">Data</a></th>
        </tr>
        ';

        $i=0;
            while($rows = $resul->fetch_array(MYSQLI_ASSOC))
            {
                
                $i++;
                if($i % 2 ==0)
                {
                    echo "<tr>
                    <td class='paint'>" . $rows['iduzsakymai'] . "</td> 
                    <td class='paint'>" . $rows['vardas'] . "</td> 
                    <td class='paint'>" . $rows['pavarde'] . "</td> 
                    <td class='paint'>" . $rows['tipas'] . "</td> 
                    <td class='paint'>" . $rows['kiekis'] . "</td> 
                    <td class='paint'>" . $rows['kaina'] . "</td>
                    <td class='paint'>" . $rows['dat'] . "</td>
                    </tr>";
                }
                else
                {
                    echo "<tr>
                    <td>" . $rows['iduzsakymai'] . "</td> 
                    <td>" . $rows['vardas'] . "</td> 
                    <td>" . $rows['pavarde'] . "</td> 
                    <td>" . $rows['tipas'] . "</td> 
                    <td>" . $rows['kiekis'] . "</td> 
                    <td>" . $rows['kaina'] . "</td>
                    <td>" . $rows['dat'] . "</td>
                    </tr>";
                }
            }
            
            echo '</table>';
            
        }
        else echo "<script type='text/javascript'>alert('Nėra duomenų nustatytu paieška');</script>";
        
            }
            else die($conn->error);

        }
        else  //JEI NEPASIRINKTA, DEFAULT ISTRAUKIA SAVAITE
        {
            header("Location: duomenys.php?page=1&nuo=" . $date_nuo . "&iki=" . $date_cur);
            
        }
    }
    else die($conn->error);
    

?>