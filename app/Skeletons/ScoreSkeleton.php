<?php

namespace App\Skeletons;

class ScoreSkeleton
{
    public static function html(): string
    {
        return <<<'HTML'
        <div>
            <x-title title="Competition Results" help="scoreboard">
                <x-slot:subtitle>
                    <div>{{ __('Season') }} {{ session('cycle') }}</div>
                    @if ($date && $date->checkOpenWindowAccess())
                        <x-svg.live-button-bouncing :date="$date"/>
                    @endif
                </x-slot>
            </x-title>

            <x-navigation.main-links-buttons/>

            <div class="bg-white">
                <div class="mx-auto my-2 w-min whitespace-nowrap rounded-full border border-gray-500 bg-gray-200 text-center md:ml-auto md:mr-6 lg:hidden">
                    <button class="px-4 py-2 bg-gray-300 animate-pulse rounded">Loading...</button>
                </div>


            <table class="table-collapse my-2 min-w-full bg-transparent md:my-4">
                <thead class="whitespace-nowrap">
                <tr>
                    <th class="w-3 bg-gray-300 p-2 text-center text-gray-900 animate-pulse">#</th>
                    <th class="bg-blue-300 p-2 text-left text-gray-900 animate-pulse">Team</th>
                    <th class="bg-amber-300 p-2 text-left text-gray-900 animate-pulse">Last game</th>
                    <th class="bg-yellow-200 p-2 text-center text-gray-900 animate-pulse">Score</th>
                </tr>
                </thead>
                <tbody class="whitespace-nowrap">
                @for($i=0;$i<4;$i++)
                    <tr class="h-12">
                        <td class="bg-gray-200 p-2 text-center text-gray-900 animate-pulse font-bold">
                            1
                        </td>
                        <td class="p-2 bg-blue-100 animate-pulse">
                            <div class="h-4 w-32 bg-gray-300"></div>
                        </td>
                        <td class="bg-amber-200 p-2 text-gray-900 animate-pulse">
                            <div class="h-4 w-32 bg-gray-300"></div>
                        </td>
                        <td class="p-2 text-center">
                            <div class="h-4 w-32 bg-gray-300"></div>
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
           </div>
        </div>

        HTML;
    }
}
