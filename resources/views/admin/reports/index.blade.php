@extends('layouts.admin')

@section('content')
<div class="p-4">
    <h2 class="text-2xl font-semibold mb-4">Reports</h2>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        @if($reports->isEmpty())
            <div class="p-4 text-center text-gray-600">No reports available.</div>
        @else
            <table class="min-w-full bg-white">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="p-3 text-left">Title</th>
                        <th class="p-3 text-left">Description</th>
                        <th class="p-3 text-left">User</th>
                        <th class="p-3 text-left">Date</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                    <tr class="border-b">
                        <td class="p-3">{{ $report->title }}</td>
                        <td class="p-3">{{ Str::limit($report->description, 50) }}</td>
                        <td class="p-3">{{ $report->user_name }}</td> <!-- Uses the custom accessor -->
                        <td class="p-3">{{ $report->created_at->format('M d, Y') }}</td>
                        <td class="p-3 text-center">
                            <a href="{{ route('admin.reports.show', $report->id) }}" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                
            </table>
        @endif
    </div>
    <div class="mt-4">{{ $reports->links() }}</div>
</div>
@endsection
