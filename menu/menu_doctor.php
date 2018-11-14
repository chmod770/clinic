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
    if(isset($_GET['pesel']))
        $pesel=$_GET['pesel'];
}

switch( $menu )
{
    case 0:
        AboutMe();
        break;
    case 1:
        PatientInterview();
        break;
    case 2:
        AddCertificate();
        break;
    case 3:
        Addprescription();
        break;
    case 4:
        SelectPatient();
        break;
    case 5:
        DisplayPatientCard($pesel);
        break;
}


function AboutMe()
{
    $doctor=new Lekarz();
    $doctor->LoadFromDatabase($_SESSION['id']);
    echo "<h4><center>O mnie</center></h4><hr>";
    echo '<div class="col-xs-12">';
    echo '<div class="col-xs-6">';
        echo 'Imię: '.$doctor->Imie().'<br><hr>';
        echo 'Nazwisko: '.$doctor->Nazwisko().'<br><hr>';
        echo 'Pesel: '.$doctor->Pesel().'<br><hr>';
        echo 'Specjalizacja: '.$doctor->Specjalizacja().'<br><hr>';
    echo '</div>';
    echo '</div>';
}

function PatientInterview()
{
    echo "<h4><center>Ddodaj Wywiad</center></h4><hr>";
    echo '<div class="col-xs-12">';
        echo '<div class="col-xs-6 col-xs-offset-3">';
            echo '<form action="index.php" method="post" enctype="multipart/form-data">';
                echo '<label for="description" >Treść Wywiadu</label>';
                echo '<textarea name="description" cols="40" rows="5"></textarea><hr>';
                echo '<label for="from" >Niezdolność do pracy Od</label>';
                echo '<input type="date" name="from"><hr>';
                echo '<label for="to" >Niezdolność do pracy Do</label>';
                echo '<input type="date" name="to"><hr>';
                echo '<label for="first" >Czy pierwsze zachorowanie</label>';
                echo '<input type="radio" name="first" value="1" checked> Tak<br>';
                echo '<input type="radio" name="first" value="0"> Nie<br><hr>';
                echo '<label for="issue_number" >Numer Statystyczny Choroby</label><br>';
                echo '<input type="number" name="issue_number"><hr>';
                echo '<label for="pesel_pacjenta" >Pesel pacjenta</label>';
                echo '<input type="text" name="pesel_pacjenta"><hr>';
                echo '<center><input type="submit" name="add_interview_submit" value="Dodaj"><center>';
            echo '</form>';
        echo '</div>';
    echo '</div>';
}

function AddCertificate()
{
    echo "<h4><center>Ddodaj Zaświadczenie</center></h4><hr>";
        echo '<div class="col-xs-12">';
           echo '<div class="col-xs-6 col-xs-offset-3">';
            echo '<form action="index.php" method="post" enctype="multipart/form-data">';
                echo '<label for="description" >Rozpoznanie</label>';
                echo '<textarea name="description" cols="40" rows="5"></textarea><hr>';
                echo '<label for="reason" >Cel wydania zaświadczenia</label><br>';
                echo '<input type="text" name="reason"><hr>';
                echo '<label for="city" >Miejscowośc</label>';
                echo '<input type="text" name="city"><hr>';
                echo '<label for="pesel_pacjenta" >Pesel pacjenta</label>';
                echo '<input type="text" name="pesel_pacjenta"><hr>';
                echo '<center><input type="submit" name="add_certificate_submit" value="Dodaj"><center>';
            echo '</form>';
        echo '</div>';
    echo '</div>';
}


function AddPrescription()
{
    echo "<h4><center>Ddodaj Receptę</center></h4><hr>";
    echo '<div class="col-xs-12">';
        echo '<div class="col-xs-6 col-xs-offset-3">';
            echo '<form action="index.php" method="post" enctype="multipart/form-data">';
                echo '<label for="description" >Treść Recepty</label>';
                echo '<textarea name="description" cols="40" rows="5"></textarea><hr>';
                echo '<label for="pesel_pacjenta" >Pesel pacjenta</label>';
                echo '<input type="text" name="pesel_pacjenta"><hr>';
                echo '<center><input type="submit" name="add_prescription_submit" value="Dodaj"><center>';
            echo '</form>';
        echo '</div>';
    echo '</div>';
}

function SelectPatient()
{
    echo "<h4><center>Wybierz pacienta</center></h4><hr>";
    echo '<div class="col-xs-12">';
        echo '<div class="col-xs-6 col-xs-offset-3">';
            echo '<form action="index.php" method="post" enctype="multipart/form-data">';
                echo '<label for="pesel_pacjenta" >Pesel pacjenta</label>';
                echo '<input type="text" name="pesel_pacjenta"><hr>';
                echo '<center><input type="submit" name="select_patient_submit" value="Dodaj"><center>';
            echo '</form>';
        echo '</div>';
    echo '</div>';
}

function DisplayPatientCard($pesel)
{
    DisplayPrescriptions($pesel);
    DisplayInterviews($pesel);
    DisplayCertificates($pesel);
}


function DisplayPrescriptions($pesel)
{
    $connection = new Connection();
    $prescription_result=$connection->Set("SELECT * FROM recepta WHERE PeselPacjenta=".$pesel);
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

function DisplayInterviews($pesel)
{
    $connection = new Connection();
    $interview_result=$connection->Set("SELECT * FROM wywiad WHERE PeselPacjenta=".$pesel);
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
function DisplayCertificates($pesel)
{
    $connection = new Connection();
    $certificate_result=$connection->Set("SELECT * FROM zaswiadczenie WHERE PeselPacjenta=".$pesel);
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

if( isset($_POST['add_interview_submit']) )
{
    $interview=new Wywiad();
    $interview->SetAll($_POST['description'],$_POST['from'],$_POST['to'],$_POST['first'],$_POST['issue_number'],$_POST['pesel_pacjenta'],$_SESSION['id']);
    $interview->Add();
    header("Location: index.php?error=1");
    die();
}

if( isset($_POST['add_certificate_submit']) )
{
    $certificate=new Zaswiadczenie();
    $certificate->SetAll($_POST['description'],$_POST['reason'],$_POST['city'],$_POST['pesel_pacjenta'],$_SESSION['id']);
    $certificate->Add();
    header("Location: index.php?error=1");
    die();
}

if( isset($_POST['add_prescription_submit']) )
{
    $certificate=new Recepta();
    $certificate->SetAll($_POST['description'],$_POST['pesel_pacjenta'],$_SESSION['id']);
    $certificate->Add();
    header("Location: index.php?error=1");
    die();
}

if( isset($_POST['select_patient_submit']) )
{
    header("Location: index.php?menu=5&pesel=".$_POST['pesel_pacjenta']);
    die();
}

?>
