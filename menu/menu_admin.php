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
	if($_GET['error']==3)
	{
		echo '<script>alert("Zaktualizowano Pomyślnie !")</script>';
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
    if(isset($_GET['nr_ubezpieczenia']))
        $numerUbezpieczenia=$_GET['nr_ubezpieczenia'];
}

switch( $menu )
{
    case 0:
    Searching();
    break;
	case 1:
	AddPatient();
	break;
	case 2:
	AddDoctor();
	break;
	case 3:
	DeletePatient();
	break;
	case 4:
	DeleteDoctor();
	break;
    case 5:
    AddEmployer();
    break;
    case 6:
    AddInsurance();
    break;
    case 7:
    DisplayDoctor($pesel);
    break;
    case 8:
    DisplayPatient($pesel);
    break;
    case 9:
    EditPatient($pesel);
    break;
    case 10:
    EditDoctor($pesel);
    break;
    case 11:
    DisplayEmployer($pesel);
    break;
    case 12:
    EditEmployer($pesel);
    break;
    case 14:
    DisplayInsurance($numerUbezpieczenia);
    break;
    case 15:
    EditInsurance($numerUbezpieczenia);
    break;
    case 16:
    SearchingInsurance();
    break;

}

function AddPatient()
{
	echo "<h4><center>Ddodaj Pacjenta</center></h4><hr>";
	echo '<div class="col-xs-12">';
		echo '<div class="col-xs-6 col-xs-offset-3">';
			echo '<form action="index.php" method="post" enctype="multipart/form-data">';
				echo '<label for="pesel" >Pesel</label>';
				echo '<input type="text" name="pesel"><hr>';
				echo '<label for="imie" >Imie</label>';
				echo '<input type="text" name="imie"><hr>';
				echo '<label for="nazwisko" >Nazwisko</label>';
				echo '<input type="text" name="nazwisko"><hr>';
				echo '<label for="data" >Data urodzenia</label>';
				echo '<input type="date" name="data"><hr>';
				echo '<label for="adres" >Adres</label>';
				echo '<input type="text" name="adres"><hr>';
				echo '<label for="ubezpieczenie" >Ubezpieczenie</label>';
				echo '<input type="text" name="ubezpieczenie"><hr>';
				echo '<label for="nip" >Nip Pracodawcy</label>';
				echo '<input type="text" name="nip"><hr>';
				echo '<center><input type="submit" name="add_patient_submit" value="Dodaj"><center>';
			echo '</form>';
		echo '</div>';
	echo '</div>';
	
}
function EditPatient($pesel)
{
    $patient = new Pacjent();
    $patient->LoadFromDatabase($pesel);
	echo "<h4><center>Edytuj Pacjenta</center></h4><hr>";
	echo '<div class="col-xs-12">';
		echo '<div class="col-xs-6 col-xs-offset-3">';
			echo '<form action="index.php" method="post" enctype="multipart/form-data">';
				echo '<input type="hidden" name="pesel" value="'.$patient->Pesel().'"><hr>';
				echo '<label for="imie"  >Imie</label>';
				echo '<input type="text" name="imie" value="'.$patient->Imie().'"><hr>';
				echo '<label for="nazwisko" >Nazwisko</label>';
				echo '<input type="text" name="nazwisko" value="'.$patient->Nazwisko().'"><hr>';
				echo '<label for="data" >Data urodzenia</label>';
				echo '<input type="date" name="data" value="'.$patient->DataUrodzenia().'"><hr>';
				echo '<label for="adres" >Adres</label>';
				echo '<input type="text" name="adres" value="'.$patient->Adres().'"><hr>';
				echo '<label for="ubezpieczenie" >Ubezpieczenie</label>';
				echo '<input type="text" name="ubezpieczenie" value="'.$patient->Ubezpieczenie().'"><hr>';
				echo '<label for="nip" >Nip Pracodawcy</label>';
				echo '<input type="text" name="nip" value="'.$patient->Pracodawca().'"><hr>';
				echo '<center><input type="submit" name="edit_patient_submit" value="Aktualizuj"><center>';
			echo '</form>';
		echo '</div>';
	echo '</div>';

}

