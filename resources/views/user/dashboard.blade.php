{{-- resources/views/user/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                {{-- Total Hours --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Total Hours</div>
                    <div class="text-3xl font-bold">{{ number_format($totalHours, 2) }}</div>
                </div>

                {{-- Today's Hours --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Today</div>
                    <div class="text-3xl font-bold">
                        {{ $todayRecord ? number_format($todayRecord->total_hours, 2) : '0.00' }}
                    </div>
                </div>

                {{-- This Week --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-500 text-sm">This Week</div>
                    <div class="text-3xl font-bold">{{ number_format($thisWeekHours, 2) }}</div>
                </div>

                {{-- This Month --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-500 text-sm">This Month</div>
                    <div class="text-3xl font-bold">{{ number_format($thisMonthHours, 2) }}</div>
                </div>
            </div>

            {{-- Progress Section --}}
            @if($activeGoal)
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Goal Progress</h3>

                <div class="mb-4">
                    <div class="flex justify-between mb-2">
                        <span>{{ number_format($totalHours, 2) }} / {{ number_format($activeGoal->required_hours, 2) }} hours</span>
                        <span>{{ number_format($activeGoal->progressPercentage(), 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-blue-600 h-4 rounded-full"></div>
                    </div>
                </div>

                <div class="text-sm text-gray-600">
                    <p>Hours Remaining: <strong>{{ number_format($activeGoal->hoursRemaining(), 2) }}</strong></p>
                    @if($activeGoal->target_end_date)
                    <p>Target Date: <strong>{{ $activeGoal->target_end_date->format('M d, Y') }}</strong></p>
                    @endif
                </div>
            </div>
            @endif

            {{-- Quick Time Entry (if no record today) --}}
            @if(!$todayRecord)
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Log Today's Hours</h3>
                <a href="{{ route('user.tracking.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    + Add Time Entry
                </a>
            </div>
            @endif

            {{-- Recent Records --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Recent Time Entries</h3>

                @if($recentRecords->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time In</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time Out</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Hours</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($recentRecords as $record)
                            <tr>
                                <td class="px-6 py-4">{{ $record->date->format('M d, Y') }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($record->time_in)->format('h:i A') }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($record->time_out)->format('h:i A') }}</td>
                                <td class="px-6 py-4 font-semibold">{{ number_format($record->total_hours, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <a href="{{ route('user.tracking.index') }}" class="text-blue-600 hover:text-blue-800">
                        View All Records →
                    </a>
                </div>
                @else
                <p class="text-gray-500">No time entries yet. Start logging your hours!</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>