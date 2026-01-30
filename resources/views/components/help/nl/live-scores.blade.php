<div class="text-justify">
    <div class="mb-4">
        Op
        <a href="{{ route('calendar') }}" class="link inline-block text-blue-800" wire:navigate>
            de Kalender
        </a>
        kunt u elke gewenste datum selecteren. Er worden u 3 mogelijkheden aangeboden:
    </div>

    <div class="mb-4">
        <ul class="list-inside list-disc">
            <li>
                een datum
                <span class="font-bold">uit het verleden</span>
                toont u de eindscore en een link naar de individuele resultaten van het dagprogramma
            </li>
            <li>
                een datum
                <span class="font-bold">in de toekomst</span>
                geeft u de resterende tijd tot het ‘venster’ opengaat
            </li>
            <li>
                het
                <span class="font-bold">‘tijdvenster’ is open</span>
                , de wedstrijden staan op het punt te beginnen of zijn al begonnen
            </li>
        </ul>
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">
                Het kalenderdagoverzicht ingesteld op de toekomst
            </div>
        </div>
        <div class="m-4 flex justify-center">
            <img src="{{ secure_url('/images/schedule/day_score_future.png') }}" alt="" />
        </div>
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">
                Het kalenderdagoverzicht op de dag dat we spelen van
                {{ \App\Constants::DATEFORMAT_START }}h tot {{ \App\Constants::DATEFORMAT_END }}h
            </div>
        </div>
        <div class="m-4 flex justify-center">
            <img src="{{ secure_url('/images/schedule/day_score_ready.png') }}" alt="" />
        </div>
    </div>

    <div class="mb-4">
        Als je voor een team speelt, heb je toegang tot het spel waaraan je deelneemt. Elke speler
        kan de scores van het spel bijwerken. In dit geval kan het spel
        <span class="font-bold">Pirata Galleon - Victoria</span>
        worden bijgewerkt. De andere spellen
        <span class="font-bold">zijn nog niet begonnen.</span>
    </div>

    <div class="mb-4 rounded-lg border-2 border-green-700 bg-green-100 p-4">
        Elke voltooide individuele wedstrijd
        <span class="italic">voltooide individuele spel</span>
        is zichtbaar in het scorebord, de kalender, het dagoverzicht EN de “Schema's van de dag”.
        <span class="font-bold">
            U hoeft niet te verversen. Score-updates worden onmiddellijk weergegeven.
        </span>
    </div>

    <div class="mb-4">
        Wanneer de wedstrijden daadwerkelijk worden gespeeld, zie je een link op
        <a href="{{ route('scoreboard') }}" class="link inline-block text-blue-800" wire:navigate>
            het Scorebord
        </a>
        and on
        <a href="{{ route('calendar') }}" class="link inline-block text-blue-800" wire:navigate>
            de Kalender
        </a>
        als
        <span class="font-bold">Live Scores.</span>
    </div>

    <div class="mb-4">
        <span class="font-bold">Vanaf nu moet je ingelogd zijn om een score te wijzigen.</span>
        Iedereen kan tijdens
        <span class="italic">de openingstijden</span>
        van {{ \App\Constants::DATEFORMAT_START }}h tot {{ \App\Constants::DATEFORMAT_END }}h
        scores invoegen van de wedstrijd waaraan je deelneemt.
    </div>

    <div class="mb-4">
        <span class="font-bold">Er is een logische hiërarchie:</span>
        <div class="m-4">
            <div class="mb-2">
                <span class="font-bold">Beheerders:</span>
                toegang tot alle wedstrijden
                <span class="font-semibold">behalve</span>
                bevestigde wedstrijden, deze zijn onveranderlijk
            </div>
            <div class="mb-2">
                <span class="font-bold">Bareigenaren:</span>
                unnen de scores wijzigen van elk team dat voor de bar speelt
            </div>
            <div class="mb-2">
                <span class="font-bold">Aanvoerders en spelers:</span>
                kunnen alleen de wedstrijd wijzigen waarbij ze betrokken zijn
            </div>
            <div>
                <span class="font-bold">Bezoekers of niet-spelers:</span>
                alleen lezen
            </div>
        </div>
        <div>
            Let op: als u toegang hebt tot een wedstrijd die bezig is, hebt u toegang tot zowel de
            thuis- als de bezoekende score.
        </div>
    </div>

    <div class="mb-4">
        <span class="font-bold">
            Wat is de
            <span class="text-lg text-blue-800">bevestigingsknop</span>
            ?
        </span>
        <div class="ml-4">
            Deze verschijnt wanneer het spel 15 wedstrijden telt. Het is een soort trigger. Het
            geeft aan dat het spel is afgelopen en dat de score definitief is. De wedstrijd Pirata -
            Geriatric is bevestigd. De wedstrijd Kickass - Victoria nog niet.
            <div class="mb-2">Er verschijnt een bevestigingsvenster. Voor de zekerheid.</div>
            <div class="mb-2">
                Wanneer de laatste wedstrijd is bevestigd,
                <span class="font-bold">
                    krijgen alle deelnemende spelers een e-mail met de dagresultaten.
                </span>
            </div>
            <div class="mb-2">
                <span class="font-bold">Zoals altijd worden:</span>
                <a
                    href="{{ route('scoreboard') }}"
                    class="link inline-block text-blue-800"
                    wire:navigate
                >
                    het scorebord
                </a>
                en
                <a
                    href="{{ route('calendar') }}"
                    class="link inline-block text-blue-800"
                    wire:navigate
                >
                    de kalender
                </a>
                onmiddellijk bijgewerkt.
            </div>
        </div>
    </div>

    <div class="mb-4 font-bold">
        Bevestigde wedstrijden kunnen door niemand worden gewijzigd, zelfs niet door beheerders.
    </div>

    @if (session('is_admin'))
        <div class="mb-4 rounded-lg border-2 border-indigo-700 text-center">
            <div class="mb-4 border-b border-indigo-700 font-bold">
                <div class="rounded-t-lg bg-indigo-100 p-4">Alleen voor beheerders</div>
            </div>
            <div class="mb-4">
                <div class="mb-2">
                    Als beheerder kun je de score nog steeds rechtstreeks wijzigen, net als
                    voorheen.
                </div>
                <div class="mb-2">
                    De reden? In geval van een
                    <span class="font-bold">no-show (8-0)</span>
                    . Er zijn geen dagelijkse individuele scores beschikbaar, omdat die er niet
                    zijn.
                </div>
            </div>
            <div class="w-full rounded-lg border border-gray-500 bg-white p-2 text-center">
                <div class="my-2 font-bold">
                    Wat een beheerder ziet wanneer de wedstrijd
                    <span class="font-bold">nog niet is bevestigd</span>
                </div>
                <img
                    src="{{ secure_url('/images/schedule/admin_direct_score_overview.png') }}"
                    alt=""
                />
            </div>
        </div>
    @endif
</div>
