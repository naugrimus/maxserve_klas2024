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


    