function AddEmployer()
{
    echo "<h4><center>Ddodaj Pracodawce</center></h4><hr>";
    echo '<div class="col-xs-12">';
        echo '<div class="col-xs-6 col-xs-offset-3">';
            echo '<form action="index.php" method="post" enctype="multipart/form-data">';
                echo '<label for="nip" >Nip</label>';
                echo '<input type="text" name="nip"><hr>';
                echo '<label for="imie" >Imie</label>';
                echo '<input type="text" name="imie"><hr>';
                echo '<label for="nazwisko" >Nazwisko</label>';
                echo '<input type="text" name="nazwisko"><hr>';
                echo '<label for="work_place" >Miejsce Pracy</label>';
                echo '<input type="text" name="work_place"><hr>';
                echo '<label for="harmful_agents" >Czynniki szkodliwe</label>';
                echo '<textarea name="harmful_agents" cols="40" rows="5"></textarea><hr>';
                echo '<center><input type="submit" name="add_employer_submit" value="Dodaj"><center>';
            echo '</form>';
        echo '</div>';
    echo '</div>';

}

function EditEmployer($nip)
{
    $employer = new Pracodawca();
    $employer->LoadFromDatabase($nip);
    echo "<h4><center>Edytuj Pracodawcę</center></h4><hr>";
    echo '<div class="col-xs-12">';
        echo '<div class="col-xs-6 col-xs-offset-3">';
            echo '<form action="index.php" method="post" enctype="multipart/form-data">';
                echo '<label for="nip" >Nip</label>';
                echo '<input type="text" name="nip" value="'.$employer->Nip().'"><hr>';
                echo '<label for="imie" >Imie</label>';
                echo '<input type="text" name="imie" value="'.$employer->Imie().'"><hr>';
                echo '<label for="nazwisko" >Nazwisko</label>';
                echo '<input type="text" name="nazwisko" value="'.$employer->Nazwisko().'"><hr>';
                echo '<label for="work_place" >Miejsce Pracy</label>';
                echo '<input type="text" name="work_place" value="'.$employer->MiejscePracy().'"><hr>';
                echo '<label for="harmful_agents" >Czynniki szkodliwe</label>';
                echo '<textarea name="harmful_agents" cols="40" rows="5">'.$employer->CzynnikiSzkodliwe().'</textarea><hr>';
                echo '<center><input type="submit" name="edit_employer_submit" value="Aktualizuj"><center>';
            echo '</form>';
        echo '</div>';
    echo '</div>';

}

function AddDoctor()
{
	echo "<h4><center>Ddodaj Lekarza</center></h4><hr>";
	echo '<div class="col-xs-12">';
		echo '<div class="col-xs-6 col-xs-offset-3">';
			echo '<form action="index.php" method="post" enctype="multipart/form-data">';
				echo '<label for="pesel" >Pesel</label>';
				echo '<input type="text" name="pesel"><hr>';
				echo '<label for="imie" >Imie</label>';
				echo '<input type="text" name="imie"><hr>';
				echo '<label for="nazwisko" >Nazwisko</label>';
				echo '<input type="text" name="nazwisko"><hr>';
				echo '<label for="specjalizacja" >Specjalizacja</label>';
				echo '<input type="text" name="specjalizacja"><hr>';
				echo '<center><input type="submit" name="add_doctor_submit" value="Dodaj"><center>';
			echo '</form>';
		echo '</div>';
	echo '</div>';
}

