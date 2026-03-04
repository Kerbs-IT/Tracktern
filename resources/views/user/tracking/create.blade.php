{{-- resources/views/user/tracking/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Time Entry
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">

                <form method="POST" action="{{ route('user.tracking.store') }}">
                    @csrf

                    {{-- Date --}}
                    <div class="mb-4">
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                        <input type="date"
                            name="date"
                            id="date"
                            value="{{ old('date', today()->format('Y-m-d')) }}"
                            max="{{ today()->format('Y-m-d') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                        @error('date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Time In --}}
                    <div class="mb-4">
                        <label for="time_in" class="block text-sm font-medium text-gray-700 mb-2">Time In</label>
                        <input type="time"
                            name="time_in"
                            id="time_in"
                            value="{{ old('time_in') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                        @error('time_in')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Time Out --}}
                    <div class="mb-4">
                        <label for="time_out" class="block text-sm font-medium text-gray-700 mb-2">Time Out</label>
                        <input type="time"
                            name="time_out"
                            id="time_out"
                            value="{{ old('time_out') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                        @error('time_out')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Notes --}}
                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                        <textarea name="notes"
                            id="notes"
                            rows="3"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="What did you work on today?">{{ old('notes') }}</textarea>
                        @error('notes')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('user.tracking.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Save Entry
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>