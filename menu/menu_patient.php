<?php

if(isset($_GET['error']))
{
    if($_GET['error']==1)
    {
        echo '<script>alert("Dodano pomyślnie !")</script>';
    }
    if($_GET['error']==2)
    {
        echo '<script>alert("Usunięto pomyślnie !")</script>';
    }
}

if(!isset($_GET['menu']))
{
    $menu=0;
}else
{
    $menu=$_GET['menu'];
}

switch( $menu )
{
    case 0:
        AboutMe();
        break;
    case 1:
        AddPatientInterview();
        break;
    case 2:
        DisplayPrescriptions();
        break;
    case 3:
        DisplayInterviews();
        break;
    case 4:
        DisplayCertificates();
        break;
    case 5:
        DisplayStatements();
        break;
}

function AboutMe()
{
    $patient=new Pacjent();
    $patient->LoadFromDatabase($_SESSION['id']);
    echo "<h4><center>O mnie</center></h4><hr>";
    echo '<div class="col-xs-12">';
        echo '<div class="col-xs-6">';
            echo 'Imię: '.$patient->Imie().'<br><hr>';
            echo 'Nazwisko: '.$patient->Nazwisko().'<br><hr>';
            echo 'Pesel: '.$patient->Pesel().'<br><hr>';
            echo 'Adres: '.$patient->Adres().'<br><hr>';
            echo 'Nip Pracodawcy: '.$patient->Pracodawca().'<br><hr>';
            echo 'Numer Ubezpieczenia: '.$patient->Ubezpieczenie().'<br><hr>';
        echo '</div>';
    echo '</div>';
}

function AddPatientInterview()
{
    echo 'w trakcie przygotowaniea';
}
function DisplayPrescriptions()
{
    $connection = new Connection();
    $prescription_result=$connection->Set("SELECT * FROM recepta WHERE PeselPacjenta=".$_SESSION['id']);
    echo "<h4><center>Karta pacjenta</center></h4><hr>";
    echo '<div class="col-xs-12">';
            echo '<h4>Moje recepty</h4>';
            if($prescription_result->num_rows==0)
                echo "<br>Aktualnie brak wystawionych recept";
            while ($prescription_row = $prescription_result->fetch_assoc())
            {
                echo '<div class="row">';
                    echo '<div class="col-xs-3">';
                        echo 'Data wystawienia:<br>';
                        echo $prescription_row['DataWystawienia'];
                    echo '</div>';
                    echo '<div class="col-xs-3 ">';
                        echo 'Data realizacji:<br>';
                        if($prescription_row['DataRealizacji']!="")
                        echo $prescription_row['DataRealizacji'];
                        else 'Nie zrealizowano';
                    echo '</div>';
                    echo '<div class="col-xs-6 ">';
                        echo 'Treść recepty:<br>';
                            echo $prescription_row['ReceptaTresc'];
                    echo '</div>';
                    $doctor=new Lekarz();
                    $doctor->LoadFromDatabase($prescription_row['PeselLekarza']);
                    echo '<div class="col-xs-3 col-xs-offset-9 top30">';
                        echo 'Wydana przez:<br>';
                        echo $doctor->Imie().'<br>'.$doctor->Nazwisko();
                    echo '</div>';
                echo '</div>';
            }
    echo '</div>';

}

function DisplayInterviews()
{
    $connection = new Connection();
    $interview_result=$connection->Set("SELECT * FROM wywiad WHERE PeselPacjenta=".$_SESSION['id']);
    echo '<div class="col-xs-12">';
        echo '<h4>Moje badania/wywiady</h4>';
        if($interview_result->num_rows==0)
            echo "<br>Aktualnie brak dodanych wywiadów";
        while ($interview_row = $interview_result->fetch_assoc()) {
            echo '<div class="row">';
                echo '<div class="col-xs-3">';
                    echo 'Data wystawienia:<br>';
                    echo $interview_row['DataWystawienia'];
                echo '</div>';
                echo '<div class="col-xs-3">';
                    echo 'Niezdolnośc do pracy od:<br>';
                    echo $interview_row['NiezdolnoscDoPracyOd'];
                echo '</div>';
                echo '<div class="col-xs-3">';
                    echo 'Niezdoloność do proacy do:<br>';
                    echo "- ".$interview_row['NiezdolnoscDoPracyDo'];
                echo '</div>';
                echo '<div class="col-xs-3">';
                    echo 'Czy Pierwsze zachorowanie:<br>';
                    if($interview_row['CzyPierwszeZachorowanie'])
                        echo 'Nie';
                    else
                        echo 'Tak';
                echo '</div>';
                echo '<div class="col-xs-12">';
                    echo 'Numer statyczny choroby:<br>';
                    echo $interview_row['NrStatycznyChoroby'];
                echo '</div>';
                echo '<div class="col-xs-12 top30">';
                    echo 'Treść wywiadu/badania:<br>';
                    echo $interview_row['TrescWywiadu'];
                echo '</div>';
            echo '</div>';
        }

    echo '</div>';
}
function DisplayCertificates()
{
    $connection = new Connection();
    $certificate_result=$connection->Set("SELECT * FROM zaswiadczenie WHERE PeselPacjenta=".$_SESSION['id']);
    echo '<div class="col-xs-12">';
        echo '<h4>Moje zaświadczenia</h4>';
        if($certificate_result->num_rows==0)
            echo "<br>Aktualnie brak dodanych zaświadczeń";
        while ($certificate_row = $certificate_result->fetch_assoc()) {
            echo '<div class="row">';
                echo '<div class="col-xs-3">';
                    echo '<span class="big-txt">Data wystawienia:</span><br>';
                    echo $certificate_row['Data'];
                echo '</div>';
                echo '<div class="col-xs-3">';
                    echo '<span class="big-txt">Cel wydania zaświadczenia:</span><br>';
                    echo $certificate_row['CelWydaniaZaswiadczenia'];
                echo '</div>';
                echo '<div class="col-xs-6">';
                    echo '<span class="big-txt">Data wystawienia:</span><br>';
                    echo $certificate_row['Data'];
                echo '</div>';
                $doctor = new Lekarz();
                $doctor->LoadFromDatabase($certificate_row['PeselLekarza']);
                echo '<div class="col-xs-3 col-xs-offset-9">';
                    echo '<span class="big-txt">Wydane przez:</span><br>';
                    echo $doctor->Imie()."<br>".$doctor->Nazwisko();
                echo '</div>';
            echo '</div>';
        }

    echo '</div>';
}

function DisplayStatements()
{
    echo "brak oświdaczeń do podpisania";
}

?>