function EditDoctor($pesel)
{

    $doctor= new Lekarz();
    $doctor->LoadFromDatabase($pesel);
	echo "<h4><center>Aktualizuj Lekarza</center></h4><hr>";
	echo '<div class="col-xs-12">';
		echo '<div class="col-xs-6 col-xs-offset-3">';
			echo '<form action="index.php" method="post" enctype="multipart/form-data">';
				echo '<input type="hidden" name="pesel" value="'.$doctor->Pesel().'"><hr>';
				echo '<label for="imie" >Imie</label>';
				echo '<input type="text" name="imie" value="'.$doctor->Imie().'"><hr>';
				echo '<label for="nazwisko" >Nazwisko</label>';
				echo '<input type="text" name="nazwisko" value="'.$doctor->Nazwisko().'"><hr>';
				echo '<label for="specjalizacja" >Specjalizacja</label>';
				echo '<input type="text" name="specjalizacja" value="'.$doctor->Specjalizacja().'"><hr>';
				echo '<center><input type="submit" name="edit_doctor_submit" value="Aktualizuj"><center>';
			echo '</form>';
		echo '</div>';
	echo '</div>';
}

function AddInsurance()
{
    echo "<h4><center>Dodaj Ubezpieczenie</center></h4><hr>";
    echo '<div class="col-xs-12">';
        echo '<div class="col-xs-6 col-xs-offset-3">';
            echo '<form action="index.php" method="post" enctype="multipart/form-data">';
                echo '<label for="insurance_id" >Numer Ubezpieczenia</label>';
                echo '<input type="text" name="insurance_id"><hr>';
                echo '<label for="nfz_section" >Oddział NFZ</label>';
                echo '<input type="text" name="nfz_section"><hr>';
                echo '<label for="insurance_kind" >Rodzaj Ubezpieczenia</label>';
                echo '<input type="text" name="insurance_kind"><hr>';
                echo '<label for="pesel" >Pesel pacjenta</label>';
                echo '<input type="text" name="pesel"><hr>';
                echo '<center><input type="submit" name="add_insurance_submit" value="Dodaj"><center>';
            echo '</form>';
        echo '</div>';
    echo '</div>';
}
function EditInsurance($numerUbezpieczenia)
{
    $insurence= new Ubezpieczenie();
    $insurence->LoadFromDatabase($numerUbezpieczenia);
    echo "<h4><center>Aktualizuj Ubezpieczenie</center></h4><hr>";
    echo '<div class="col-xs-12">';
        echo '<div class="col-xs-6 col-xs-offset-3">';
            echo '<form action="index.php" method="post" enctype="multipart/form-data">';
                echo '<label for="insurance_id" >Numer Ubezpieczenia</label>';
                echo '<input type="text" name="insurance_id" value="'.$insurence->NumerUbezpieczenia().'"><hr>';
                echo '<label for="nfz_section" >Oddział NFZ</label>';
                echo '<input type="text" name="nfz_section" value="'.$insurence->OddzialNFZ().'"><hr>';
                echo '<label for="insurance_kind" >Rodzaj Ubezpieczenia</label>';
                echo '<input type="text" name="insurance_kind" value="'.$insurence->RodzajUbezpieczenia().'"><hr>';
                echo '<label for="pesel" >Pesel pacjenta</label>';
                echo '<input type="text" name="pesel" value="'.$insurence->PelselPacjenta().'"><hr>';
                echo '<center><input type="submit" name="edit_insurance_submit" value="Aktualizuj"><center>';
            echo '</form>';
        echo '</div>';
    echo '</div>';
}

function DeletePatient()
{
	echo "<h4><center>Usuń Pacjenta</center></h4><hr>";
	echo '<div class="col-xs-12">';
		echo '<div class="col-xs-6 col-xs-offset-3">';
			echo '<form action="index.php" method="post" enctype="multipart/form-data">';
				echo '<label for="pesel" >Pesel</label>';
				echo '<input type="text" name="pesel"><hr>';
				echo '<center><input type="submit" name="delete_patient_submit" value="Usuń"><center>';
			echo '</form>';
		echo '</div>';
	echo '</div>';
}

function DeleteDoctor()
{
	echo "<h4><center>Usuń Lekarza</center></h4><hr>";
	echo '<div class="col-xs-12">';
		echo '<div class="col-xs-6 col-xs-offset-3">';
			echo '<form action="index.php" method="post" enctype="multipart/form-data">';
				echo '<label for="pesel" >Pesel</label>';
				echo '<input type="text" name="pesel"><hr>';
				echo '<center><input type="submit" name="delete_doctor_submit" value="Usuń"><center>';
			echo '</form>';
		echo '</div>';
	echo '</div>';
}

