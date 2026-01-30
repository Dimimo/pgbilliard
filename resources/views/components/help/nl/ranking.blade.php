<div class="text-justify">
    <div class="mb-4 font-bold">
        <span class="underline">Disclaimer:</span>
        deze functie is eindelijk uit de bètafase en wordt als voltooid beschouwd.
    </div>
    <div class="mb-4">
        Aangezien het gedetailleerde scorebord nu in de database wordt opgeslagen, is het mogelijk
        om een individueel scoreblad op te stellen.
    </div>
    <div class="mb-4">
        <span class="font-bold">Een dubbelspel</span>
        resulteert in een overwinning (of verlies) van 2 spelers. De ranglijst maakt geen
        onderscheid tussen enkelspel en dubbelspel.
    </div>
    <div class="mb-4">
        <span class="font-bold">Van team wisselen</span>
        heeft geen invloed op individuele prestaties. Het enige dat verandert, is de huidige
        teamnaam.
    </div>
    <div class="mb-4 font-bold">Een woordje uitlet:</div>
    <div class="mb-4">
        <div class="h-12 w-12 flex-none">
            <x-svg.percent-solid color="fill-indigo-500" size="5" />
        </div>
        <div class="flex-1">
            <div>Het percentage wordt als volgt berekend</div>
            <div class="m-4">
                <math xmlns="http://www.w3.org/1998/Math/MathML">
                    <mrow>
                        <mo>(</mo>
                        <mfrac>
                            <mtext>{{ __('Games Won') }}</mtext>
                            <mtext>{{ __('Total Games') }}</mtext>
                        </mfrac>
                        <mo>)</mo>
                        <mo>
                            <x-svg.xmark-solid color="fill-black" size="4" padding="mt-1" />
                        </mo>
                        <mo>(</mo>
                        <mfrac>
                            <mtext>{{ __('Days Participated') }}</mtext>
                            <mtext>{{ __('Max Playing Days') }}</mtext>
                        </mfrac>
                        <mo>)</mo>
                        <mo>
                            <x-svg.xmark-solid color="fill-black" size="4" padding="mt-1" />
                        </mo>
                        <mn>100</mn>
                    </mrow>
                </math>
            </div>
        </div>
    </div>
    <div class="flex">
        <div class="h-12 w-12 flex-none">
            <x-svg.thumbs-up-solid color="fill-green-600" size="5" />
        </div>
        <div class="flex-1">Individueel gewonnen spelletjes</div>
    </div>
    <div class="flex">
        <div class="h-12 w-12 flex-none">
            <x-svg.thumbs-down-solid color="fill-red-600" size="5" />
        </div>
        <div class="flex-1">Individueel verloren spelletjes</div>
    </div>
    <div class="flex">
        <div class="h-12 w-12 flex-none">
            <x-svg.hashtag-solid color="fill-blue-700" size="5" />
        </div>
        <div class="flex-1">
            Het totale aantal gespeelde wedstrijden is natuurlijk gewoon de som van verloren en
            gewonnen wedstrijden,
            <span class="font-bold">tenzij</span>
            een wedstrijd nog bezig is en de spelers de geplande wedstrijden nog niet hebben
            gespeeld.
        </div>
    </div>
    <div class="flex">
        <div class="h-12 w-12 flex-none">
            <x-svg.calendar-days-solid color="fill-green-700" size="5" />
        </div>
        <div class="flex-1">
            <div class="mb-2">
                De dagelijkse wedstrijden waaraan
                <span class="underline">de spelers hebben deelgenomen.</span>
            </div>
        </div>
    </div>
</div>
