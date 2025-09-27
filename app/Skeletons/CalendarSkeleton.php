<?php

namespace App\Skeletons;

use Illuminate\Support\Carbon;

class CalendarSkeleton
{
    public static function html(): string
    {
        return <<<'HTML'
            <x-title title="Games schedule" subtitle="Season {{ session('cycle') }}" help="calendar" />

            <x-navigation.main-links-buttons />

            <div class="relative flex flex-col">
            <div class="px-0 py-2 sm:p-2 md:p-4">
                <div class="flex flex-wrap">
                    @for($i=0;$i<3;$i++)
                        <div class="w-full px-1 md:w-1/2 lg:w-1/3">
                            <div class="relative grid grid-flow-row justify-items-center auto-rows-max gap-y-2 w-auto py-3 px-6 text-gray-900 rounded-t-lg bg-teal-500">
                                <div class="text-white text-lg">{{ now()->addWeeks($i)->format('jS \o\f M Y') }}</div>
                            </div>
                            <table class="mb-4 w-full">
                                <thead class="whitespace-nowrap">
                                <tr class="bg-gray-100">
                                    <th class="p-2 text-left text-red-700">
                                        {{ __('Home Team') }}
                                    </th>
                                    <th class="p-2 text-right text-blue-700">
                                        {{ __('Visitors') }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="whitespace-nowrap">
                                @for($j=0;$j<3;$j++)
                                    <tr class="h-6">
                                        <td>
                                            <div class="flex justify-between p-1">
                                                <div class="mr-1 text-right">
                                                    <div class="h-6 bg-gray-300 animate-pulse rounded w-12"></div>
                                                </div>
                                                <div class="mr-1">
                                                    <div class="h-6 bg-gray-300 animate-pulse rounded w-4"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex justify-between p-1">
                                                <div class="mr-1 text-left">
                                                    <div class="h-6 bg-gray-300 animate-pulse rounded w-4"></div>
                                                </div>
                                                <div class="mr-1">
                                                    <div class="h-6 bg-gray-300 animate-pulse rounded w-12"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                    @endfor

                </div>
            </div>
        </div>

        HTML;

    }
}