function Searching()
{
    echo "<h4><center>Wyszukaj</center></h4><hr>";
    echo '<div class="col-xs-12">';
        echo '<div class="col-xs-6 col-xs-offset-3">';
            echo '<form action="index.php" method="post" enctype="multipart/form-data">';
                echo '<label for="pesel" >Pesel/NIP</label>';
                echo '<input type="text" name="pesel" required><hr>';
                echo '<label for="pesel" >Rodzaj Użytkownika</label>';
                echo '<select name="kind">';
                    echo '<option value="doctor">Lekarz</option>';
                    echo '<option value="patient">Pacjent</option>';
                    echo '<option value="employer">Pracodawca</option>';
                echo '</select>';
                echo '<center><input type="submit" name="searching_submit" value="Wyszukaj"><center>';
            echo '</form>';
        echo '</div>';
    echo '</div>';
}

function SearchingInsurance()
{
    echo "<h4><center>Wyszukaj</center></h4><hr>";
    echo '<div class="col-xs-12">';
        echo '<div class="col-xs-6 col-xs-offset-3">';
            echo '<form action="index.php" method="post" enctype="multipart/form-data">';
                echo '<label for="pesel" >Numer Ubezpieczenia</label>';
                echo '<input type="text" name="nr_ubezpieczenia" required><hr>';
                echo '<input type="hidden" name="kind" value="insurence">';
                echo '<center><input type="submit" name="searching_submit" value="Wyszukaj"><center>';
            echo '</form>';
        echo '</div>';
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
    echo "<h4><center>Lekarz</center></h4><hr>";
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
        echo '<div class="col-xs-2 ">';
    echo '<button type="button"><a href="index.php?delete_doctor_submit=1&menu=4&pesel='.$doctor->Pesel().'">Usuń</a></button><br>';
            echo '<button type="button"><a href="index.php?menu=10&pesel='.$doctor->Pesel().'">Aktualizuj</a></button>';
        echo '</div>';
      echo '</div>';
    echo '</div>';
}
function DisplayInsurance($nrUbezpieczenia)
{
    $insurence = new Ubezpieczenie();
    $insurence->LoadFromDatabase($nrUbezpieczenia);
    if($insurence->NumerUbezpieczenia()==""||$insurence->PelselPacjenta()=="")
    {
        echo "<h4><center>Ubezpieczenie o podanym numerze nie istnieje w bazie</center></h4><hr>";
        return;
    }
    echo "<h4><center>Ubezpieczenie</center></h4><hr>";
    echo '<div class="col-xs-12">';
      echo '<div class="row">';
        echo '<div class="col-xs-2">';
            echo 'Numer Ubezpieczenia:<br>';
            echo $insurence->NumerUbezpieczenia().'<br>';
        echo '</div>';
        echo '<div class="col-xs-2">';
            echo 'Oddzial NFZ:<br>';
            echo $insurence->OddzialNFZ().'<br>';
        echo '</div>';
        echo '<div class="col-xs-2 ">';
            echo 'Rodzaj Ubezpieczenia:<br>';
            echo $insurence->RodzajUbezpieczenia().'<br>';
        echo '</div>';
        echo '<div class="col-xs-2 col-xs-offset-1">';
            echo 'Pesel Pacjenta:<br>';
            echo $insurence->PelselPacjenta().'<br>';
        echo '</div>';
        echo '<div class="col-xs-2 ">';
    echo '<button type="button"><a href="index.php?delete_insurance_submit=1&nr_ubezpieczenia='.$insurence->NumerUbezpieczenia().'">Usuń</a></button><br>';
            echo '<button type="button"><a href="index.php?menu=15&nr_ubezpieczenia='.$insurence->NumerUbezpieczenia().'">Aktualizuj</a></button>';
        echo '</div>';
      echo '</div>';
    echo '</div>';
}

