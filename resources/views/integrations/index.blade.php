@extends('layouts.app')

@section('content')
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Integrations
            </h2>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            <a href="{{ route('integrations.create') }}"
                class="ml-3 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Add New Integration
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($integrations as $integration)
            <div
                class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                <div class="shrink-0">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-indigo-500">
                        <span class="font-medium leading-none text-white">{{ substr($integration->name, 0, 2) }}</span>
                    </span>
                </div>
                <div class="min-w-0 flex-1">
                    <a href="{{ route('integrations.edit', $integration) }}" class="focus:outline-none">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">{{ $integration->name }}</p>
                        <p class="truncate text-sm text-gray-500">{{ ucfirst($integration->provider) }}</p>
                    </a>
                </div>
                <div class="flex flex-col items-end space-y-1">
                    <span
                        class="inline-flex items-center rounded-full bg-{{ $integration->status === 'active' ? 'green' : 'red' }}-50 px-2 py-1 text-xs font-medium text-{{ $integration->status === 'active' ? 'green' : 'red' }}-700 ring-1 ring-inset ring-{{ $integration->status === 'active' ? 'green' : 'red' }}-600/20">
                        {{ ucfirst($integration->status) }}
                    </span>
                    <a href="{{ route('integrations.logs', $integration) }}"
                        class="relative z-10 text-xs text-indigo-600 hover:text-indigo-900">View Logs</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection