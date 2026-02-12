<div class="text-justify">
    <div class="mb-4">
        Ang pangunahing pahina at ang unang pahina na makikita mo kapag pumunta ka sa website o
        mag-log in. Madaling maunawaan kung alam mo kung ano ang iyong tinitingnan. Sinuman ay
        maaaring makita ang pahinang ito, naka-log in ka man o hindi.
    </div>
    <div class="mb-4">
        Bawat koponan ay lumilitaw nang dalawang beses. Una sa ranggo, pagkatapos ay sa iyong
        pinakabagong laro. Ang home at away status ay hindi mahalaga! Tingnan ang
        <a
            class="text-blue-800 hover:text-blue-600 hover:underline"
            href="{{ route('calendar') }}"
            wire:navigate
        >
            Kalendaryo
        </a>
        upang makita ang mga detalye ng iyong araw-araw na mga laro.
    </div>
    <div class="mb-4">
        Ang ranggo ay tinutukoy ng (1) alphabetical order, (2) ang iyong araw-araw na mga panalo,
        (3) ang dami ng mga indibidwal na larong nanalo laban sa (4) ang mga natalo na indibidwal na
        laro. Ang mga natalo na araw-araw na laro ay hindi mahalaga sa pagbuo ng ranggo.
    </div>
    <div class="mb-4">
        Ang mga koponang hindi umabot sa finals ay negatibong apektado ng porsyento AT bilang ng mga
        laro. Ito ay upang maiwasan na ang nr 3 ay maaaring magkaroon ng mas mataas na porsyento
        kaysa sa runner-up.
    </div>
    <div class="mb-4">
        Ang mga panalo ng koponan at indibidwal ay nakakaimpluwensya sa iskor. Upang makakuha ng
        100% dapat kang manalo sa bawat laro sa maximum score na 15/0.
    </div>
    <div class="mb-4">
        <x-svg.percent-solid color="fill-indigo-500" size="5" />
        ay kinakalkula sa sumusunod na paraan (kung saan ang TG = total games, kasama ang semi at
        finals)
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
        Ang
        <span class="font-bold">factor</span>
        ay may impluwensya lamang sa mga finalist. Ang nanalo ay nakakakuha ng factor na 1.3 o 30%
        na dagdag sa porsyento. Ang runner-up ay nakakakuha ng 15% na dagdag. Lahat ng iba pang
        koponan ay nakakakuha ng factor na 1. Dahilan? Sa mga nakaraang Panahon, posible na ang nr 3
        ay nagtapos na may mas magandang porsyento kaysa sa runner-up...
    </div>
    <div class="mb-4">
        Ang mga larong BYE ay hindi kasama sa anumang kalkulasyon dahil hindi ito itinuturing na
        laro.
    </div>
    <div class="mb-4">
        Kung 2 koponan ay nagtapos na may parehong mga iskor (araw-araw + indibidwal), ang ranggo ay
        magiging alphabetic. Ang kalkulasyon ay hindi isinasaalang-alang ang mga resulta ng mutual
        game. Kung ito ang kaso, mangyaring sumangguni sa aming
        <a
            class="font-bold text-blue-800 hover:text-blue-600 hover:underline"
            href="{{ route('forum.posts.index') }}"
            wire:navigate
        >
            aming Porum
        </a>
        kung saan maaari tayong pag-usapan ang kahit ano (pumapalit sa FaceBook).
    </div>
    <div class="mb-4">
        Panghuli, ang mga simbolo.
        <span class="font-bold">Ang ilang kolum ay maaaring nakatago sa iyong device.</span>
        Depende ito sa lapad ng iyong screen. Ito ay isang talahanayan at ang mga talahanayan ay may
        kanilang mga kakaibang limitasyon.
    </div>
    <div class="mb-4">
        <span class="font-bold">Ang site ay ginawa para sa mobile muna.</span>
        Sa talahanayan, ang ilang kolum ay
        <span class="font-bold">inalis</span>
        (
        <x-svg.minus-solid color="fill-red-700" size="5" padding="-mr-1" />
        ) sa mas maliliit na device ngunit
        <span class="font-bold">nakikita</span>
        sa mas malalaking screen (
        <x-svg.plus-solid color="fill-green-700" size="5" padding="-mr-1" />
        ).
        <span class="text-sm">
            Ang lapad ng mga screen ay: extra small (xs) < 640px, small (sm) > 640px, medium (md) >
            768px, large (lg) >1024px.
        </span>
    </div>
    <table class="table-auto border-separate">
        <thead>
            <tr>
                <th class="h-12 w-12 border border-indigo-400 bg-indigo-50 px-2 text-center">
                    <x-svg.circle-question-regular color="fill-gray-600" size="5" />
                </th>
                <th class="h-12 w-auto border border-indigo-400 bg-indigo-50 px-2 text-left">
                    Paliwanag
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
                    Ranggo, huling laro at iskor (tingnan ang
                    <a
                        class="text-blue-800 hover:text-blue-600 hover:underline"
                        href="{{ route('calendar') }}"
                        wire:navigate
                    >
                        Kalendaryo
                    </a>
                    para sa mga detalye)
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
                    Ang bilang ng mga araw-araw na larong nanalo (8 o mas mataas ay panalo)
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
                    Ang bilang ng mga araw-araw na larong natalo (7 o mas mababa)
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
                    Ang bilang ng mga indibidwal na larong nanalo, kasama ang dobles
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
                    Ang bilang ng mga indibidwal na larong natalo
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
                    Porsyento batay sa pagsisikap ng koponan at indibidwal na resulta
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
                    Ang bilang ng mga larong nilaro
                    <span class="italic">(kasama ang no-show)</span>
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
