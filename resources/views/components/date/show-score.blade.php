@props(['score1', 'score2'])
<div class="flex flex-row items-center justify-center space-x-2">
    <div @class(['text-base' =>  $score1 <= 7, 'text-lg font-bold text-green-700' => $score1 > 7])>
        {{ $score1 }}
    </div>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 448 512"
        class="inline-block h-4 w-4 fill-gray-600"
    >
        <path
            d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z"
        />
    </svg>
    <div @class(['text-base' =>  $score2 <= 7, 'text-lg font-bold text-green-700' => $score2 > 7])>
        {{ $score2 }}
    </div>
</div>
