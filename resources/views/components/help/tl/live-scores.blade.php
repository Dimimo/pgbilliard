<div class="text-justify">
    <div class="mb-4">
        Sa
        <a href="{{ route('calendar') }}" class="link inline-block text-blue-800" wire:navigate>
            Kalendaryo
        </a>
        maaari mong piliin ang anumang petsa. Mayroong 3 posibilidad na ipapakita sa iyo:
    </div>

    <div class="mb-4">
        <ul class="list-inside list-disc">
            <li>
                ang petsang
                <span class="font-bold">mula sa nakaraan</span>
                ay nagpapakita sa iyo ng panghuling iskor at isang link sa araw-araw na iskedyul ng
                mga indibidwal na resulta
            </li>
            <li>
                ang petsang
                <span class="font-bold">sa hinaharap</span>
                ay nagbibigay sa iyo ng natitirang oras para sa 'window' na magbukas
            </li>
            <li>
                ang
                <span class="font-bold">'time window' ay bukas</span>
                , ang mga laro ay magsisimula na o nagsimula na
            </li>
        </ul>
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">
                Ang pangkalahatang tingnan ng araw ng kalendaryo na nakatakda sa hinaharap
            </div>
        </div>
        <div class="m-4 flex justify-center">
            <img src="{{ secure_url('/images/schedule/day_score_future.png') }}" alt="" />
        </div>
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">
                Ang pangkalahatang tingnan ng araw ng kalendaryo sa araw na naglalaro tayo mula
                {{ \App\Constants::DATEFORMAT_START }}h hanggang
                {{ \App\Constants::DATEFORMAT_END }}h
            </div>
        </div>
        <div class="m-4 flex justify-center">
            <img src="{{ secure_url('/images/schedule/day_score_ready.png') }}" alt="" />
        </div>
    </div>

    <div class="mb-4">
        Kung ikaw ay naglalaro para sa isang koponan, mayroon kang access sa larong iyong kasalihan.
        Bawat manlalaro ay maaaring mag-update ng mga iskor ng laro. Sa kasong ito, ang larong
        <span class="font-bold">Pirata Galleon - Victoria</span>
        ay maaaring i-update. Ang ibang mga laro
        <span class="font-bold">ay hindi pa nagsimula</span>
        .
    </div>

    <div class="mb-4 rounded-lg border-2 border-green-700 bg-green-100 p-4">
        Bawat
        <span class="italic">natapos na indibidwal na laro</span>
        ay makikita sa Score Board, ang Kalendaryo, ang pangkalahatang tingnan ng araw AT ang "Mga
        iskedyul ng araw".
        <span class="font-bold">
            Walang pangangailangang mag-refresh. Ang mga update sa iskor ay agad na makikita.
        </span>
    </div>

    <div class="mb-4">
        Kapag ang mga laro ay aktwal na nilalaro, mapapansin mo ang isang link sa
        <a href="{{ route('scoreboard') }}" class="link inline-block text-blue-800" wire:navigate>
            Scoreboard
        </a>
        at sa
        <a href="{{ route('calendar') }}" class="link inline-block text-blue-800" wire:navigate>
            Kalendaryo
        </a>
        bilang
        <span class="font-bold">Live Scores</span>
        .
    </div>

    <div class="mb-4">
        <span class="font-bold">
            Mula ngayon kailangan mong naka-log in upang baguhin ang iskor.
        </span>
        Sinuman ay maaaring bumisita sa panahon ng
        <span class="italic">mga oras ng pagbubukas</span>
        mula {{ \App\Constants::DATEFORMAT_START }}h hanggang
        {{ \App\Constants::DATEFORMAT_END }}h.
    </div>

    <div class="mb-4">
        <span class="font-bold">Mayroon lohikal na hierarchy</span>
        :
        <div class="ml-4">
            <span class="font-bold">Mga Administrator</span>
            : access sa lahat ng mga laro
            <span class="font-semibold">maliban</span>
            sa mga nakumpirmang laro, ang mga ito ay hindi na mababago
            <br />
            <span class="font-bold">Mga may-ari ng bar</span>
            : maaaring baguhin ang mga iskor sa anumang koponang naglalaro para sa bar
            <br />
            <span class="font-bold">Mga kapitan at manlalaro</span>
            : maaari lamang baguhin ang larong kanilang kasangkot, i.e. ang Victoria ay walang
            access sa Bluemoon - Tigers
            <br />
            <span class="font-bold">Mga bisita o hindi manlalaro</span>
            : basahin lamang
        </div>
        Pansinin: kung mayroon kang access sa isang laro na kasalukuyang ginagawa, mayroon kang
        access sa parehong home at visitor's score.
    </div>

    <div class="mb-4">
        <span class="font-bold">
            Ano ang tungkol sa
            <span class="text-lg text-blue-800">confirm</span>
            button?
        </span>
        <div class="ml-4">
            Ito ay lumalabas kapag ang laro ay umabot na sa 15 na mga laro. Ito ay isang uri ng
            trigger. Sinasabi nito na ang laro ay tapos na at ang iskor ay final. Ang Pirata -
            Geriatric na laro ay nakatakda bilang nakumpirma. Ang Kickass - Victoria na laro ay
            hindi pa.
            <br class="mb-2" />
            Ito ay may confirmation dialogue. Para lang sigurado.
            <br class="mb-2" />
            Kapag ang panghuling laro ay nakumpirma,
            <span class="font-bold">
                lahat ng mga lumalahok na manlalaro ay makakatanggap ng email na may mga resulta ng
                araw
            </span>
            .
            <br />
            <span class="font-bold">Gaya ng palagi</span>
            :
            <a
                href="{{ route('scoreboard') }}"
                class="link inline-block text-blue-800"
                wire:navigate
            >
                ang Scoreboard
            </a>
            at
            <a
                href="{{ route('calendar') }}"
                class="link inline-block text-blue-800"
                wire:navigate
            >
                ang Kalendaryo
            </a>
            ay agad na naka-update.
        </div>
    </div>

    <div class="mb-4 font-bold">
        Ang mga nakumpirmang laro ay hindi mababago ng sinuman, kahit ng mga administrator.
    </div>

    @if (session('is_admin'))
        <div class="mb-4 rounded-lg border-2 border-indigo-700 text-center">
            <div class="mb-4 border-b border-indigo-700 font-bold">
                <div class="rounded-t-lg bg-indigo-100 p-4">Para sa mga administrator lamang</div>
            </div>
            <div class="mb-4">
                Bilang administrator maaari mo pa ring baguhin ang iskor direkta gaya ng dati.
                <br />
                Ang dahilan? Sa kaso ng
                <span class="font-bold">no-show (8-0)</span>
                . Walang araw-araw na indibidwal na mga iskor na magagamit dahil wala naman.
            </div>
            <div class="w-full rounded-lg border border-gray-500 bg-white p-2 text-center">
                <div class="my-2 font-bold">
                    Ang makikita ng administrator kapag ang laro ay
                    <span class="font-bold">hindi nakumpirma</span>
                </div>
                <img
                    src="{{ secure_url('/images/schedule/admin_direct_score_overview.png') }}"
                    alt=""
                />
            </div>
        </div>
    @endif
</div>
