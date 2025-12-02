@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Edit Integration: {{ $integration->name }}
                </h2>
            </div>
        </div>

        <form action="{{ route('integrations.update', $integration) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Config Section -->
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl mb-6">
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Integration
                                Name</label>
                            <div class="mt-2">
                                <input type="text" name="name" id="name" value="{{ $integration->name }}"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="col-span-full">
                            <h3 class="text-base font-semibold leading-7 text-gray-900">Credentials (Leave blank to keep
                                unchanged)</h3>
                            <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label for="client_id" class="block text-sm font-medium leading-6 text-gray-900">Client
                                        ID / API Key</label>
                                    <div class="mt-2">
                                        <input type="text" name="credentials[client_id]" id="client_id"
                                            value="{{ $integration->credentials['client_id'] ?? '' }}"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="secret" class="block text-sm font-medium leading-6 text-gray-900">Client
                                        Secret</label>
                                    <div class="mt-2">
                                        <input type="password" name="credentials[secret]" id="secret"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Field Mapping Section -->
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl mb-6">
                <div class="px-4 py-6 sm:p-8">
                    <h3 class="text-base font-semibold leading-7 text-gray-900 mb-4">Field Mapping</h3>
                    <p class="text-sm text-gray-500 mb-4">Map your internal data fields to the external system fields.</p>

                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Internal
                                    Field</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">External
                                    Field</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Delete</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="mapping-container" class="divide-y divide-gray-200">
                            @foreach($integration->fieldMappings as $index => $mapping)
                                <tr class="mapping-row">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                                        <select name="mappings[{{ $index }}][source_field]"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="email" {{ $mapping->source_field == 'email' ? 'selected' : '' }}>User
                                                Email</option>
                                            <option value="name" {{ $mapping->source_field == 'name' ? 'selected' : '' }}>User
                                                Name</option>
                                            <option value="phone" {{ $mapping->source_field == 'phone' ? 'selected' : '' }}>Phone
                                                Number</option>
                                            <option value="created_at" {{ $mapping->source_field == 'created_at' ? 'selected' : '' }}>Registration Date</option>
                                        </select>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <input type="text" name="mappings[{{ $index }}][target_field]"
                                            value="{{ $mapping->target_field }}"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            placeholder="e.g. ContactEmail">
                                    </td>
                                    <td
                                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <button type="button" onclick="removeRow(this)"
                                            class="text-red-600 hover:text-red-900">Remove</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        <button type="button" onclick="addRow()"
                            class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Add
                            Field</button>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-x-6">
                <a href="{{ route('integrations.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save
                    Changes</button>
            </div>
        </form>
    </div>

    <script>
        let rowCount = {{ $integration->fieldMappings->count() }};

        function addRow() {
            const container = document.getElementById('mapping-container');
            const index = rowCount++;
            const row = `
                <tr class="mapping-row">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                        <select name="mappings[${index}][source_field]" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option value="email">User Email</option>
                            <option value="name">User Name</option>
                            <option value="phone">Phone Number</option>
                            <option value="created_at">Registration Date</option>
                        </select>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        <input type="text" name="mappings[${index}][target_field]" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="e.g. ContactEmail">
                    </td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                        <button type="button" onclick="removeRow(this)" class="text-red-600 hover:text-red-900">Remove</button>
                    </td>
                </tr>
            `;
            container.insertAdjacentHTML('beforeend', row);
        }

        function removeRow(btn) {
            btn.closest('tr').remove();
        }
    </script>
@endsection