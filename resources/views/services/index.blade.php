@extends('layouts.app')

@section('title', 'Services')

@section('content')
<div x-data="{ 
    services: [],
    openModal: false, 
    isEdit: false, 
    
    // State Form
    idRecord: '',
    name: '',
    price: '',
    description: '',
    status: '1',

    // State Modal & Toast
    openDeleteModal: false,
    deleteTargetId: null,
    toast: { show: false, message: '', type: 'success' },

    triggerToast(message, type = 'success') {
        this.toast = { show: true, message, type };
        setTimeout(() => { this.toast.show = false; }, 4000);
    },

    init() {
        fetch('/api/services')
            .then(res => res.json())
            .then(res => { if(res.success) this.services = res.data; });
    },

    openAddModal() {
        this.isEdit = false;
        this.idRecord = ''; this.name = ''; this.price = ''; this.description = ''; this.status = '1';
        this.openModal = true;
    },

    openEditModal(item) {
        this.isEdit = true;
        this.idRecord = item.id;
        this.name = item.name;
        this.price = item.price;
        this.description = item.description;
        this.status = item.status ? '1' : '0';
        this.openModal = true;
    },

    submitForm() {
        const url = this.isEdit ? `/api/services/${this.idRecord}` : '/api/services';
        const method = this.isEdit ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ 
                name: this.name, 
                price: this.price, 
                description: this.description, 
                status: this.status === '1' 
            })
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                this.openModal = false;
                this.init();
                this.triggerToast(this.isEdit ? 'Service updated successfully!' : 'Service created successfully!');
            }
        });
    },

    confirmDelete(id) { this.deleteTargetId = id; this.openDeleteModal = true; },
    
    executeDelete() {
        fetch(`/api/services/${this.deleteTargetId}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(res => res.json())
        .then(res => {
            this.openDeleteModal = false;
            if(res.success) { this.init(); this.triggerToast('Service deleted!'); }
        });
    }
}">

    <div class="fixed top-6 right-6 z-50" x-show="toast.show" style="display: none;" x-transition>
        <div class="bg-white border border-gray-100 shadow-xl rounded-2xl p-4 flex items-center gap-3">
            <div :class="toast.type === 'success' ? 'bg-[#E8F8EE] text-[#2ECC71]' : 'bg-[#FCE8E6] text-[#E74C3C]'" class="w-8 h-8 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <p class="text-sm font-medium text-gray-700" x-text="toast.message"></p>
        </div>
    </div>

    <div class="flex justify-end mb-6">
        <button @click="openAddModal()" class="px-5 py-2.5 bg-[#2B3441] text-white rounded-xl font-medium hover:bg-[#1E252F] transition-all flex items-center gap-2 text-sm shadow-sm">
            <span>+</span> Add Data
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-visible">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="py-4 px-6 text-sm font-semibold text-gray-600">Service Name</th>
                    <th class="py-4 px-6 text-sm font-semibold text-gray-600">Price</th>
                    <th class="py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                    <th class="py-4 px-6 text-sm font-semibold text-gray-600 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                <template x-for="item in services" :key="item.id">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6 font-medium text-gray-900" x-text="item.name"></td>
                        <td class="py-4 px-6 text-gray-500" x-text="'Rp ' + item.price.toLocaleString()"></td>
                        <td class="py-4 px-6">
                            <span :class="item.status ? 'bg-[#E8F8EE] text-[#2ECC71]' : 'bg-[#FCE8E6] text-[#E74C3C]'" 
                                  class="px-3 py-1 text-xs font-semibold rounded-full" 
                                  x-text="item.status ? 'Active' : 'Inactive'"></span>
                        </td>
                        <td class="py-4 px-6 text-right relative" x-data="{ openAction: false }">
                            <button @click="openAction = !openAction" @click.away="openAction = false" class="text-gray-400 hover:text-gray-900 p-1 rounded inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                            </button>
                            <div x-show="openAction" style="display: none;" class="absolute right-6 top-10 w-32 bg-white rounded-xl shadow-xl border border-gray-100 z-10 py-2">
                                <button type="button" @click="openEditModal(item)" class="w-full text-left px-4 py-2 hover:bg-gray-50 text-gray-700 font-medium">Edit</button>
                                <button type="button" @click="confirmDelete(item.id)" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 font-medium">Delete</button>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <div x-show="openModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-[2px]" x-transition>
        <div @click.away="openModal = false" class="bg-white rounded-[20px] shadow-2xl w-full max-w-lg p-8 mx-4">
            <h2 class="text-xl font-bold text-center text-gray-900 mb-6" x-text="isEdit ? 'Edit Services' : 'Add Services'"></h2>
            
            <form @submit.prevent="submitForm()" class="space-y-4">
                <div>
                    <label class="block text-[15px] font-bold text-gray-900 mb-2">Service Name</label>
                    <input type="text" x-model="name" class="w-full px-4 py-3 bg-[#F8F9FA] border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-gray-300 transition-all text-sm placeholder-gray-400" placeholder="Enter your name" required>
                </div>
                
                <div>
                    <label class="block text-[15px] font-bold text-gray-900 mb-2">Price</label>
                    <input type="number" x-model="price" class="w-full px-4 py-3 bg-[#F8F9FA] border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-gray-300 transition-all text-sm placeholder-gray-400" placeholder="Enter your price" required>
                </div>
                
                <div>
                    <label class="block text-[15px] font-bold text-gray-900 mb-2">Description</label>
                    <textarea x-model="description" rows="3" class="w-full px-4 py-3 bg-[#F8F9FA] border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-gray-300 transition-all text-sm resize-none placeholder-gray-400" placeholder="Enter your description"></textarea>
                </div>
                
                <div>
                    <label class="block text-[15px] font-bold text-gray-900 mb-2">Status</label>
                    <div class="relative">
                        <select x-model="status" class="w-full px-4 py-3 bg-[#F8F9FA] border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-gray-300 appearance-none transition-all text-sm text-gray-500">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" @click="openModal = false" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-all text-sm">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 bg-[#2B3441] text-white rounded-xl font-medium hover:bg-[#1E252F] transition-all text-sm shadow-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="openDeleteModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-[2px]" x-transition>
        <div class="bg-white p-8 rounded-3xl w-full max-w-sm text-center">
            <h3 class="font-bold text-lg mb-4">Delete Service?</h3>
            <p class="text-gray-500 mb-6 text-sm">Are you sure? This cannot be undone.</p>
            <div class="flex gap-3">
                <button @click="openDeleteModal = false" class="w-full py-3 bg-gray-100 rounded-xl text-sm font-medium">Cancel</button>
                <button @click="executeDelete()" class="w-full py-3 bg-red-600 text-white rounded-xl text-sm font-medium">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection