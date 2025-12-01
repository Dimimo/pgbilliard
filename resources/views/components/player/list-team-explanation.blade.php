@props(['median', 'count'])

<div>
    <div>
        The list shows
        <span class="font-bold">the {{ $median }} most active players</span>
        of a total of {{ $count }} players in this Season.
    </div>
    <div class="mb-4">Optionally, you can see the list of all players.</div>
    <div class="mb-4">The calculation of the percentage:</div>
    <div class="mb-4">
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
    <div class="mb-4">
        <span class="font-bold">Hint:</span>
        {{ __('click on a name to see the game details') }}
    </div>
</div>
