<div class="text-justify">
    <div class="mb-4 border-2 border-yellow-500 bg-yellow-100 p-4">
        <span class="font-bold">Disclaimer:</span>
        Tijdens de kapiteinsvergadering van 5 maart 2025 is overeengekomen dat het maximum aantal
        spelers dat per team is toegestaan, is beperkt tot
        <span class="font-bold">{{ \App\Constants::MAX_TEAM_PLAYERS }}</span>
        .
    </div>
    <div class="mb-4">
        In eerste instantie zul je deze pagina saai vinden. Maar hij is eigenlijk heel interessant
        en
        <span class="font-bold">belangrijk voor bareigenaren en kapiteins</span>
        .
    </div>
    <div class="mb-4">Een woordje uitleg...</div>
    <div class="mb-4">
        <span class="font-bold">Teams en waar ze spelen</span>
        zijn duidelijk. Het getal ernaast is het aantal spelers dat aan het team is toegevoegd. In
        de toekomst moet dat er minstens 4 zijn.
    </div>
    <div class="mb-4">
        Tot slot, de Captain en het contactnummer. Als de Captain niet is ingesteld of de Captain
        het contactnummer niet heeft ingevuld, is het fall-back nummer dat u ziet dat van de
        bareigenaar. Als u een datum moet verzetten of later bent dan verwacht, vindt u op deze
        pagina wie u moet contacteren.
    </div>
    <div class="mb-4 font-bold">
        Om begrijpelijke redenen zijn alle telefoonnummers verborgen voor bezoekers. Om een
        contactnummer te kunnen zien, moet u .
        <a href="{{ route('login') }}" class="link inline-block text-blue-800" wire:navigate>
            ingelogd zijn
        </a>
        !
    </div>
    <div class="font-bold">Bareigenaren en Kapiteins</div>
    <div class="mb-4">
        Barhouders en aanvoerders kunnen een
        <x-svg.pen-to-square-solid color="fill-blue-600" size="4" />
        teken naast sommige namen zien staan. Dit betekent dat je toegang hebt om te wijzigen wat
        eronder staat. Voor barhouders is dat de informatie over de bar, het team of de teams en de
        spelers van het team of de teams. Inclusief wie je als aanvoerder wilt aanstellen. Het
        aanstellen van de teams zelf wordt gedaan door een beheerder, omdat dit deel uitmaakt van
        het schema in het huidige seizoen.
    </div>
    <div class="font-bold">Kapteins</div>
    <div class="mb-4">
        Aanvoerders (en bareigenaren) kunnen toevoegen wie er in het team speelt. Ik heb het zo
        eenvoudig mogelijk gemaakt. Lees gewoon de instructies op de pagina als je vragen hebt. Een
        foutje is overigens heel gemakkelijk ongedaan te maken. Behalve... als je jezelf als
        aanvoerder verwijdert... Nou, je krijgt een waarschuwing voordat je dat doet. Het
        verwijderen van een teamspeler geeft ook een waarschuwing. Hoe dan ook, het is gemakkelijk
        om spelers toe te voegen of te verwijderen.
    </div>
    <div class="mb-4">
        <span class="font-bold">
            Spelers die al in een ander team zitten, kunnen niet worden geselecteerd.
        </span>
        Als de speler nieuw is en niet in de database staat, voeg dan gewoon een nieuwe speler toe.
        Namen moeten uniek zijn. Er wordt een waarschuwing gegeven als de naam al in gebruik is. Na
        het aanmaken van een nieuwe gebruiker ontvangt u een e-mail met de gegevens die uw nieuwe
        teamlid nodig heeft om in te loggen en zijn of haar inloggegevens te wijzigen.
    </div>
    <div class="mb-4 border-2 border-gray-500 bg-gray-100 p-4">
        <div class="mb-2 font-bold">Spelers die vertrekken of naar een ander team overstappen</div>
        <div class="mb-2">
            Als een speler vertrekt en niet terugkomt (bijvoorbeeld omdat zijn vakantie voorbij is)
            OF als een speler naar een ander team wil overstappen,
            <span class="font-bold">kun je de speler veilig uit de lijst verwijderen</span>
            . Dit heeft GEEN invloed op eerdere wedstrijden.
        </div>
        <div class="mb-2">
            <span class="font-bold">Hoe werkt het onder de motorkap??</span>
            De speler wordt
            <span class="italic">gedeactiveerd</span>
            . Hij/zij blijft in de competitie, maar is niet langer aan een team verbonden. Als de
            speler terugkomt OF van team wisselt, wordt de status van de speler dienovereenkomstig
            bijgewerkt.
        </div>
        <div class="mb-2">
            <span class="font-bold">Voor Kapiteins:</span>
            Een speler die is gedeactiveerd, kan worden uitgenodigd voor elk team.
        </div>
        <div>
            De status van een speler OF een team heeft geen invloed op
            <a href="{{ route('rank') }}" class="link inline-block text-blue-800" wire:navigate>
                het individueel scorebord
            </a>
            .
        </div>
    </div>
    <div class="mb-6">
        Dat is het! Cheerio en
        <span class="font-bold">Have Fun!</span>
    </div>
</div>
