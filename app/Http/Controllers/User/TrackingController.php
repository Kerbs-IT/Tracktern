<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTimeRecordRequest;
use App\Http\Requests\UpdateTimeRecordRequest;
use App\Models\ActivityLog;
use App\Models\TimeRecord;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

// app/Http/Controllers/User/TrackingController.php
// app/Http/Controllers/User/TrackingController.php
class TrackingController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $records = auth()->user()
            ->timeRecords()
            ->latest('date')
            ->paginate(15);

        return view('user.tracking.index', compact('records'));
    }

    public function create()
    {
        return view('user.tracking.create');
    }

    public function store(StoreTimeRecordRequest $request)
    {
        $timeRecord = auth()->user()->timeRecords()->create($request->validated());

        ActivityLog::log('time_entry_created', "Date: {$timeRecord->date}");

        return redirect()
            ->route('user.tracking.index')
            ->with('success', 'Time entry added successfully!');
    }

    public function edit(TimeRecord $tracking)
    {
        $this->authorize('update', $tracking);
        return view('user.tracking.edit', compact('tracking'));
    }

    public function update(UpdateTimeRecordRequest $request, TimeRecord $tracking)
    {
        $this->authorize('update', $tracking);

        $tracking->update($request->validated());

        ActivityLog::log('time_entry_updated', "Record ID: {$tracking->id}");

        return redirect()
            ->route('user.tracking.index')
            ->with('success', 'Time entry updated successfully!');
    }

    public function destroy(TimeRecord $tracking)
    {
        $this->authorize('delete', $tracking);

        $tracking->delete();

        ActivityLog::log('time_entry_deleted', "Date: {$tracking->date}");

        return redirect()
            ->route('user.tracking.index')
            ->with('success', 'Time entry deleted successfully!');
    }
}
