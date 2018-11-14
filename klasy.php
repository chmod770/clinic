<?php
class Connection
{
	private $dbhost = 'localhost';
    private $dbuser = 'donjoar';
    private $dbpass = ']X3w4;a5sc^%';
    private $dbname = 'baza';
    private $conn;
	
	function Connection () {
        $this->conn = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
        if (mysqli_connect_errno() != 0){
            echo '<p>Wystąpił błąd połączenia: ' . mysqli_connect_error() . '</p>';
            return;
        }
    }
	public function Set($query) {
        return $this->conn->query($query);
    }
    public function SetAssoc($query) {
        $result =  $this->conn->query($query);
        return $result->fetch_assoc();
    }
}
class Czlowiek{
	protected $imie;
	protected $nazwisko ;
}

class Pacjent extends Czlowiek{
	private $dataUrodzenia;
	private $adres;
	private $pesel;
	private $pracodawca;
	private $ubezpieczenie;
    private $haslo;


    function LoadFromDatabase($pesel)
    {
        $connection = new Connection();
        $pacjent_row = $connection->SetAssoc("SELECT * FROM pacjent WHERE pesel=" .$pesel);
        $this->pesel = $pacjent_row['Pesel'];
        $this->imie = $pacjent_row['Imie'];
        $this->nazwisko = $pacjent_row['Nazwisko'];
        $this->dataUrodzenia = $pacjent_row['DataUrodzenia'];
        $this->adres = $pacjent_row['Adres'];
        $this->ubezpieczenie = $pacjent_row['NrUbezpieczenia'];
        $this->pracodawca = $pacjent_row['NipPracodawcy'];
        $this->haslo = $pacjent_row['Haslo'];
    }


    function Pesel()
    {
        return $this->pesel;
    }

    function Imie()
    {
        return $this->imie;
    }

    function Nazwisko()
    {
        return $this->nazwisko;
    }

    function DataUrodzenia()
    {
        return $this->dataUrodzenia;
    }

    function Adres()
    {
        return $this->adres;
    }

    function Ubezpieczenie()
    {
        return $this->ubezpieczenie;
    }

    function Pracodawca()
    {
        return $this->pracodawca;
    }

    function SetAll($pesel,$imie,$nazwisko,$dataUrodzenia,$adres,$ubezpieczenie,$pracodawca)
    {
        $this->pesel=$pesel;
        $this->imie=$imie;
        $this->nazwisko=$nazwisko;
        $this->dataUrodzenia=$dataUrodzenia;
        $this->adres=$adres;
        $this->ubezpieczenie=$ubezpieczenie;
        $this->pracodawca=$pracodawca;
    }

    function Add()
   {
	   $connection= new Connection();
       $pesel=$this->pesel;
       $imie=$this->imie;
       $nazwisko=$this->nazwisko;
       $dataUrodzenia=$this->dataUrodzenia;
       $adres=$this->adres;
       $ubezpieczenie=$this->ubezpieczenie;
       $nipPracodawcy=$this->pracodawca;
	   $haslo=md5(substr($imie, -2).substr($nazwisko, -2).substr($pesel, -2));
	   $connection->Set("INSERT INTO `pacjent`(`Pesel`, `Imie`, `Nazwisko`, `DataUrodzenia`,`NipPracodawcy`, `Adres`,`NrUbezpieczenia`,`Haslo`) VALUES ('$pesel','$imie','$nazwisko','$dataUrodzenia','$nipPracodawcy','$adres','$ubezpieczenie','$haslo')");
	   
   }

   function Update()
   {
       $connection= new Connection();
       $connection->Set("UPDATE pacjent SET Imie='$this->imie'");
       $connection->Set("UPDATE pacjent SET Nazwisko='$this->nazwisko'");
       $connection->Set("UPDATE pacjent SET DataUrodzenia='$this->dataUrodzenia'");
       $connection->Set("UPDATE pacjent SET NipPracodawcy='$this->pracodawca'");
       $connection->Set("UPDATE pacjent SET Adres='$this->adres'");
       $connection->Set("UPDATE pacjent SET NrUbezpieczenia='$this->ubezpieczenie'");

   }
   function SetPesel($pesel)
	{
			$this->pesel=$pesel;
	}
   
