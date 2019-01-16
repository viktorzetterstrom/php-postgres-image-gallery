<?PHP
/*******************************************************************************
 * Course: DT161G
 * File: index.php
 * Desc: Start page for course DT161G
 *
 * Copyright:
 * Johan Timrén
 * johtim
 * johan.timren@miun.se
 ******************************************************************************/

/** @var string $server_ip */
$server_ip = $_SERVER['SERVER_ADDR'];

?>
<!DOCTYPE html>
<html lang="sv-SE">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="http://www.miun.se/favicon.ico"/>
    <link rel="stylesheet" href="labb1/css/style.css"/>
    <title>DT161G</title>
</head>
<body>
<header>
    <img src="lab1/img/mittuniversitetet.jpg" alt="miun logga" class="logo"/>
    <h1>DT161G Laborationer</h1>
</header>
<main>
    <aside>
        <h2>INFORMATION</h2>
        <p>
            Nedan finns lite information om denna filstruktur.</p>
        <p>
            Allt ni behöver för att genomför kursen ligger i mappen dt161g.
            Placera denna mapp förslagsvis i din webbroot på din HTTP server.
        </p>
        <p>
            För att kunna jobba mot PostgreSQL-databsen behöver du installlera pgAdmin.
            Det fungerar att använda både pgAdmin 3 och 4. PgAdmin 3 är enklast
            att använda för den som har Linux eller Mac som OS.
            För Windows användare finns det en instalations fil att ladda ner på
            pgAdmins hemsida för version 4.
        </p>
        <p>
            Om du tänker jobba mot en lokal PostgreSQL-databas är det lämpligt
            att skapa en användare, password och databas med samma uppgifter som
            du har på studentpsql.miun.se
        </p>
    </aside>
    <section>
        <h2>
            Laborationer i kursen DT161G
        </h2>
        <nav>
            Länkar till de olika laboratioerna, öppnas i nytt fönster
            <ul>
                <li>
                    <a href="lab1/" target="_blank">Laboration 1</a>
                </li>
                <li>
                    <a href="lab2/" target="_blank">Laboration 2</a>
                </li>
                <li>
                    <a href="lab3/" target="_blank">Laboration 3</a>
                </li>
                <li>
                    <a href="lab4/" target="_blank">Laboration 4</a>
                </li>
                <li>
                    <a href="project/" target="_blank">Projekt</a>
                </li>
            </ul>
        </nav>
        <h2>Nedan användbara länkar för ert arbete.</h2>
        <nav>
            Nedan finns länk till en PHP-info fil på din lokala server
            för att kunna kolla vilka moduler som är laddade i PHP-tolken.<br>
            Det finns också en länk till en fil för att testa så att du kan
            skriva till mappen writeable på universitetets servrar.<br>
            Om du vill testa den filen lokalt måste du skapa en mapp som heter
            "writeable" på samma nivå som dt161g-mappen.<br>
            <ul>
                <li>
                    <a href="phpinfo.php" target="_blank">PHP-info på
                        den server skriptet körs på</a>
                </li>
                <li>
                    <a href="test.php" target="_blank">TEST-fil för att
                        kolla att det fungerar att skriva till mappen
                        writeable</a>
                </li>
            </ul>
        </nav>
    </section>
</main>

<footer>
    &copy; Johan Timrén Mittuniversitetet
</footer>
</body>
</html>

