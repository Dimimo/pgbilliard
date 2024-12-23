@props(['score1', 'score2'])
<div class="flex flex-row justify-center items-center space-x-2">
    <div @class(['text-base' =>  $score1 <= 7, 'text-lg font-bold text-green-700' => $score1 > 7])>
        {{ $score1 }}
    </div>
    <x-svg.minus-solid color="fill-gray-600" size="4" padding=""/>
    <div @class(['text-base' =>  $score2 <= 7, 'text-lg font-bold text-green-700' => $score2 > 7])>
        {{ $score2 }}
    </div>
</div>
