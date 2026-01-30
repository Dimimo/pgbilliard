<div class="text-justify">
    <div class="mb-4">
        De Kalender geeft een overzicht van het huidig Seizoen. Wanneer en waar je speelt. Simpel.
        Met de resultaten van gespeelde dagen,
        <a
            class="font-bold text-blue-800 hover:text-blue-600 hover:underline"
            href="{{ route('scoreboard') }}"
            wire:navigate
        >
            wat de huidige positie van uw team bepaalt.
        </a>
    </div>
    <div class="mb-4">
        Winnende teams
        <span class="font-bold">zijn vet gedrukt.</span>
        Indien je aangemeld bent en meespeelt in het huidig Seizoen, the team waarvoor je speelt
        <span class="bg-green-50 p-1">heeft een lichtgroene achtergrond.</span>
    </div>
    <div class="mb-4">
        Klik op de achtergrond van een ander team om het
        <span class="bg-green-50 p-1">dezelfde lichtgroene achtergrond</span>
        te geven.
    </div>
    <div class="mb-4 font-bold">
        Als een thuis team voor één of andere reden in een andere bar speelt, wordt de naam van de
        bar If, for some reason, your team doesn't play home, the bar (or Venue) will be shown right
        under it.
        <span class="text-red-700">in het rood weergegeven</span>
        , om het verschil duidelijk te maken.
    </div>
    <div class="mb-4 rounded-lg border border-gray-300 bg-gray-50 p-2">
        <span class="font-bold">Een herinnerings-email</span>
        wordt verstuurd de dag voor het evenement. Indien je geen email ontvangt kan het zijn dat:
        <div class="mb-2 list-inside list-decimal">
            <div class="list-item">jouw account niet opgeëist is</div>
            <div class="list-item">je het verkeerde email adres opgegeven hebt</div>
            <div class="list-item">Ormeco</div>
            <div class="list-item">
                <a
                    class="text-blue-800 hover:text-blue-600 hover:underline"
                    href="{{ route('teams.index') }}"
                    wire:navigate
                >
                    je in geen team speelt
                </a>
            </div>
        </div>
        <div>
            Indien het laatst waar is, neem contact op met de bar eigenaar of de kapitein van uw
            team. Zij kunnen je toevoegen.
        </div>
    </div>
    <div class="mb-4">Speciale data hebben een subtitel. Gewoonelijk de (semi) finale.</div>
    <div class="mb-4">
        Een week kan overgeslaan worden wegens feestdagen of uitzonderlijke omstandigheden, zoals
        een tyfoon.
    </div>
    <div class="mb-4">
        Je hebt het misschien al gemerkt: ieder team heeft zijn eigen pagina. Klik op de naam. Je
        krijgt een overzicht van de kalender en de scores van voorbije speeldagen.
    </div>
    <div>
        Dat is het! Cheerio en
        <span class="font-bold">Beleef Plezier!</span>
    </div>
</div>
