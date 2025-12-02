@extends('layouts.app')

@section('content')
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Logs: {{ $integration->name }}
            </h2>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            <a href="{{ route('integrations.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Back to
                Integrations</a>
        </div>
    </div>

    <div class="flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Status
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Records
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Summary
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Details</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($logs as $log)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-6">
                                        <span
                                            class="inline-flex items-center rounded-full bg-{{ $log->status === 'success' ? 'green' : 'red' }}-50 px-2 py-1 text-xs font-medium text-{{ $log->status === 'success' ? 'green' : 'red' }}-700 ring-1 ring-inset ring-{{ $log->status === 'success' ? 'green' : 'red' }}-600/20">
                                            {{ ucfirst($log->status) }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $log->occurred_at->format('Y-m-d H:i:s') }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $log->records_processed }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 max-w-xs truncate">
                                        {{ json_encode($log->payload_summary) }}</td>
                                    <td
                                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <button type="button" class="text-indigo-600 hover:text-indigo-900"
                                            onclick="alert('{{ json_encode($log->response_data) }}')">View Response</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-3 py-4 text-sm text-gray-500 text-center">No logs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection