{{-- resources/views/user/tracking/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Time Records
            </h2>
            <a href="{{ route('user.tracking.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Add Entry
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                @if($records->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time In</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time Out</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Hours</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notes</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($records as $record)
                            <tr>
                                <td class="px-6 py-4">{{ $record->date->format('M d, Y') }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($record->time_in)->format('h:i A') }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($record->time_out)->format('h:i A') }}</td>
                                <td class="px-6 py-4 font-semibold">{{ number_format($record->total_hours, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $record->notes ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('user.tracking.edit', $record) }}"
                                            class="text-blue-600 hover:text-blue-800">Edit</a>
                                        <form action="{{ route('user.tracking.destroy', $record) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $records->links() }}
                </div>
                @else
                <p class="text-gray-500 text-center py-8">No time records found.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>