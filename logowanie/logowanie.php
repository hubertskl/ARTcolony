<HTML>
    <HEAD>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <TITLE>ArtColony - Logowanie</TITLE>
    </HEAD>
     
<BODY>
<div style='text-align:center; width:500px; background: #FF6633; margin:auto;'>
 
<?php
$login=$_POST['login'];
$password=$_POST['password'];
//Łączymy się z bazą danych funkcją mysqli_connect
$link = mysqli_connect(localhost, root,'', baranski);

if(!$link){echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error();}
mysqli_query($link, "SET NAMES 'utf8'");    //ustawienie polskich znaków
$result = mysqli_query($link, "SELECT * FROM uzytkownicy WHERE login='$login'");
 
// Funkcja mysqli_fetch_array() zapisuje wiersz wyniku w tablicy,
// w której elementami są wszystkie pola z wiersza bazy danych 
// gdzie login jest taki sam jaki podano w formularzu. 
$user = mysqli_fetch_array($result);
 
//Jeżeli zmienna $user jest pusta, czyli w bazie danych nie było użytkownika o podanym loginie
//to  zamykamy połączenie z bazą danych oraz wyświetlamy komunikat o błędzie:
if(!$user)
{
    // Funkcja mysqli_close() zamyka połączenie z bazą danych MySQl.
    mysqli_close($link);
    echo "<p>Błędny login. <a href='logowanie.php'>Zaloguj się</a></p>";
}
else
{                               // Jeżeli login był w bazie:
    if($user['password']==$password)  // - sprawdzamy czy hasło jest takie samo jak zapisane w bazie
    {                           // jeżeli tak - wyświetlamy zawartość strony dostępną
                                // dla zalogowanych użytkowników
        echo"<p>
            <h1>To jest zawartość strony widoczna po zalogowaniu</h1>
            <h3>Zalogowany użytkownik to: {$user['login']}</h3>
            </p>";
    }
    else                        //jeżeli hasło jest inne - zamykamy połączenie z bazą oraz wyświetlamy komunikat
    {
        mysqli_close($link);
        echo  "<p>Błędne hasło. <a href='logowanie.php'>Zaloguj się</a></p>";
    }
}
?>
</div>
                     
</BODY>
</HTML>