@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    New Integration
                </h2>
            </div>
        </div>

        <form action="{{ route('integrations.store') }}" method="POST"
            class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
            @csrf
            <div class="px-4 py-6 sm:p-8">
                <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Integration Name</label>
                        <div class="mt-2">
                            <input type="text" name="name" id="name"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder="e.g. Salesforce CRM">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="provider" class="block text-sm font-medium leading-6 text-gray-900">Provider</label>
                        <div class="mt-2">
                            <select id="provider" name="provider"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option value="salesforce">Salesforce</option>
                                <option value="sap">SAP ERP</option>
                                <option value="stripe">Stripe</option>
                                <option value="paypal">PayPal</option>
                                <option value="webhook">Webhook</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <h3 class="text-base font-semibold leading-7 text-gray-900">Credentials</h3>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Enter the API credentials for the selected provider.
                        </p>

                        <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="client_id" class="block text-sm font-medium leading-6 text-gray-900">Client ID /
                                    API Key</label>
                                <div class="mt-2">
                                    <input type="text" name="credentials[client_id]" id="client_id"
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

                    <div class="col-span-full">
                        <h3 class="text-base font-semibold leading-7 text-gray-900">Settings</h3>
                        <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="url" class="block text-sm font-medium leading-6 text-gray-900">API URL</label>
                                <div class="mt-2">
                                    <input type="text" name="settings[url]" id="url"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                <a href="{{ route('integrations.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
            </div>
        </form>
    </div>
@endsection