   function Who()
   {
	   echo $this->pesel.','.$this->imie.','.$this->nazwisko.','.$this->dataUrodzenia.','.$this->adres.','.$this->ubezpieczenie.','.$this->pracodawca;
   }
   function Delete()
   {
       $connection= new Connection();
       $connection->Set("DELETE FROM `pacjent` WHERE `Pesel`=".$this->pesel);
   }
	
}

class Lekarz extends Czlowiek{

	private $pesel;
	private $specjalizacja;
	private $haslo;

    function LoadFromDatabase($pesel)
    {
        $connection = new Connection();
        $lekarz_row = $connection->SetAssoc("SELECT * FROM lekarz WHERE Pesel=" . $pesel);
        $this->pesel = $lekarz_row['Pesel'];
        $this->imie = $lekarz_row['Imie'];
        $this->nazwisko = $lekarz_row['Nazwisko'];
        $this->specjalizacja = $lekarz_row['Specjalizacja'];
        $this->haslo = $lekarz_row['Haslo'];
    }

    function SetAll($pesel,$imie,$nazwisko,$specjalizacja)
    {
        $this->pesel=$pesel;
        $this->imie=$imie;
        $this->nazwisko=$nazwisko;
        $this->specjalizacja=$specjalizacja;
    }

    function Pesel()
    {
        return $this->pesel;
    }

    function Imie()
    {
        return $this->imie;
    }

    function Nazwisko()
    {
        return $this->nazwisko;
    }

    function Specjalizacja()
    {
        return $this->specjalizacja;
    }

	function SetPesel($pesel)
	{
			$this->pesel=$pesel;
	}

    function Add()
    {
        $pesel=$this->pesel;
        $imie=$this->imie;
        $nazwisko=$this->nazwisko;
        $specjalizacja=$this->specjalizacja;
        $connection = new Connection();
		$haslo=md5(substr($imie, -2).substr($nazwisko, -2).substr($pesel, -2));
        $connection->Set("INSERT INTO `lekarz`(`Pesel`, `Imie`, `Nazwisko`, `Specjalizacja`,`Haslo`) VALUES ('$pesel','$imie','$nazwisko','$specjalizacja','$haslo')");
    }

    function Update()
    {
        $connection= new Connection();
        $connection->Set("UPDATE lekarz SET Imie='$this->imie'");
        $connection->Set("UPDATE lekarz SET Nazwisko='$this->nazwisko'");
        $connection->Set("UPDATE lekarz SET Specjalizacja='$this->specjalizacja'");
    }

    function Who()
    {
        echo $this->pesel.','.$this->imie.','.$this->nazwisko.','.$this->specjalizacja;
    }
    function Delete()
    {
        $connection= new Connection();
        $connection->Set("DELETE FROM `lekarz` WHERE `Pesel`=".$this->pesel);
    }
	
}

class Pracodawca extends Czlowiek{

	private $nip;
	private $miejscePracy;
	private $czynnikiSzkodliwe;

    function LoadFromDatabase($nip)
    {
        $connection = new Connection();
        $pracodawca_row = $connection->SetAssoc("SELECT * FROM pracodawca WHERE nip=" . $nip);
        $this->nip = $pracodawca_row['Nip'];
        $this->imie = $pracodawca_row['Imie'];
        $this->nazwisko = $pracodawca_row['Nazwisko'];
        $this->miejscePracy = $pracodawca_row['MiejscePracy'];
        $this->czynnikiSzkodliwe = $pracodawca_row['CzynnikiSzkodliwe'];
    }

    function SetNip($nip)
    {
        $this->nip=$nip;
    }

