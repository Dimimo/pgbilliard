<div class="text-justify">
    <div class="mb-4">
        De hoofdpagina en de eerste pagina die je ziet wanneer je naar de website gaat of inlogt.
        Het spreekt voor zich als je weet waar je naar kijkt. Iedereen kan deze pagina trouwens
        bekijken, of je nu ingelogd bent of niet.
    </div>
    <div class="mb-4">
        Elk team verschijnt twee keer. Eerst in de ranglijst, daarna in je laatste wedstrijd. Thuis-
        en uitstatus zijn niet relevant! Bekijk
        <a
            class="text-blue-800 hover:text-blue-600 hover:underline"
            href="{{ route('calendar') }}"
            wire:navigate
        >
            de Kalender
        </a>
        voor de details van je dagelijkse wedstrijden.
    </div>
    <div class="mb-4">
        De ranglijst wordt bepaald door (1) alfabetische volgorde, (2) je dagelijkse overwinningen,
        (3) het aantal gewonnen individuele wedstrijden versus (4) het aantal verloren individuele
        wedstrijden. Verloren dagelijkse wedstrijden zijn niet relevant voor de samenstelling van de
        ranglijst.
    </div>
    <div class="mb-4">
        Teams die de finale niet hebben gehaald, worden negatief beïnvloed door het percentage EN
        het aantal wedstrijden. Dit is om te voorkomen dat de nummer 3 een hoger percentage kan
        hebben dan de nummer 2.
    </div>
    <div class="mb-4">
        Team- en individuele overwinningen zijn van invloed op de score. Om 100% te halen, moet je
        elke wedstrijd met de maximale score van 15/0 winnen.
    </div>
    <div class="mb-4">
        <x-svg.percent-solid color="fill-indigo-500" size="5" />
        wordt als volgt berekend (waarbij TG = totaal aantal wedstrijden, inclusief halve finales en
        finales)
        <div class="m-4 text-center font-mono">
            <math xmlns="http://www.w3.org/1998/Math/MathML">
                <mrow>
                    <mfrac>
                        <mrow>
                            <mfrac>
                                <mtext>{{ __('Games Won') }}</mtext>
                                <mtext>{{ __('Total Games') }}</mtext>
                            </mfrac>
                            <mo>&times;</mo>
                            <mn>100</mn>
                            <mo>+</mo>
                            <mfrac>
                                <mtext>{{ __('Individual Games Won') }}</mtext>
                                <mrow>
                                    <mtext>{{ __('Total Games') }}</mtext>
                                    <mo>&times;</mo>
                                    <mn>15</mn>
                                </mrow>
                            </mfrac>
                            <mo>&times;</mo>
                            <mn>100</mn>
                        </mrow>
                        <mn>2</mn>
                    </mfrac>
                    <mo>&times;</mo>
                    <mtext>factor</mtext>
                </mrow>
            </math>
        </div>
    </div>
    <div class="mb-4">
        De
        <span class="font-bold">factor</span>
        De factor heeft alleen invloed op de finalisten. De winnaar krijgt een factor van 1,3 of 30%
        extra op het percentage. De nummer twee krijgt 15% extra. Alle andere teams krijgen een
        factor van 1. Reden? In vorige seizoenen was het mogelijk dat de nummer drie eindigde met
        een beter percentage dan de nummer twee...
    </div>
    <div class="mb-4">
        BYE-wedstrijden worden niet meegenomen in berekeningen, omdat ze niet als wedstrijd worden
        beschouwd.
    </div>
    <div class="mb-4">
        Als 2 teams dezelfde scores behalen (dagelijks + individueel), wordt de rangschikking
        alfabetisch bepaald. Bij de berekening wordt geen rekening gehouden met onderlinge
        wedstrijdresultaten. Als dit het geval is, verwijzen we u naar
        <a
            class="font-bold text-blue-800 hover:text-blue-600 hover:underline"
            href="{{ route('forum.posts.index') }}"
            wire:navigate
        >
            ons Forum
        </a>
        waar we over alles kunnen praten (vervangt Facebook).
    </div>
    <div class="mb-4">
        Last but not least: de symbolen.
        <span class="font-bold">Sommige kolommen kunnen op uw apparaat verborgen zijn.</span>
        Dit hangt af van de breedte van uw scherm. Het is een tabel en tabellen hebben hun onhandige
        beperkingen. Last but not least, the symbols.
    </div>
    <div class="mb-4">
        <span class="font-bold">
            De site is in de eerste plaats gebouwd voor mobiele apparaten.
        </span>
        In de tabel worden sommige kolommen
        <span class="font-bold">weggelaten</span>
        (
        <x-svg.minus-solid color="fill-red-700" size="5" padding="-mr-1" />
        ) op kleinere apparaten, maar wel
        <span class="font-bold">zichtbaar</span>
        op grotere schermen (
        <x-svg.plus-solid color="fill-green-700" size="5" padding="-mr-1" />
        ).
        <span class="text-sm">
            De breedte van de schermen is: extra klein (xs) < 640px, klein (sm) > 640px, middelgroot
            (md) > 768px, groot (lg) >1024px.
        </span>
    </div>
    <table class="table-auto border-separate">
        <thead>
            <tr>
                <th class="h-12 w-12 border border-indigo-400 bg-indigo-50 px-2 text-center">
                    <x-svg.circle-question-regular color="fill-gray-600" size="5" />
                </th>
                <th class="h-12 w-auto border border-indigo-400 bg-indigo-50 px-2 text-left">
                    Explanation
                </th>
                <th class="h-12 w-12 border border-indigo-400 bg-indigo-50 px-2 text-center">xs</th>
                <th class="h-12 w-12 border border-indigo-400 bg-indigo-50 px-2 text-center">sm</th>
                <th class="h-12 w-12 border border-indigo-400 bg-indigo-50 px-2 text-center">md</th>
                <th class="h-12 w-12 border border-indigo-400 bg-indigo-50 px-2 text-center">lg</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                    <x-svg.circle-info-solid color="fill-green-600" size="5" />
                </td>
                <td class="h-12 w-auto border border-gray-300 p-2">
                    Rangschikking, laatste spel en score (check
                    <a
                        class="text-blue-800 hover:text-blue-600 hover:underline"
                        href="{{ route('calendar') }}"
                        wire:navigate
                    >
                        de Kalender
                    </a>
                    voor details)
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
            </tr>
            <tr>
                <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                    <x-svg.list-ul-solid color="fill-gray-400" size="5" />
                </td>
                <td class="h-12 w-auto border border-gray-300 p-2">
                    {{ __('Individual Games and Results') }}
                    <x-svg.eye-regular color="fill-sky-600" size="5" padding="ml-2 mb-1" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
            </tr>
            <tr>
                <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                    <x-svg.thumbs-up-solid color="fill-green-600" size="5" />
                </td>
                <td class="h-12 w-auto border border-gray-300 p-2">
                    Het aantal gewonnen wedstrijden (8 of hoger is een win)
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
            </tr>
            <tr>
                <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                    <x-svg.thumbs-down-solid color="fill-red-600" size="5" />
                </td>
                <td class="h-12 w-auto border border-gray-300 p-2">
                    Het aantal verloren wedstrijden (7 or lower)
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
            </tr>
            <tr>
                <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                    <x-svg.square-plus-solid color="fill-green-600" size="5" />
                </td>
                <td class="h-12 w-auto border border-gray-300 p-2">
                    Het aantal individueel gewonnen spelletjes, inclusief doubles
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
            </tr>
            <tr>
                <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                    <x-svg.square-minus-solid color="fill-orange-500" size="5" />
                </td>
                <td class="h-12 w-auto border border-gray-300 p-2">
                    Het aantal individueel verloren spelletjes
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
            </tr>
            <tr>
                <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                    <x-svg.percent-solid color="fill-indigo-500" size="5" />
                </td>
                <td class="h-12 w-auto border border-gray-300 p-2">
                    Percentage gebaseerd op daguitkomst en individuele spelletjes
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
            </tr>
            <tr>
                <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                    <x-svg.champagne-glasses-solid color="fill-blue-800" size="5" />
                </td>
                <td class="h-12 w-auto border border-gray-300 p-2">
                    Het aantal gespeelde wedstrijden
                    <span class="italic">(inclusief no-show)</span>
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
            </tr>
        </tbody>
    </table>
</div>
