{{-- resources/views/admin/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Total Users</div>
                    <div class="text-3xl font-bold">{{ $totalUsers }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Active Users</div>
                    <div class="text-3xl font-bold text-green-600">{{ $activeUsers }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Total Hours Logged</div>
                    <div class="text-3xl font-bold text-blue-600">{{ number_format($totalHoursLogged, 0) }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Nearing Completion</div>
                    <div class="text-3xl font-bold text-orange-600">{{ $usersNearingGoal->count() }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

                {{-- Top Performers --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Top Performers</h3>

                    <div class="space-y-3">
                        @foreach($topPerformers as $performer)
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="font-medium">{{ $performer->name }}</div>
                                <div class="text-sm text-gray-500">{{ $performer->email }}</div>
                            </div>
                            <div class="text-lg font-bold text-blue-600">
                                {{ number_format($performer->time_records_sum_total_hours ?? 0, 2) }}h
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Recent Activity --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>

                    <div class="space-y-2 text-sm">
                        @foreach($recentActivity as $activity)
                        <div class="flex justify-between border-b pb-2">
                            <div>
                                <span class="font-medium">{{ $activity->user->name ?? 'System' }}</span>
                                <span class="text-gray-600">{{ str_replace('_', ' ', $activity->action) }}</span>
                            </div>
                            <div class="text-gray-500 text-xs">
                                {{ $activity->created_at->diffForHumans() }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- Users Nearing Goal --}}
            @if($usersNearingGoal->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Users Nearing Goal Completion</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Progress</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hours</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Goal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($usersNearingGoal as $user)
                            <tr>
                                <td class="px-6 py-4">{{ $user->name }}</td>
                                <td class="px-6 py-4">
                                    <div class="w-32 bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full"
                                            style="width: {{ min($user->activeGoal->progressPercentage(), 100) }}%"></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">{{ number_format($user->totalHoursLogged(), 2) }}</td>
                                <td class="px-6 py-4">{{ number_format($user->activeGoal->required_hours, 0) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>