    function Nip()
    {
        return $this->nip;
    }
    function Imie()
    {
        return $this->imie;
    }
    function Nazwisko()
    {
        return $this->nazwisko;
    }
    function MiejscePracy()
    {
        return $this->miejscePracy;
    }
    function CzynnikiSzkodliwe()
    {
        return $this->czynnikiSzkodliwe;
    }

    function SetAll($nip,$imie,$nazwisko,$miejscePracy,$czynnikiSzkodliwe)
    {
        $this->nip=$nip;
        $this->imie=$imie;
        $this->nazwisko=$nazwisko;
        $this->miejscePracy=$miejscePracy;
        $this->czynnikiSzkodliwe=$czynnikiSzkodliwe;
    }

    function Add()
    {
        $nip=$this->nip;
        $imie=$this->imie;
        $nazwisko=$this->nazwisko;
        $miejscePracy=$this->miejscePracy;
        $czynnikiSzkodliwe=$this->czynnikiSzkodliwe;
        $connection = new Connection();
        $connection->Set("INSERT INTO `pracodawca`(`Nip`, `Imie`, `Nazwisko`, `MiejscePracy`, `CzynnikiSzkodliwe`) VALUES ('$nip','$imie','$nazwisko','$miejscePracy','$czynnikiSzkodliwe')");

    }

    function Update()
    {
        $connection= new Connection();
        $connection->Set("UPDATE pracodawca SET Imie='$this->imie'");
        $connection->Set("UPDATE pracodawca SET Nazwisko='$this->nazwisko'");
        $connection->Set("UPDATE pracodawca SET MiejscePracy='$this->miejscePracy'");
        $connection->Set("UPDATE pracodawca SET CzynnikiSzkodliwe='$this->czynnikiSzkodliwe'");

    }

    function Who()
    {
        echo $this->nip.','.$this->miejscePracy.','.$this->czynnikiSzkodliwe;
    }
    function Delete()
    {
        $connection= new Connection();
        $connection->Set("DELETE FROM `pracodawca` WHERE `Nip`=".$this->nip);
    }
	
}

class Ubezpieczenie{
	private $nrUbezpieczenia;
	private $oddzialNFZ;
	private $rodzajUbezpieczenia;
	private $pacjent;

    function LoadFromDatabase($nrUbezpieczenia)
    {
        $connection = new Connection();
        $ubezpieczenie_row = $connection->SetAssoc("SELECT * FROM ubezpieczenie WHERE NrUbezpieczenia=" .$nrUbezpieczenia);
        $this->nrUbezpieczenia = $nrUbezpieczenia;
        $this->oddzialNFZ = $ubezpieczenie_row['OdzialNFZ'];
        $this->rodzajUbezpieczenia = $ubezpieczenie_row['RodzajUbezpieczenia'];
        $this->pacjent = $ubezpieczenie_row['PeselPacjenta'];
    }

    function SetAll($nrUbezpieczenia,$oddzialNFZ,$rodzajUbezpieczenia,$pacjent)
    {
        $this->nrUbezpieczenia = $nrUbezpieczenia;
        $this->oddzialNFZ = $oddzialNFZ;
        $this->rodzajUbezpieczenia = $rodzajUbezpieczenia;
        $this->pacjent = $pacjent;
    }

    function Add()
    {
        $connection = new Connection();
        $values="'$this->nrUbezpieczenia','$this->oddzialNFZ','$this->rodzajUbezpieczenia','$this->pacjent'";
        $connection->Set("INSERT INTO `ubezpieczenie`(`NrUbezpieczenia`, `OdzialNFZ`, `RodzajUbezpieczenia`, `PeselPacjenta`) VALUES ($values)");
    }

    function SetNumber($numerUbezpieczenia)
    {
        $this->nrUbezpieczenia=$numerUbezpieczenia;
    }
    function Update()
    {
        $connection= new Connection();
        $connection->Set("UPDATE ubezpieczenie SET OddzialNFZ='$this->oddzialNFZ'");
        $connection->Set("UPDATE ubezpieczenie SET RodzajUbezpieczenia='$this->rodzajUbezpieczenia'");
        $connection->Set("UPDATE ubezpieczenie SET PeselPacjenta='$this->pacjent'");
    }

