<?php

if(!isset($_GET['menu']))
{
    $menu=1;
}else
{
    $menu=$_GET['menu'];
}

switch( $menu )
{
    case 1:
        News();
        break;
    case 2:
        AboutUs();
        break;
    case 3:
        Contact();
        break;
    case 4:
        Stuff();
        break;
}


function News()
{
    echo '<div class="col-xs-3 col-xs-offset-4">';
        echo '<h3>Aktualności</h3>';
    echo '</div>';
    echo '<div class="col-xs-10 col-xs-offset-1">';
        echo '<p>';
            echo 'Program Profilaktyki Chorób Układu Krążenia"<br>';
            echo 'Zapraszamy wszystkich Pacjentów do skorzystania z bezpłatnego badania profilaktycznego w ramach
                  Programu Profilaktyki Chorób Układu Krążenia.
                  Szczegółowe informacje na temat badań udzielane są przez naszych lekarzy lub w można je uzyskać rejestracji Naszej Przychodni.';
        echo '</p>';
        echo '<p>';
            echo 'NOCNA I ŚWIĄTECZNA POMOC LEKARSKA<br>';
            echo 'Nocna i Świąteczna Pomoc Lekarska mieści się w<br>
 
                    Nowodworskim Centrum Medycznym<br>
                    ul. Miodowa 2<br>
                    tel:(22)7658322,  (22)7753081, wew. 234, 237, 343<br>
                    tel. kom. 516150267';
        echo '</p>';
    echo '</div>';

}

function AboutUs()
{
    echo '<div class="col-xs-3 col-xs-offset-4">';
        echo '<h3>O nas</h3>';
    echo '</div>';
    echo '<div class="col-xs-10 col-xs-offset-1">';
        echo '<p>';
            echo 'Niepubliczny Zakład Opieki Zdrowotnej<br> "Patmed" powstał z marzeń dwóch lekarzy:
                Alicji Rydlińskiej i Piotra Uliasza.<br><hr>Była to idea o profesjonalnej opiece medycznej od noworodka do wieku złotego.
                Działalność leczniczą rozpoczęliśmy 1 sierpnia 2006 roku.
                Nasi pacjenci mogą korzystać zarówno z bezpłatnej opieki medycznej, w ramach umowy z Narodowym Funduszem 
                Zdrowia jaki i komercyjnych usług medycznych w ramach POZ i AOS.';
        echo '</p>';
        echo '<p>';
            echo 'W "Patmedzie" czekają na Państwa:<br>';
            echo '<ul>';
            echo '<li>pediatra</li>';
            echo '<li>internista</li>';
            echo '<li>pielęgniarka środowiskowo-rodzinna</li>';
            echo '<li>położna środowiskowo-rodzinna</li>';
            echo '<li>psycholog</li>';
            echo '<li>kardiolog</li>';
            echo '<li>diabetolog</li>';
            echo '<li>alergolog</li>';
            echo '<li>terapeuta leczenia uzależnień</li>';
            echo '</ul>';
        echo '</p>';
    echo '</div>';
}

function DisplayDoctor($pesel)
{
    $doctor = new Lekarz();
    $doctor->LoadFromDatabase($pesel);
    if($doctor->Pesel()=="")
    {
        echo "<h4><center>Lekarz o podanym numerze pesel nie istnieje w bazie</center></h4><hr>";
        return;
    }
    echo '<div class="col-xs-12">';
        echo '<div class="row">';
            echo '<div class="col-xs-2 top5">';
                echo '<img src="img/avatar.png" class="img-circle" width="50">';
            echo '</div>';
            echo '<div class="col-xs-2">';
                echo 'Lek:<br>';
                echo $doctor->Imie().'<br>';
                echo $doctor->Nazwisko();
            echo '</div>';
            echo '<div class="col-xs-2">';
                echo 'Specjalizacja:<br>';
                echo $doctor->Specjalizacja().'<br>';
                echo '</div>';
                echo '<div class="col-xs-2 col-xs-offset-1">';
                echo 'Pesel:<br>';
                echo $doctor->Pesel().'<br>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
}

function Stuff()
{
    echo "<h4><center>Personel</center></h4><hr>";
    $conection = new Connection();
    $doctor_result=$conection->Set("SELECT Pesel FROM lekarz");
    while($row=$doctor_result->fetch_assoc())
    {
        DisplayDoctor($row['Pesel']);
    }
}
function Contact()
{
    echo '<div class="col-xs-3 col-xs-offset-4">';
        echo '<h3>Kontakt</h3>';
    echo '</div>';
    echo '<div class="col-xs-10 col-xs-offset-1">';
        echo '<p>';
            echo 'Lokalizacja<br>';
            echo 'Osiedle Gen. J. Bema:
                83-110 Olsztyn, ul. 30 Stycznia 55';
        echo '</p>';
        echo '<p>';
            echo '  Przydatne telefony<br>
                    Rejestracja do poradni ogólnej: tel. (58) 530 30 77<br>
                    Rejestracja do poradni specjalistycznych: tel. (58) 530 30 78<br>
                    Rejestracja do poradni ginekologiczno-położniczej: tel. (58) 530 30 75<br>
                    Rejestracja do poradni rehabilitacyjnej: tel. (58) 530 30 76<br>
                    Medycyna pracy: tel. (58) 530 30 79<br>
                    Biuro: tel./fax (58) 530 30 73	';
        echo '</p>';
}
?>