function DisplayEmployer($pesel)
{
    $employer = new Pracodawca();
    $employer ->LoadFromDatabase($pesel);
    if($employer->Nip()=="")
    {
        echo "<h4><center>Pracownik o podanym numerze Nip nie istnieje w bazie</center></h4><hr>";
        return;
    }
    echo "<h4><center>Pracodawca</center></h4><hr>";
    echo '<div class="col-xs-12">';
      echo '<div class="row">';
        echo '<div class="col-xs-2 top5">';
            echo '<img src="img/avatar.png" class="img-circle" width="50">';
        echo '</div>';
        echo '<div class="col-xs-2">';
            echo 'Pracodawca:<br>';
            echo $employer->Imie().'<br>';
            echo $employer->Nazwisko();
        echo '</div>';
        echo '<div class="col-xs-2">';
            echo 'Miejsce Pracy:<br>';
            echo $employer->MiejscePracy().'<br>';
        echo '</div>';
        echo '<div class="col-xs-2 col-xs-offset-1">';
            echo 'Czyniki Szkodliwe:<br>';
            echo $employer->CzynnikiSzkodliwe().'<br>';
        echo '</div>';
        echo '<div class="col-xs-2 ">';
    echo '<button type="button"><a href="index.php?delete_employer_submit=1&menu=4&pesel='.$employer->Nip().'">Usuń</a></button><br>';
            echo '<button type="button"><a href="index.php?menu=12&pesel='.$employer->Nip().'">Aktualizuj</a></button>';
        echo '</div>';
      echo '</div>';
    echo '</div>';
}

function DisplayPatient($pesel)
{
    $patient = new Pacjent();
    $patient->LoadFromDatabase($pesel);
    if($patient->Pesel()=="")
    {
        echo "<h4><center>Pacjent o podanym numerze pesel nie istnieje w bazie</center></h4><hr>";
        return;
    }
    echo "<h4><center>Pacjent</center></h4><hr>";
        echo '<div class="col-xs-12">';
             echo '<div class="row">';
                echo '<div class="col-xs-2 top5">';
                    echo '<img src="img/avatar.png" class="img-circle" width="50">';
                echo '</div>';
                echo '<div class="col-xs-2">';
                    echo 'Pacjent:<br>';
                    echo $patient->Imie().'<br>';
                    echo $patient->Nazwisko().'<br>';
                echo '</div>';
                echo '<div class="col-xs-2 col-xs-offset-1">';
                    echo 'Pesel:<br>';
                    echo $patient->Pesel().'<br>';
                echo '</div>';
                echo '<div class="col-xs-2 col-xs-offset-1">';
                    echo 'Nip Pracodawcy<br>';
                    echo $patient->Pracodawca();
                echo '</div>';
                echo '<div class="top100">';
                echo '<div class="col-xs-3">';
                    echo 'Adres:<br>';
                    echo $patient->Adres();
                echo '</div>';
                echo '<div class="col-xs-3 ">';
                    echo 'Data Urodzenia:<br>';
                    echo $patient->DataUrodzenia();
                echo '</div>';
                echo '<div class="col-xs-2 ">';
                    echo 'Ubezpieczenie:<br>';
                echo $patient->Ubezpieczenie();
                echo '</div>';
                echo '<div class="col-xs-2 col-xs-offset-1">';
                    echo '<button type="button"><a href="index.php?delete_patient_submit=1&menu=3&pesel='.$patient->Pesel().'">Usuń</a></button><br>';
                    echo '<button type="button"><a href="index.php?menu=9&pesel='.$patient->Pesel().'"">Aktualizuj</a></button>';
                echo '</div>';
                echo '</div>';
        echo '</div>';
    echo '</div>';
}

if(isset($_POST['add_patient_submit']))
{
	
	$newPatient=new Pacjent();
	$newPatient->SetAll($_POST['pesel'],$_POST['imie'],$_POST['nazwisko'],$_POST['data'],$_POST['adres'],$_POST['ubezpieczenie'],$_POST['nip']);
	$newPatient->Add();
	header("Location: index.php?error=1");
	die();
}