    function NumerUbezpieczenia()
    {
        return $this->nrUbezpieczenia;
    }
    function OddzialNFZ()
    {
        return $this->oddzialNFZ;
    }
    function PelselPacjenta()
    {
        return $this->pacjent;
    }
    function RodzajUbezpieczenia()
    {
        return $this->rodzajUbezpieczenia;
    }

    function Who()
    {
        echo $this->nrUbezpieczenia.','.$this->oddzialNFZ.','.$this->rodzajUbezpieczenia.','.$this->pacjent;
    }

    function Delete()
    {
        $connection = new Connection();
        $connection->Set("DELETE FROM ubezpieczenie WHERE NrUbezpieczenia = '".$this->nrUbezpieczenia."'");
    }
	
}

class Wywiad{


	private $idWywiadu;
	private $dataWystawienia;
	private $trescWywiadu;
	private $niezdolnoscDo;
	private $niezdolnoscOd;
	private $czyPierwszeZachorowanie;
	private $nrStatycznyChoroby;
	private $peselPacjenta;
	private $peselLekarza;



    function LoadFromDatabase($idWywiadu)
    {
        $connection = new Connection();
        $wywiad_row = $connection->SetAssoc("SELECT * FROM wywiad WHERE IdWywiadu=" .$idWywiadu);
        $this->idWywiadu = $idWywiadu;
        $this->dataWystawienia = $wywiad_row['DataWystawienia'];
        $this->trescWywiadu = $wywiad_row['TrescWywiadu'];
        $this->niezdolnoscDo = $wywiad_row['NiezdolnoscDo'];
        $this->niezdolnoscOd = $wywiad_row['NiezdolnoscOd'];
        $this->czyPierwszeZachorowanie = $wywiad_row['CzyPierwszeZachorowanie'];
        $this->nrStatycznyChoroby = $wywiad_row['NrStatycznyChoroby'];
        $this->peselPacjenta = $wywiad_row['peselPacjenta'];
        $this->peselLekarza = $wywiad_row['peselLekarza'];
    }

    function SetAll($trescWywiadu,$niezdolnoscDo,$niezdolnoscOd,$czyPierwszeZachorowanie,$nrStatycznyChoroby,$peselPacjenta,$peselLekarza)
    {
        $this->trescWywiadu = $trescWywiadu;
        $this->niezdolnoscDo = $niezdolnoscDo;
        $this->niezdolnoscOd = $niezdolnoscOd;
        $this->czyPierwszeZachorowanie = $czyPierwszeZachorowanie;
        $this->nrStatycznyChoroby = $nrStatycznyChoroby;
        $this->peselPacjenta = $peselPacjenta;
        $this->peselLekarza = $peselLekarza;
    }

    function Add()
    {
        $connection = new Connection();
        $values="NOW(),'$this->trescWywiadu','$this->niezdolnoscOd','$this->niezdolnoscDo','$this->czyPierwszeZachorowanie','$this->nrStatycznyChoroby','$this->peselPacjenta','$this->peselLekarza'";
        $connection->Set("INSERT INTO `wywiad`(`DataWystawienia`, `TrescWywiadu`, `NiezdolnoscDoPracyOd`, `NiezdolnoscDoPracyDo`, `CzyPierwszeZachorowanie`, `NrStatycznyChoroby`, `PeselPacjenta`, `PeselLekarza`) VALUES ($values)");
    }
    function Who()
    {
        echo $this->dataWystawienia.','.$this->trescWywiadu.','.$this->niezdolnoscDo.','.$this->niezdolnoscOd.','.$this->czyPierwszeZachorowanie.','.$this->nrStatycznyChoroby.','.$this->peselPacjenta.','.$this->peselLekarza;
    }
    function Delete()
    {
        $connection= new Connection();
        $connection->Set("DELETE FROM `wywiad` WHERE `IdWywiadu`=".$this->idWywiadu);
    }
}

