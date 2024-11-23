# Klas van 2024 maxserve werkzaamheden

## composer geinstalleerd via Dockerfile
    mogelijk niet de juiste plek, maar ik werk altijd met een composer in de container, 
    om te voorkomen dat ik in problemen raak met meerdere projecten.

## github projectje opgezet
    lijkt me logisch

## Doctrine geinstalleerd 
    database naam en credentials aangepast. Deze waren wel heel algemeen

## Entities en migratie
    eerste entities met koppeltabellen aangemaakt aaan de hand van de json.
    Daarnaast de eerste migratie gemaakt, ook een unique index op product title zodat je daar later op kan zoeken.
    Overige indexen moeten ook maar dat kan ik later als ik met de implementatie aan de gang ga wel doen.

## issues met development omgeving
    Om een of andere reden werkte WSL2 spontaan niet meer en dus docker desktop ook niet meer
    De services voor WSL werden ook niet meer gestart na reboot
    dcker desktop verwijderd, wsl geupdate
    aantal keer moeten rebooten
    Docker desktop weer kunnen installeren
    alles geupdate
    en spontaan werkt alles weer


## api client
    API client gemaakt, met aanpasbare config parameter.
    alvast het command gemaakt en php unit geinstalleerd.
    Of ik php uit ga gebruiken weet ik nog niet zeker, wellicht om de factory te testen.

## Importer
    Hier en daar entities verbeterd
    factories gemaakt
    omdat de hoeveelheid parameters aan het command te groot kon worden, een entitie fctory gemaakt
    
## Frontend
    Twig geinstalleerd
    Twig filters geinstallleeerd
    DockerFile ivm int aangepast, zodat ik money_format kan gebruiken in twig
    pagination (pagerfanta) toegepast

## Apache rewrites en Docker
    Even bezig geweest om rewrites te doen met apache
    Om een of andere maniet werkte de .htccess file niet
    uiteindelijk opgelost om de base .conf uit te breiden met <Directory> Block en deze
    te kopieren naar de juiste locatie op de server

## Frontend detail pagina
    spreekt voor zich

## Sortering en filtering toegevoegd
    Ik wil later nog een macro maken in twig, in de zin van don't repeat your self. Voor nu werkt het netjes
    Met de nieuwe #[MapQueryParameter] goed opletten, als de waardes in GET leeg zijn, dan werkt dat niet goed
    dus altijd zorgen dat die gevuld zijn.
    Mocht iemand ze met de hand aan passen, dan werkt dus de applicatie niet helemaal lekker. Dt nog eens uitzoeken

## product images
    Er is een keuze te maken of je de images lokaal wilt hosten of niet.
    Aangezien je geen gebruik wilt maken van de data van de leverancier, is het dus goed mogelijk dat je ook geen gebruik wilt maken van CDN van de leveancier.
    In dat geval kan je er dus voor kiezen om de images lokaal te hosten

    Ik heb nagedacht over het gebruik van FlySystem. Ik heb daar van afegzien omdat dat niks zegt over programmeer skills,
    maar meer over het configureren van een module. Dat valt nu buiten de scope, maar zou een leuke
    toevoeging kunnen zijn.

## rewrite command
    Ik zag dat het command veel te groot werd, dus besloten om deze naar een service te verleggen.
    Dat ziet er netter uit. Daarnaast kan je nu de url en of je gebruik wilt maken van lokale images meegeven aan de functie.
    Hierdoor hoeft Symfony style ook niet meer gebuikt te worden tijdens de import.
    Veel Beter zo !!!




    
