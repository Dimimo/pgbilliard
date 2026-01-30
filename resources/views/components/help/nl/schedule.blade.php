<div class="text-justify">
    <div class="mb-4">
        Wanneer je
        <span class="font-bold">creëer het dagoverzicht</span>
        , kunt u het dagelijkse individuele dagoverzicht starten.
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">Het overzicht van het dagoverzicht</div>
        </div>
        <div class="m-4 flex justify-center">
            <img src="{{ secure_url('/images/schedule/day_score_ready.png') }}" alt="" />
        </div>
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">
                Als je de link volgt, krijg je 2 opties: het ‘oude’ en het ‘nieuwe’ dagelijkse
                schema.
            </div>
        </div>
        <div class="m-4 flex flex-col justify-center space-y-2">
            <img src="{{ secure_url('/images/schedule/new_schedule.png') }}" alt="" />
            <img src="{{ secure_url('/images/schedule/old_schedule.png') }}" alt="" />
        </div>
    </div>

    <div class="mb-4">
        Maak je keuze, je kunt nu je teamleden invoeren. De geselecteerde spelers zullen de
        individuele wedstrijden één voor één invullen. Je kunt elke wedstrijd later nog wijzigen.
        <span class="font-bold">
            Zorg er gewoon voor dat spelers niet tegen dezelfde tegenstander spelen.
        </span>
        zoals voordien.
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">
                Selecteer uw teamleden één voor één, zoals u op papier hebt gedaan.
            </div>
        </div>
        <div class="m-4 flex justify-center">
            <img src="{{ secure_url('/images/schedule/home_team_select.png') }}" alt="" />
        </div>
    </div>

    <div class="mb-4 text-lg text-red-700">
        Als je geselecteerde spelers verplaatst, is er een bug. Je zou dit bijvoorbeeld kunnen zien.
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">
                Controleer voordat u de eerste score toevoegt of deze afwijking zich voordoet.
            </div>
        </div>
        <div class="m-4 flex justify-center">
            <img src="{{ secure_url('/images/schedule/bug_doubles.png') }}" alt="" />
        </div>
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">
                Er is een eenvoudige oplossing: klik onder uw team op ‘Het schema resetten’ en voer
                de spelers gewoon opnieuw in.
            </div>
        </div>
        <div class="m-4 flex justify-center">
            <img src="{{ secure_url('/images/schedule/rest_schedule_button.png') }}" alt="" />
        </div>
    </div>

    <div class="mb-4">
        Het overzicht van de individuele wedstrijden zou er ongeveer zo uit moeten zien:
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">
                De eerste ronde, de 15e (3e dubbel), wordt zoals verwacht leeg gezet.
            </div>
        </div>
        <div class="m-4 flex flex-col justify-center space-y-2">
            <img src="{{ secure_url('/images/schedule/first_round_example.png') }}" alt="" />
            <img src="{{ secure_url('/images/schedule/last_doubles_empty.png') }}" alt="" />
        </div>
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500">
            <div class="rounded-t-lg bg-green-100 p-4">
                Nadat je de eerste score hebt ingevoerd (in dit geval Helen - Rhea), worden de
                keuzemogelijkheden in de vervolgkeuzelijst van de spelers vergrendel
                <br />
                <span class="font-bold">
                    Als je niet zeker weet of een reserve zal verschijnen, voeg de speler dan toch
                    toe! Je kunt de geselecteerde spelers niet meer wijzigen nadat de wedstrijd is
                    begonnen.
                </span>
            </div>
        </div>
        <div class="m-4 flex justify-center">
            <img src="{{ secure_url('/images/schedule/selected_players_locked.png') }}" alt="" />
        </div>
    </div>
</div>
