<div class="text-justify">
    <div class="mb-4">
        Ang Kalendaryo ay nagbibigay sa iyo ng pangkalahatang tingnan ng kasalukuyang Panahon.
        Kailan at saan ka maglalaro. Simple. Kasama ang mga resulta ng nakaraang mga laro
        <a
            class="font-bold text-blue-800 hover:text-blue-600 hover:underline"
            href="{{ route('scoreboard') }}"
            wire:navigate
        >
            na tumutukoy sa kasalukuyang ranggo ng iyong koponan
        </a>
    </div>
    <div class="mb-4">
        Ang mga koponang nanalo
        <span class="font-bold">ay ipinapakita sa mas makapal na teksto.</span>
        Kung ikaw ay naka-log in at lumalahok sa kasalukuyang panahon, ang koponang iyong
        pinaglalaruan
        <span class="bg-green-50 p-1">ay may berdeng background.</span>
    </div>
    <div class="mb-4">
        Maaari mong i-click ang puting espasyo sa pagitan ng pangalan ng koponan at ang iskor upang
        bigyan ang ibang koponan ng
        <span class="bg-green-50 p-1">parehong berdeng background</span>
        sa kasalukuyang session.
    </div>
    <div class="mb-4 font-bold">
        Kung, sa ilang dahilan, ang iyong koponan ay hindi naglalaro sa bahay, ang bar (o Lugar) ay
        ipapakita sa ilalim nito.
        <span class="text-red-700">Sa pulang mga titik</span>
        upang hindi mo ito makakaligtaan.
    </div>
    <div class="mb-4 rounded-lg border border-gray-300 bg-gray-50 p-2">
        Isang email,
        <span class="font-bold">bilang paalala</span>
        , ay ipapadala sa iyo sa araw bago ang laro, sa tanghali. Kung hindi ka nakatanggap ng
        anumang email, ang ilan sa mga sumusunod na kinakailangan ay hindi natutugunan:
        <br class="mb-2" />
        1/ hindi ka naka-subscribe
        <br />
        2/ nagbigay ka ng maling email address
        <br />
        3/ Ormeco
        <br />
        4/
        <a
            class="text-blue-800 hover:text-blue-600 hover:underline"
            href="{{ route('teams.index') }}"
            wire:navigate
        >
            hindi ka lumalabas bilang manlalaro sa iyong koponan
        </a>
        <br class="mb-2" />
        Kung ang huli ay totoo, tanungin ang may-ari ng bar o ang kapitan ng iyong koponan. Maaari
        ka nilang idagdag!
    </div>
    <div class="mb-4">
        Ang mga espesyal na petsa ay may subtitle. Karaniwang ang semi-finals, final at party.
    </div>
    <div class="mb-4">
        Ang mga petsa ay maaaring laktawan dahil sa mga espesyal na holiday tulad ng Pasko o ang
        Bagong Taon. Ang hindi pangkaraniwang mga pangyayari, tulad ng bagyo, ay maaaring ilipat ang
        mga petsa ng kalendaryo ng isang linggo. Ang mga administrator lamang ang may access upang
        lumikha at baguhin ang mga petsa.
    </div>
    <div class="mb-4">
        Maaaring hindi mo napansin: bawat koponan ay may sariling pahina. I-click lang ang pangalan.
        Ipinapakita nito ang pangkalahatang tingnan ng Kalendaryo ng koponang iyong pinaglaraluan at
        ang mga resulta ng nakaraang mga laro.
    </div>
    <div class="mb-4">
        Inaasahan kong lumikha ng PDF file sa susunod na Panahon, upang maaari mong i-print ito.
        Personalized upang gawing mas nakikita ang iyong iskedyul.
    </div>
    <div>
        Iyan lang. Cheerio at
        <span class="font-bold">Mag-enjoy!</span>
    </div>
</div>
