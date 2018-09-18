<!DOCTYPE html>


<head>
 <meta charset="UTF-8">
 <title>PHP Test</title>
 <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <section class="new">
        <div class="rikiavimas_l">
            <div class="sz">Paieška pagal data nuo:</div>
            <div class="sz">iki:</div>
            <br>
            <div class="sz">Paieška pagal ID:</div>
        </div>
        <form class="rikiavimas_r" action="" method = "POST">

            <?php
            echo '<input type="date" name="nuo" ';
            date_default_timezone_set('Europe/Vilnius');
            if(isset($_GET['nuo']))echo ' value=' . $_GET['nuo'];
            else echo ' value=' . date('Y-m-d', strtotime('-7 day', strtotime(date("Y-m-d"))));
            echo ' min= 2018-01-01';
            echo ' max= 2018-12-31';
            echo ' required/>';
            ?>


        
            <?php
            echo '<br><input type="date" name="iki" ';
            date_default_timezone_set('Europe/Vilnius');
            if(isset($_GET['iki']))echo ' value=' . $_GET['iki'];
            else echo 'value=' . date("Y-m-d");
            echo ' min= 2018-01-01';
            echo ' max= 2018-12-31';
            echo ' required/>';
            ?>
            
            <?php
            echo '<br><br><input type"text" class= "auk" name="byid" pattern="[0-9]+" title="Tik skaičiai"';
            if(isset($_GET['byid'])){
            if($_GET['byid'] != "") echo ' value = ' . $_GET['byid'] . '>';
            }
            else echo '>';
            ?>


        <br><input class="riki" type="submit" value="Atnaujinti">

    </form>

    </section>

    

    <div class="cntr">
    
            <?php
            

            require 'extract.php';  //duomenu istraukimas

            for($i =1; $i <= $pages;$i++) //paging nupiesimas
        {
                if($i==$_GET['page'])echo '<a class = "pag sl" href="duomenys.php?page=' . $i . '&nuo=' . $_GET['nuo'] . '&iki=' . $_GET['iki'] . '&orderby=' .$_GET['orderby'] . '&pagal=' . $_GET['pagal'] . '">' . $i . '</a>';
                else echo '<a class="pag" href="duomenys.php?page=' . $i . '&nuo=' . $_GET['nuo'] . '&iki=' . $_GET['iki'] . '&orderby=' .$_GET['orderby'] . '&pagal=' . $_GET['pagal'] . '">' . $i . '</a>';
            }
            ?>
    </div>
</body>
</html>