<div class="text-justify">
    <div class="mb-4 font-bold">
        <span class="underline">Disclaimer</span>
        : ang feature na ito ay sa wakas ay lumabas na sa beta phase at itinuturing na kumpleto.
    </div>
    <div class="mb-4">
        Dahil ang detalyadong scoreboard ay ngayon ay naitala sa database, posible nang magbalangkas
        ng indibidwal na scoresheet.
    </div>
    <div class="mb-4">
        <span class="font-bold">Ang larong doble</span>
        ay nagreresulta sa panalo (o pagkatalo) ng 2 manlalaro. Ang ranggo ay hindi nag-iiba sa
        pagitan ng singles o doubles.
    </div>
    <div class="mb-4">
        <span class="font-bold">Ang pagpapalit ng mga koponan</span>
        ay walang impluwensya sa mga indibidwal na tagumpay. Ang tanging bagay na nagbabago ay ang
        kasalukuyang pangalan ng koponan.
    </div>
    <div class="mb-4 font-bold">Kaunting paliwanag:</div>
    <div class="mb-4">
        <div class="h-12 w-12 flex-none">
            <x-svg.percent-solid color="fill-indigo-500" size="5" />
        </div>
        <div class="flex-1">
            <div>Ang porsyento ay kinakalkula sa sumusunod na paraan</div>
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
        <div class="flex-1">Mga indibidwal na larong nanalo</div>
    </div>
    <div class="flex">
        <div class="h-12 w-12 flex-none">
            <x-svg.thumbs-down-solid color="fill-red-600" size="5" />
        </div>
        <div class="flex-1">Mga indibidwal na larong natalo</div>
    </div>
    <div class="flex">
        <div class="h-12 w-12 flex-none">
            <x-svg.hashtag-solid color="fill-blue-700" size="5" />
        </div>
        <div class="flex-1">
            Kabuuang mga larong nilaro, siyempre, simpleng kabuuan ng natalo at nanalo na mga laro,
            <span class="font-bold">maliban</span>
            kung ang laro ay kasalukuyang ginagawa at ang mga manlalaro ay hindi pa naglaro ng mga
            nakaiskedyul na laro.
        </div>
    </div>
    <div class="flex">
        <div class="h-12 w-12 flex-none">
            <x-svg.calendar-days-solid color="fill-green-700" size="5" />
        </div>
        <div class="flex-1">
            <div class="mb-2">
                Ang mga araw-araw na laro na
                <span class="underline">sinalihan ng mga manlalaro.</span>
            </div>
        </div>
    </div>
</div>