if(isset($_POST['edit_patient_submit']))
{

    $newPatient=new Pacjent();
    $newPatient->SetAll($_POST['pesel'],$_POST['imie'],$_POST['nazwisko'],$_POST['data'],$_POST['adres'],$_POST['ubezpieczenie'],$_POST['nip']);
    $newPatient->Update();
    header("Location: index.php?error=3&menu=8&pesel=".$_POST['pesel']);
    die();
}

if(isset($_POST['add_doctor_submit']))
{
	
	$newDoctor=new Lekarz();
	$newDoctor->SetAll($_POST['pesel'],$_POST['imie'],$_POST['nazwisko'],$_POST['specjalizacja']);
	$newDoctor->Add();
	header("Location: index.php?error=1");
	die();
}

if(isset($_POST['edit_doctor_submit']))
{

	$newDoctor=new Lekarz();
	$newDoctor->SetAll($_POST['pesel'],$_POST['imie'],$_POST['nazwisko'],$_POST['specjalizacja']);
	$newDoctor->Update();
	header("Location: index.php?error=3&menu=7&pesel=".$_POST['pesel']);
	die();
}


if(isset($_POST['edit_employer_submit']))
{
	$employer=new Pracodawca();
    $employer->SetAll($_POST['nip'],$_POST['imie'],$_POST['nazwisko'],$_POST['work_place'],$_POST['harmful_agents']);
    $employer->Update();
	header("Location: index.php?error=3&menu=11&pesel=".$_POST['nip']);
	die();
}

if(isset($_REQUEST['delete_patient_submit']))
{
	$patient=new Pacjent();
	$patient->SetPesel($_REQUEST['pesel']);
	$patient->Delete();
	header("Location: index.php?error=2");
	die();
}

if(isset($_REQUEST['delete_doctor_submit']))
{
	
	$doctor=new Lekarz();
	$doctor->SetPesel($_REQUEST['pesel']);
	$doctor->Delete();
	header("Location: index.php?error=2");
	die();
}

if(isset($_REQUEST['delete_insurance_submit']))
{
    $insurance=new Ubezpieczenie();
    $insurance->SetNumber($_REQUEST['nr_ubezpieczenia']);
    $insurance->Delete();
    header("Location: index.php?error=2");
   die();
}

if(isset($_REQUEST['delete_employer_submit']))
{

	$employer=new Pracodawca();
    $employer->SetNip($_REQUEST['pesel']);
    $employer->Delete();
	header("Location: index.php?error=2");
	die();
}

if(isset($_POST['add_employer_submit']))
{
    $employer=new Pracodawca();
    $employer->SetAll($_POST['nip'],$_POST['imie'],$_POST['nazwisko'],$_POST['work_place'],$_POST['harmful_agents']);
    $employer->Add();
    header("Location: index.php?error=1");
    die();
}

if(isset($_POST['add_insurance_submit']))
{
    $insurance=new Ubezpieczenie();
    $insurance->SetAll($_POST['insurance_id'],$_POST['nfz_section'],$_POST['insurance_kind'],$_POST['pesel']);
    $insurance->Add();
    header("Location: index.php?error=1");
    die();
}

if(isset($_POST['edit_insurance_submit']))
{
    $insurance=new Ubezpieczenie();
    $insurance->SetAll($_POST['insurance_id'],$_POST['nfz_section'],$_POST['insurance_kind'],$_POST['pesel']);
    $insurance->Update();
    header("Location: index.php?error=3&menu=16&nr_ubezpieczenia=".$_POST['insurance_id']);
    die();
}

if(isset($_POST['searching_submit']))
{
    if($_POST["kind"]=="doctor") {
        header("Location: index.php?menu=7&pesel=".$_POST['pesel']);
        die();
    }
    if($_POST["kind"]=="patient") {
        header("Location: index.php?menu=8&pesel=".$_POST['pesel']);
        die();
    }
    if($_POST["kind"]=="employer") {
        header("Location: index.php?menu=11&pesel=".$_POST['pesel']);
        die();
    }
    if($_POST["kind"]=="insurence") {
        header("Location: index.php?menu=14&nr_ubezpieczenia=".$_POST['nr_ubezpieczenia']);
        die();
    }
}

?>