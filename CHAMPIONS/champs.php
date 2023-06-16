<?php
include "../connection.php";

global $conn;


$check_table_statement = "SHOW TABLES LIKE 'CHAMPIONS'";
$table_exists = $conn->query($check_table_statement)->rowCount() !== 0;


if (!$table_exists) {
    $new_table_statement = "CREATE TABLE CHAMPIONS (
        champion_ID INT AUTO_INCREMENT,
        CHAMPION_NAME VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
        CHAMPION_HINT1 VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
        CHAMPION_HINT2 VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
        CHAMPION_HINT3 VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
        PRIMARY KEY (champion_ID)
    )";
    $conn->exec($new_table_statement);


    $data = array(
        array("Ahri", "Lisza czarodziejka", "Szybkie i precyzyjne ruchy", "Umiejętność spowalniania i uwięziania wroga"),
        array("Akali", "Ninja zabójczyni", "Silna w walce wręcz", "Potrafi zniknąć w dymie i uniknąć obrażeń"),
        array("Alistar", "Minotaur wojownik", "Wielka siła fizyczna", "Potrafi odrzucać i uwięzić przeciwników"),
        array("Amumu", "Smutek wędrowca", "Łączy się z duszą", "Ma zdolność do stłumienia wrogów i zadawania obrażeń obszarowych"),
        array("Anivia", "Feniks lodu", "Potężne zdolności kontrolne", "Może zamrozić i unieruchomić przeciwników"),
        array("Annie", "Dziecięcy geniusz", "Posiada wielką moc magiczną", "Potrafi przywoływać ogień i kontrolować niedźwiedzia"),
        array("Aphelios", "Cygnus zabójca", "Broń o wielu zdolnościach", "Każdy atak zmienia się w zależności od fazy księżyca"),
        array("Ashe", "Łowczyni z północy", "Mistrzyni łuku", "Ma zdolność do spowalniania wrogów i zadawania dużych obrażeń na odległość"),
        array("Azir", "Władca piasku", "Manipulacja piaskiem", "Potrafi przywoływać żołnierzy z piasku i kontrolować obszar bitwy"),
        array("Bard", "Wędrowiec z kosmicznego skrzydła", "Ma magiczne zdolności wsparcia", "Potrafi zbierać i używać czarne kafle"),
        array("Blitzcrank", "Poważny robot", "Posiada chwytający haczyk", "Ma zdolność do unieruchamiania wrogów"),
        array("Brand", "Ognisty mag", "Zadaje obrażenia obszarowe", "Potrafi podpalić i poparzyć wrogów"),
        array("Braum", "Tarcza Freljordu", "Mistrz obrony", "Może blokować ataki i chronić sojuszników"),
        array("Caitlyn", "Strażnik Piltover", "Mistrzyni snajperska", "Potrafi zadawać duże obrażenia na odległość"),
        array("Camille", "Żelazna Pięść", "Śmiertelna wojowniczka", "Ma zdolności do szybkich i precyzyjnych ataków"),
        array("Cassiopeia", "Wężowa czarownica", "Atakuje trucizną", "Potrafi zatruwać i osłabiać wrogów"),
        array("ChoGath", "Terror Pustkowi", "Potężna bestia", "Zadaje ogromne obrażenia i może zwiększać swoją wielkość"),
        array("Corki", "As lotnictwa", "Pilotuje myśliwiec", "Zadaje obrażenia z powietrza i posiada bomby"),
        array("Darius", "Nocny Łowca", "Silny wojownik", "Potrafi zadawać duże obrażenia wręcz i ma mocne umiejętności do walki"),
        array("Diana", "Księżycowa wojowniczka", "Zadaje obrażenia magiczne", "Potrafi wywoływać żywioł księżyca"),
        array("Draven", "Okrutny rozgrywający", "Mistrz rzucania toporem", "Potrafi zadawać ogromne obrażenia wręcz"),
        array("Ekko", "Pewny siebie wędrowiec czasu", "Ma zdolność do manipulacji czasem", "Potrafi cofać się w czasie i zadawać duże obrażenia"),
        array("Elise", "Królowa pająków", "Zadaje obrażenia magiczne i fizyczne", "Może przemieniać się w pająka"),
        array("Evelynn", "Znikająca morderczyni", "Potrafi się ukryć przed wrogami", "Zadaje duże obrażenia z zaskoczenia"),
        array("Ezreal", "Poszukiwacz skarbów", "Mistrz strzał z dystansu", "Ma zdolność do wystrzeliwania energii magicznych strzał"),
        array("Fiddlesticks", "Strach na strach", "Potężny straszak", "Może przerażać wrogów i kontrolować terytorium"),
        array("Fiora", "Arcymistrzowska pojedynkowiczka", "Mistrzyni walki wręcz", "Potrafi unikać ataków i zadawać precyzyjne ciosy"),
        array("Fizz", "Prankster morski", "Zręczny zabójca", "Ma zdolność do skakania i unikania obrażeń"),
        array("Galio", "Żelazny golem", "Potężny tank", "Ma zdolność do ochrony sojuszników i kontrolowania tłumu"),
        array("Gangplank", "Kapitan z pirackiego okrętu", "Potrafi zadawać duże obrażenia z odległości", "Posiada zdolność do ostrzałów artyleryjskich"),
        array("Gnar", "Młody prehistoryczny yordle", "Zdolność do przemiany w gigantyczną formę", "Może zadać ogromne obrażenia i kontrolować wrogów"),
        array("Gragas", "Nadmiarowy piwowar", "Potężny wojownik", "Może zadawać duże obrażenia i kontrolować obszar bitwy"),
        array("Graves", "Wzorowy łowca nagród", "Mistrz strzelania z broni palnej", "Ma zdolność do zadawania dużych obrażeń z dystansu"),
        array("Hecarim", "Duch Wojny", "Potężny jeździec", "Zadaje ogromne obrażenia i ma zdolności do szybkiego przemieszczania się po mapie"),
        array("Heimerdinger", "Geniusz z Kumportu", "Ekspert od wynalazków", "Może stawiać wieże obronne i zadawać obrażenia obszarowe"),
        array("Illaoi", "Kultowa kapłanka", "Mocny i wytrzymały wojownik", "Posiada zdolności do walki wręcz i odrzucania wrogów"),
        array("Irelia", "Taniec potężnych ostrzy", "Zwinna i szybka wojowniczka", "Potrafi zadawać wielokrotne ciosy i unikać obrażeń"),
        array("Ivern", "Ludzkopodobne drzewo", "Mistrz przyrody", "Ma zdolności do przyzywania stworzeń leśnych i wspierania sojuszników"),
        array("Janna", "Strażniczka wiatru", "Mistrzyni wsparcia", "Ma zdolności do leczenia i ochrony sojuszników"),
        array("Jax", "Mistrz broni", "Zadaje duże obrażenia wręcz", "Może unikać ataków i zadawać potężne ciosy"),
        array("Jayce", "Młot i armatka energetyczna", "Mistrz form przemiany", "Potrafi walczyć zarówno w zwarciu, jak i na dystans"),
        array("Jhin", "Wirtuoz śmierci", "Mistrz snajperki", "Potrafi zadawać ogromne obrażenia z precyzją i stylowym wykończeniem"),
        array("Jinx", "Zabójcza maniak", "Szalona i pełna energii", "Zadaje ogromne obrażenia i szerzy chaos na polu bitwy"),
        array("Kaisa", "Początkująca", "Zdolna zabójczyni", "Potrafi zadawać obrażenia magiczne i fizyczne"),
        array("Kalista", "Wiedźma wrót", "Mistrzyni łuku", "Posiada zdolność do przysięgi i zemsty na wrogach"),
        array("Karma", "Wnioskodawczyni", "Mistyczna strażniczka", "Ma zdolności zarówno ofensywne, jak i defensywne"),
        array("Karthus", "Pogromca dusz", "Zadaje obrażenia obszarowe", "Potrafi przywoływać dusze zmarłych i kontrolować pole bitwy"),
        array("Kassadin", "Prześladowca pustki", "Zadaje obrażenia magiczne", "Ma zdolność do teleportacji i ograniczania mocy magii"),
        array("Katarina", "Niebezpieczna nożowniczka", "Mistrzyni szybkich ataków", "Potrafi zadawać ogromne obrażenia i przeżyć dłużej w walce"),
        array("Kayle", "Poświęcona obrończyni", "Potrafi zadawać obrażenia magiczne i fizyczne", "Może ewoluować swoje umiejętności w trakcie gry"),
        array("Kayn", "Cień Nieśmiertelności", "Potężny zabójca", "Ma zdolność do przemiany w mroczną lub czerwoną formę"),
        array("Kennen", "Błyskawiczny niewidzialny ninja", "Mistrz ataków obszarowych", "Potrafi paraliżować wrogów i zadawać duże obrażenia"),
        array("KhaZix", "Odlotowy łowca", "Potrafi zadawać duże obrażenia z zaskoczenia", "Może się wzmocnić poprzez zjadanie przeciwników"),
        array("Kindred", "Pary miłośników śmierci", "Potrafi zadawać obrażenia z dystansu", "Ma zdolność do zbierania dusz wrogich jednostek"),
        array("Kled", "Szalony jeździec", "Wytrzymały i agresywny wojownik", "Potrafi zadawać duże obrażenia i prowadzić frontalne ataki"),
        array("KogMaw", "Płomienne dziecko pustki", "Zadaje obrażenia magiczne i fizyczne", "Posiada zdolność do wybuchów kwasu i ataków z dystansu"),
        array("LeBlanc", "Manipulatorka iluzji", "Potrafi zadawać duże obrażenia i kontrolować wrogów", "Ma zdolność do wymiany miejsc z iluzją"),
        array("Leona", "Piękna paladynka", "Potrafi zadawać obrażenia i chronić sojuszników", "Ma zdolność do ogłuszania wrogów i kontrolowania pola bitwy"),
        array("Lillia", "Dziewczynka z drzewa", "Potrafi zadawać obrażenia obszarowe", "Posiada zdolność do zasypiania wrogów i kontrolowania tłumu"),
        array("Lissandra", "Korona Lodowej Czarownicy", "Zadaje obrażenia magiczne", "Może zamrażać wrogów i ochronić swoich sojuszników"),
        array("Lucian", "Zemsta Mrocznego Powstania", "Mistrz broni palnej", "Potrafi zadawać szybkie i celne ciosy z dystansu"),
        array("Lulu", "Pomocniczy stwór", "Mistrzyni wsparcia", "Ma zdolności do leczenia, osłabiania wrogów i wzmacniania sojuszników"),
        array("Lux", "Dama światła", "Potrafi zadawać obrażenia magiczne z dystansu", "Posiada zdolność do oślepiania i kontrolowania przeciwników"),
        array("Malphite", "Górzysty Strażnik", "Potężny tank", "Może zadawać ogromne obrażenia i chronić swoich sojuszników"),
        array("Malzahar", "Prorok Pustki", "Potrafi zadawać obrażenia magiczne", "Ma zdolność do kontrolowania wrogów i przyzywania voidlingów"),
        array("Maokai", "Żywotny drzewny strażnik", "Mocny i wytrzymały wojownik", "Może zadawać obrażenia obszarowe i kontrolować terytorium"),
        array("Mordekaiser", "Żelazny widmo", "Potężny mag bojowy", "Może kontrolować wrogów i zadawać duże obrażenia wręcz"),
        array("Morgana", "Upadła aniołka", "Mistrzyni magii ciemności", "Posiada zdolności do unieruchamiania wrogów i leczenia sojuszników"),
        array("Nami", "Uwieczniona fala", "Mistrzyni wsparcia", "Ma zdolności do leczenia, ochrony i kontrolowania przeciwników wodnymi czarami"),
        array("Nasus", "Król piasku", "Potężny wojownik", "Może rosnąć w siłę dzięki zdolności do zbierania mocy"),
        array("Nautilus", "Pogromca głębin", "Silny tank", "Potrafi unieruchamiać wrogów i chronić sojuszników"),
        array("Neeko", "Kameleon z wodospadu", "Potrafi się przeobrażać", "Może kontrolować wrogów i tworzyć iluzje"),
        array("Nidalee", "Polimorficzna łowczyni", "Mistrzyni przemiany", "Potrafi zadawać duże obrażenia z dystansu i w walce wręcz"),
        array("Nocturne", "Zmora z koszmarnego wymiaru", "Potężny zabójca", "Może ogłuszać wrogów i kontrolować mapę nocą"),
        array("Olaf", "Półbóg z północy", "Potężny wojownik", "Może zadawać duże obrażenia i zdolnością do odporności na kontrolę"),
        array("Orianna", "Dama zegara", "Mistrzyni kontrolowania obszaru", "Posiada zdolność do ochrony sojuszników i kontrolowania przeciwników"),
        array("Ornn", "Kowal demaskowany", "Silny tank", "Może tworzyć przedmioty dla sojuszników i kontrolować przeciwników"),
        array("Pantheon", "Artysta walki", "Potrafi zadawać duże obrażenia fizyczne", "Posiada zdolność do blokowania ataków i kontroli wrogów"),
        array("Poppy", "Strażniczka młota", "Mistrzyni tankowania", "Potrafi zadawać obrażenia i ochronić sojuszników przed atakami"),
        array("Pyke", "Zapomniany łowca", "Potężny zabójca", "Może niewidzialnie atakować wrogów i łapać ich w zasadzkach"),
        array("Qiyana", "Nadziana zwiadowczyni", "Potrafi zadawać obrażenia fizyczne", "Ma zdolność do manipulacji otoczeniem i kontrolowania obszaru"),
        array("Quinn", "Demacjańska skrytobójczyni", "Mistrzyni walki dystansowej", "Potrafi zadawać duże obrażenia i atakować z powietrza"),
        array("Rakan", "Wyuzdany tańczący szermierz", "Mistrz wsparcia", "Ma zdolności do leczenia sojuszników i kontrolowania przeciwników"),
        array("Rammus", "Kulisty obrońca", "Silny tank", "Potrafi zadawać obrażenia i odbijać ataki przeciwników"),
        array("RekSai", "Grobowiec mroku", "Potężny wojownik", "Może podziemnie atakować wrogów i odkrywać ich położenie"),
        array("Rell", "Żelazna walcząca wiedźma", "Silny tank", "Potrafi kontrolować przeciwników i chronić sojuszników"),
        array("Renekton", "Rozżarzony oprawca", "Potężny wojownik", "Może zadawać duże obrażenia i leczyć się podczas walki"),
        array("Rengar", "Bezlitosny łowca", "Potężny zabójca", "Ma zdolność do niewidzialności i szybkich ataków"),
        array("Riven", "Wygnana zabójczyni", "Mistrzyni walki wręcz", "Potrafi zadawać duże obrażenia i unikać ataków przeciwników"),
        array("Rumble", "Mechaniczny młot", "Mistrz walki z dystansu", "Posiada zdolności do kontrolowania przeciwników i zadawania obrażeń obszarowych"),
        array("Ryze", "Prorok run", "Potężny mag", "Może zadawać duże obrażenia magiczne i kontrolować przeciwników"),
        array("Samira", "Bezlitosna ocelotka", "Mistrzyni szybkich ataków", "Potrafi zadawać duże obrażenia i odblokować kombinacje ataków"),
        array("Sejuani", "Zimowa zapaśniczka", "Silny tank", "Może zadawać duże obrażenia i kontrolować przeciwników lodowymi atakami"),
        array("Senna", "Zatruta dusza", "Potrafi zadawać obrażenia z dystansu", "Ma zdolności do leczenia sojuszników i unieruchamiania wrogów"),
        array("Seraphine", "Uwodzicielka dźwięków", "Potrafi zadawać obrażenia magiczne i wspierać sojuszników", "Ma zdolność do leczenia i kontrolowania przeciwników"),
        array("Sett", "Niezłomny przywódca", "Silny wojownik wręcz", "Potrafi zadawać duże obrażenia i kontrolować przeciwników"),
        array("Shaco", "Szaleniec z nożem", "Potężny zabójca", "Może tworzyć iluzje i kontrolować przeciwników"),
        array("Shen", "Ochroniarz równowagi", "Silny tank i ochroniarz", "Ma zdolności do blokowania ataków i wspierania sojuszników"),
        array("Shyvana", "Półsmok", "Potężny wojownik", "Potrafi zadawać duże obrażenia i przekształcać się w smoka"),
        array("Singed", "Szalony alchemik", "Silny tank i truciciel", "Może zadawać obrażenia obszarowe i kontrolować przeciwników truciznami"),
        array("Sion", "Nieśmiertelny kolos", "Potężny tank", "Potrafi zadawać duże obrażenia i ożywać po śmierci"),
        array("Sivir", "Władczy krążnik", "Mistrzyni ataków dystansowych", "Potrafi zadawać obrażenia obszarowe i odbijać pociski"),
        array("Skarner", "Skorpion z Cyrstiowego Ostrosza", "Silny wojownik", "Ma zdolność do kontrolowania wrogów i zadawania obrażeń obszarowych"),
        array("Sona", "Dziewczyna z eterealnej harmonii", "Mistrzyni wsparcia", "Posiada zdolność do leczenia, wzmacniania i kontrolowania przeciwników"),
        array("Soraka", "Ozdrowicielka", "Mistrzyni wsparcia", "Może leczyć sojuszników i odblokować globalne leczenie"),
        array("Swain", "Mistrz południowej stronie", "Potężny mag i kontroler", "Potrafi zadawać obrażenia obszarowe i kontrolować wrogów"),
        array("Sylas", "Rewolucjonista", "Potężny mag bojowy", "Może kopiować zdolności innych championów i kontrolować wrogów"),
        array("Syndra", "Nieskrępowana władczyni", "Potężny mag", "Posiada zdolność do manipulacji obiektami i zadawania dużej ilości obrażeń"),
        array("Taliyah", "Północna łowczyni", "Mistrzyni kontrolowania obszaru", "Potrafi manipulować terenem i zadawać obrażenia obszarowe"),
        array("Talon", "Cienisty zabójca", "Potężny zabójca", "Ma zdolność do niewidzialności i szybkich ataków"),
        array("Taric", "Strażnik klejnotów", "Mistrz wsparcia i tankowania", "Potrafi leczyć sojuszników i wzmacniać ich obronę"),
        array("Teemo", "Zielony diabeł", "Mistrz pułapek i walki dystansowej", "Może stawiać trujące grzyby i atakować z ukrycia"),
        array("Thresh", "Śmiertelny gardziel", "Mistrz kontrolowania i łowienia wrogów", "Posiada zdolność do unieruchamiania i odbierania dusz przeciwnikom"),
        array("Tristana", "Yordle strzelczyni", "Mistrzyni ataków dystansowych", "Potrafi zadawać duże obrażenia i atakować z dużej odległości"),
        array("Trundle", "Król goblinów", "Silny wojownik i zabójca", "Może zadawać obrażenia, odzyskiwać życie i kontrolować przeciwników"),
        array("Tryndamere", "Król barbarzyńców", "Potężny wojownik", "Posiada zdolność do zadawania dużych obrażeń i unieruchamiania wrogów"),
        array("Twitch", "Szczurzątko", "Potężny zabójca", "Ma zdolność do niewidzialności i zadawania obrażeń obszarowych"),
        array("Udyr", "Strażnik duchów", "Silny wojownik i ochroniarz", "Posiada zdolność do przekształcania się i kontrolowania wrogów"),
        array("Urgot", "Męczennik z Noxusu", "Silny tank i zabójca", "Może zadawać duże obrażenia i kontrolować przeciwników"),
        array("Varus", "Strzelec kruka", "Mistrz ataków dystansowych", "Potrafi zadawać obrażenia obszarowe i kontrolować przeciwników"),
        array("Vayne", "Nocna łowczyni", "Potężna zabójczyni", "Ma zdolność do niewidzialności i szybkich ataków"),
        array("Veigar", "Mistrz ciemności", "Potężny mag", "Potrafi zadawać ogromne obrażenia i kontrolować przeciwników"),
        array("VelKoz", "Oko zagłady", "Potężny mag i kontroler", "Może zadawać duże obrażenia obszarowe i rozpraszac wrogów"),
        array("Vi", "Siła Piltover", "Silny wojownik i łamacz", "Posiada zdolności do szybkich ataków i kontrolowania wrogów"),
        array("Viktor", "Pojedynkujący geniusz", "Potężny mag i kontroler", "Może manipulować technologią i zadawać obrażenia obszarowe"),
        array("Vladimir", "Krwiopijca", "Potężny mag i samouk", "Ma zdolność do leczenia i zadawania obrażeń magicznych"),
        array("Volibear", "Nieustępliwy burzobójca", "Silny tank i zabójca", "Potrafi zadawać duże obrażenia i kontrolować przeciwników"),
        array("Warwick", "Krwiożerczy łowca", "Silny wojownik i zabójca", "Może zadawać duże obrażenia i śledzić wrogów"),
        array("Wukong", "Król małp", "Silny wojownik i oszust", "Posiada zdolność do kamuflażu i zadawania dużych obrażeń"),
        array("Xayah", "Buntownicza wzbawiona", "Mistrzyni ataków dystansowych", "Potrafi zadawać duże obrażenia i kontrolować przeciwników"),
        array("Xerath", "Potężne istnienie energii", "Potężny mag i artylerzysta", "Może zadawać ogromne obrażenia z dużej odległości"),
        array("Yasuo", "Nieustraszony samuraj", "Potężny zabójca", "Posiada zdolność do zadawania dużych obrażeń i unikania ataków"),
        array("Yone", "Niepokorny duch", "Potężny zabójca", "Może zadawać duże obrażenia i kontrolować przeciwników"),
        array("Yorick", "Pastuch dusz", "Silny wojownik i pusher", "Potrafi przyzywać sługi i kontrolować przeciwników"),
        array("Zac", "Błękitna maszyna", "Silny tank i ochroniarz", "Posiada zdolność do rozpryskiwania się i kontrolowania przeciwników"),
        array("Zed", "Mistrz cienia", "Potężny zabójca", "Może zadawać duże obrażenia i manipulować cieniami"),
        array("Ziggs", "Pycha Piltovru", "Potężny mag i niszczyciel wież", "Potrafi zadawać obrażenia obszarowe i burzyć wieże"),
        array("Zilean", "Strażnik czasu", "Mistrz wsparcia i kontroler", "Ma zdolność do manipulacji czasem i leczenia sojuszników"),
        array("Zoe", "Aspekty lunari", "Potężny mag i kontroler", "Potrafi zadawać duże obrażenia i kontrolować przeciwników"),
        array("Zyra", "Rozkwitający groźba", "Potężny mag i kontroler", "Posiada zdolność do manipulacji roślin i zadawania obrażeń obszarowych"),
        array("Zilean", "Strażnik czasu", "Mistrz wsparcia i kontroler", "Ma zdolność do manipulacji czasem i leczenia sojuszników"),
        array("Viego", "Zniszczony król", "Oszalał po śmierci żony", "Potężny upiór"),
        array("Gwen", "Uszyta laleczka", "Może cię szybko skroić", "Mglista krawczyni"),
        array("Akshan", "Zbuntowany strażnik", "Latający murzyn na lince", "Bumerang Mściciela"),
        array("Vex", "Ponuraczka", "Skrzywdzona smutna yordlka", "Królowa Cienia"),
        array("Zeri", "Iskierka Zaun", "Żywa bateria, która elektryzuje otoczenie", "Jest w gorącej wodzie kąpana"),
        array("BelVeth", "Cesarzowa pustki", "Nie do zabicia jak użyje E", "Lawendowa Śmierć"),
        array("Nilah", "Nieokiełznana radość", "W otoczeniu sojuszników czuje sie jak ryba w wodzie", "Jak ci pierdyknie biczem to uciekaj"),
        array("KSante", "Czarny ziomuś z tarczami", "Obrońca i drapieżnik", "Duma Nazumah"),
        array("Milio", "Łagodny płomień", "Chłopczyk z supporta", "Ma fajną piłeczke")

    );
    foreach ($data as $row) {
        $championName = $row[0];
        $championHint1 = $row[1];
        $championHint2 = $row[2];
        $championHint3 = $row[3];

        $insertStatement = "INSERT INTO CHAMPIONS (CHAMPION_NAME, CHAMPION_HINT1, CHAMPION_HINT2, CHAMPION_HINT3) VALUES ('$championName', '$championHint1', '$championHint2', '$championHint3')";

        $conn->exec($insertStatement);

    }
}




?>