class Recepta{
	private $idRecepty;
	private $dataWystawienia;
	private $dataRealizacji;
	private $receptaTersc;
	private $pacjent;

    function LoadFromDatabase($idRecepty)
    {
        $connection = new Connection();
        $recepta_row = $connection->SetAssoc("SELECT * FROM recepta WHERE IdRecepty=" .$idRecepty);
        $this->idRecepty = $idRecepty;
        $this->dataWystawienia = $recepta_row['DataWystawienia'];
        $this->dataRealizacji = $recepta_row['DataRealizacji'];
        $this->receptaTersc = $recepta_row['ReceptaTersc'];
        $this->pacjent = $recepta_row['PeselPacjenta'];
    }

    function SetAll($receptaTersc,$pacjent,$lekarz)
    {
        $this->receptaTersc = $receptaTersc;
        $this->pacjent = $pacjent;
        $this->lekarz = $lekarz;
    }

    function Add()
    {
        $connection = new Connection();
        $values="NOW(),'$this->receptaTersc','$this->pacjent','$this->lekarz'";
        $connection->Set( "INSERT INTO `recepta`(`DataWystawienia`, `ReceptaTresc`, `PeselPacjenta`, `PeselLekarza`) VALUES ($values)" );
    }

    function Who()
    {
        echo $this->dataWystawienia.','.$this->dataRealizacji.','.$this->receptaTersc.','.$this->pacjent;
    }
    function Delete()
    {
        $connection= new Connection();
        $connection->Set("DELETE FROM `recepta` WHERE `IdRecepty`=".$this->idRecepty);
    }
}

class Zaswiadczenie
{	

 private $idZaswiadczenia;
 private $rozpoznanie;
 private $celWydaniaZaswiadczeniea;
 private $data;
 private $miejscowosc;
 private $pacjent;
 private $lekarz;

    function LoadFromDatabase($idZaswiadczenia)
    {
        $connection = new Connection();
        $recepta_row = $connection->SetAssoc("SELECT * FROM zaswiadczenie WHERE IdZaswiadczenia=" .$idZaswiadczenia);
        $this->idZaswiadczenia = $idZaswiadczenia;
        $this->rozpoznanie = $recepta_row['Rozpoznanie'];
        $this->celWydaniaZaswiadczeniea = $recepta_row['CelWydaniaZaswiadczeniea'];
        $this->data = $recepta_row['Data'];
        $this->miejscowosc = $recepta_row['Miejscowosc'];
        $this->pacjent = $recepta_row['PeselPacjenta'];
    }

    function SetAll($rozpoznanie,$celWydaniaZaswiadczenia,$miejscowosc,$pacjent,$lekarz)
    {
        $this->rozpoznanie = $rozpoznanie;
        $this->celWydaniaZaswiadczenia = $celWydaniaZaswiadczenia;
        $this->miejscowosc = $miejscowosc;
        $this->pacjent = $pacjent;
        $this->lekarz = $lekarz;
    }

    function Add()
    {
        $connection = new Connection();
        $values="'$this->rozpoznanie','$this->celWydaniaZaswiadczenia',NOW(),'$this->miejscowosc','$this->pacjent','$this->lekarz'";
        $connection->Set("INSERT INTO `zaswiadczenie`(`Rozpoznanie`, `CelWydaniaZaswiadczenia`, `Data`, `Miejscowosc`, `PeselPacjenta`, `PeselLekarza`) VALUES ($values)");
    }

    function Who()
    {
        echo $this->idZaswiadczenia.','.$this->rozpoznanie.','.$this->celWydaniaZaswiadczeniea.','.$this->data.','.$this->miejscowosc.','.$this->pacjent;
    }

    function Delete()
    {
        $connection= new Connection();
        $connection->Set("DELETE FROM `zaswiadczenie` WHERE `IdZaswiadczenia`=".$this->idZaswiadczenia);
    }

 }


?>