<div class="text-justify">
    <div class="mb-4 border-2 border-yellow-500 bg-yellow-100 p-4">
        <span class="font-bold">Disclaimer:</span>
        sa pagpupulong ng mga kapitan noong ika-5 ng Marso 2025 ay napagkasunduan na ang maximum na
        bilang ng mga manlalarong pinapayagan sa isang koponan ay
        <span class="font-bold">{{ \App\Constants::MAX_TEAM_PLAYERS }}</span>
        .
    </div>
    <div class="mb-4">
        Una, makikita mong nakakaboring ang pahinang ito. Ngunit ito ay talagang interesante at
        <span class="font-bold">mahalaga para sa mga may-ari ng Bar at mga Kapitan</span>
        .
    </div>
    <div class="mb-4">Ipaliliwanag ko...</div>
    <div class="mb-4">
        <span class="font-bold">Ang mga koponan at kung saan sila naglalaro</span>
        ay malinaw. Ang numero sa tabi nito ay ang bilang ng mga manlalarong idinagdag sa koponan.
        Sa hinaharap, dapat ay hindi bababa sa 4.
    </div>
    <div class="mb-4">
        Sa wakas, ang Kapitan at ang numero ng contact. Kung ang Kapitan ay hindi nakatakda o ang
        Kapitan ay hindi nagpunan ng numero ng contact, ang fall-back na numero na makikita mo ay ng
        may-ari ng bar. Sakaling kailangan mong ilipat ang petsa, o magiging huli ka kaysa
        inaasahan, makikita mo kung sino ang kokontakin sa pahinang ito.
    </div>
    <div class="mb-4 font-bold">
        Para sa mga maiintindihang dahilan, lahat ng mga numero ng telepono ay nakatago para sa mga
        bisita. Upang makita ang numero ng contact kailangan mong
        <a href="{{ route('login') }}" class="link inline-block text-blue-800" wire:navigate>
            Naka-log In
        </a>
        !
    </div>
    <div class="font-bold">Mga may-ari ng bar at mga Kapitan</div>
    <div class="mb-4">
        Ang mga may-ari ng bar at mga Kapitan ay maaaring mapansin ang
        <x-svg.pen-to-square-solid color="fill-blue-600" size="4" />
        tanda sa tabi ng ilang pangalan. Ibig sabihin nito ay mayroon kang access upang baguhin ang
        nasa ilalim. Para sa mga may-ari ng bar iyon ay ang impormasyon ng bar, ang (mga) koponan at
        ang mga manlalaro ng (mga) koponan. Kasama kung sino ang itatalaga bilang kapitan. Ang
        pagtalaga ng mga koponan mismo ay ginagawa ng administrator dahil ito ay bahagi ng iskedyul
        sa kasalukuyang Panahon.
    </div>
    <div class="font-bold">Mga Kapitan</div>
    <div class="mb-4">
        Ang mga Kapitan (at mga may-ari ng Bar) ay maaaring magdagdag kung sino ang naglalaro sa
        koponan. Ginawa ko itong simple hangga't maaari. Basahin lang ang mga tagubilin sa pahina
        kung mayroon kang anumang mga tanong. Ang isang pagkakamali ay napakadaling ibalik pati.
        Maliban... kung aalisin mo ang iyong sarili bilang kapitan... Well, makakakuha ka ng babala
        bago mo gawin iyon. Ang pag-alis ng manlalaro ng koponan ay nagbibigay din ng babala.
        Anyway, madali lang magdagdag o mag-alis ng mga manlalaro.
    </div>
    <div class="mb-4">
        <span class="font-bold">
            Ang mga manlalaro na nasa ibang koponan na ay hindi maaaring piliin.
        </span>
        Kung ang manlalaro ay bago at wala sa database, magdagdag lang ng bagong manlalaro. Ang mga
        pangalan ay dapat na natatangi. Ang babala ay ibibigay kung ang pangalan ay ginagamit na.
        Matapos lumikha ng bagong user, makakatanggap ka ng email na may datos na kailangan ng iyong
        bagong miyembro ng koponan upang mag-log in at baguhin ang kanilang mga kredensyal.
    </div>
    <div class="mb-4 border-2 border-gray-500 bg-gray-100 p-4">
        <div class="mb-2 font-bold">Mga manlalarong umaalis o lilipat sa ibang koponan</div>
        <div class="mb-2">
            Kung ang manlalaro ay umaalis at hindi na babalik (ang bakasyon ay tapos na halimbawa) O
            ang manlalaro ay gustong lumipat sa ibang koponan,
            <span class="font-bold">maaari mong ligtas na alisin ang manlalaro sa listahan</span>
            . Ang paggawa nito ay WALANG epekto sa nakaraang mga laro.
        </div>
        <div class="mb-2">
            <span class="font-bold">Paano ito gumagana sa ilalim ng hood?</span>
            Ang manlalaro ay
            <span class="italic">dineactivate</span>
            . Siya ay nasa liga pa rin, ngunit wala nang koneksyon sa koponan. Kung ang manlalaro ay
            bumalik O lumipat ng koponan, ang katayuan ng manlalaro ay ia-update nang naaayon.
        </div>
        <div class="mb-2">
            <span class="font-bold">Para sa mga Kapitan:</span>
            ang manlalaro na dineactivate ay nagiging available na anyayahin sa anumang koponan.
        </div>
        <div>
            Ang katayuan O koponan ng manlalaro ay walang impluwensya sa
            <a href="{{ route('rank') }}" class="link inline-block text-blue-800" wire:navigate>
                indibidwal na scoreboard
            </a>
            .
        </div>
    </div>
    <div class="mb-6">
        Iyan lang. Cheerio at
        <span class="font-bold">Mag-enjoy!</span>
    </div>
</div>
