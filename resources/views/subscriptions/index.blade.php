@extends('layouts.app')

@section('title', 'Subscriptions')

@section('content')
<div x-data="{ openModal: false }">

    <div class="flex justify-end mb-6">
        <button @click="openModal = true" class="px-5 py-2.5 bg-[#2B3441] text-white rounded-xl font-medium hover:bg-[#1E252F] transition-all flex items-center gap-2 text-sm shadow-sm">
            <span>+</span> Add Data
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-visible">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="py-4 px-6 text-sm font-semibold text-gray-600">Customer Name</th>
                    <th class="py-4 px-6 text-sm font-semibold text-gray-600">Services</th>
                    <th class="py-4 px-6 text-sm font-semibold text-gray-600">Services Period</th>
                    <th class="py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                    <th class="py-4 px-6 text-sm font-semibold text-gray-600 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="py-4 px-6 font-medium text-gray-900">Alice Johnson</td>
                    <td class="py-4 px-6 text-gray-500">Service A</td>
                    <td class="py-4 px-6 text-gray-500">1 Jan 2026 - 1 Jan 2027</td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 bg-[#E8F8EE] text-[#2ECC71] text-xs font-semibold rounded-full">Active</span>
                    </td>
                    <td class="py-4 px-6 text-right"><button class="text-gray-400 hover:text-gray-900"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg></button></td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="py-4 px-6 font-medium text-gray-900">Bob Smith</td>
                    <td class="py-4 px-6 text-gray-500">Service B</td>
                    <td class="py-4 px-6 text-gray-500">15 Feb 2026 - 15 Feb 2027</td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 bg-[#FFF4E6] text-[#F39C12] text-xs font-semibold rounded-full">Trial</span>
                    </td>
                    <td class="py-4 px-6 text-right"><button class="text-gray-400 hover:text-gray-900"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg></button></td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="py-4 px-6 font-medium text-gray-900">Carol White</td>
                    <td class="py-4 px-6 text-gray-500">Service C</td>
                    <td class="py-4 px-6 text-gray-500">10 Mar 2026 - 10 Mar 2027</td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 bg-[#FCE8E6] text-[#E74C3C] text-xs font-semibold rounded-full">Isolir</span>
                    </td>
                    <td class="py-4 px-6 text-right"><button class="text-gray-400 hover:text-gray-900"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg></button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div x-show="openModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-[2px]" x-transition>
        <div @click.away="openModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-xl p-8 mx-4">
            <h2 class="text-xl font-bold text-center text-gray-900 mb-8">Add Subscription</h2>
            
            <form action="#" method="POST" class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Customer</label>
                    <div class="relative">
                        <select class="w-full px-4 py-3 bg-[#F5F6F8] border border-transparent rounded-xl focus:bg-white focus:border-gray-200 focus:outline-none appearance-none text-sm text-gray-500">
                            <option value="" disabled selected>Select Customer</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Service</label>
                    <div class="relative">
                        <select class="w-full px-4 py-3 bg-[#F5F6F8] border border-transparent rounded-xl focus:bg-white focus:border-gray-200 focus:outline-none appearance-none text-sm text-gray-500">
                            <option value="" disabled selected>Select Service</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Start Date</label>
                        <input type="date" class="w-full px-4 py-3 bg-[#F5F6F8] border border-transparent rounded-xl focus:bg-white focus:border-gray-200 focus:outline-none transition-all text-sm text-gray-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">End Date</label>
                        <input type="date" class="w-full px-4 py-3 bg-[#F5F6F8] border border-transparent rounded-xl focus:bg-white focus:border-gray-200 focus:outline-none transition-all text-sm text-gray-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Status</label>
                    <div class="relative">
                        <select class="w-full px-4 py-3 bg-[#F5F6F8] border border-transparent rounded-xl focus:bg-white focus:border-gray-200 focus:outline-none appearance-none text-sm text-gray-500">
                            <option value="" disabled selected>Select Status</option>
                            <option value="active">Active</option>
                            <option value="trial">Trial</option>
                            <option value="isolir">Isolir</option>
                            <option value="dismantle">Dismantle</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6">
                    <button type="button" @click="openModal = false" class="px-5 py-2.5 bg-gray-50 text-gray-600 rounded-xl font-medium hover:bg-gray-100 transition-all text-sm">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 bg-[#2B3441] text-white rounded-xl font-medium hover:bg-[#1E252F] transition-all text-sm shadow-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection