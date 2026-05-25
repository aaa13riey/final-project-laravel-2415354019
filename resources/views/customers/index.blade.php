@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div x-data="{ 
    customers: [],
    openModal: false, 
    isEdit: false, 
    
    // State Form Input
    idRecord: '', 
    customerId: '',
    name: '',
    email: '',
    phone: '',
    address: '',
    status: '1',

    // State Kustom Modal Hapus
    openDeleteModal: false,
    deleteTargetId: null,

    // State Kustom Toast Notification
    toast: {
        show: false,
        message: '',
        type: 'success' // 'success', 'error', 'info', 'warning'
    },

    // Fungsi trigger toast
    triggerToast(message, type = 'success') {
        this.toast.message = message;
        this.toast.type = type;
        this.toast.show = true;
        // Otomatis hilang dalam 4 detik
        setTimeout(() => {
            this.toast.show = false;
        }, 4000);
    },

    // 1. Ambil Data Awal dari API
    init() {
        fetch('/api/customers')
            .then(res => res.json())
            .then(res => {
                if(res.success) this.customers = res.data;
            })
            .catch(err => {
                console.error('Gagal memuat data:', err);
                this.triggerToast('Failed to load customers data', 'error');
            });
    },

    // 2. Setup Form Tambah Data
    openAddModal() {
        this.isEdit = false;
        this.idRecord = '';
        this.customerId = '';
        this.name = '';
        this.email = '';
        this.phone = '';
        this.address = '';
        this.status = '1';
        this.openModal = true;
    },

    // 3. Setup Form Edit Data
    openEditModal(item) {
        this.isEdit = true;
        this.idRecord = item.id; 
        this.customerId = item.customer_id;
        this.name = item.name;
        this.email = item.email;
        this.phone = item.phone || '';
        this.address = item.address || '';
        this.status = item.status ? '1' : '0';
        this.openModal = true;
    },

    // 4. Update Status (Activate / Deactivate) via Dropdown Action
    toggleStatus(id, action) {
        fetch(`/api/customers/${id}/${action}`, {
            method: 'PATCH',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                'Accept': 'application/json' 
            }
        })
        .then(res => res.json())
        .then(res => {
            if(res.success) {
                this.init(); 
                this.triggerToast(`Customer status updated successfully!`, 'success');
            }
        })
        .catch(err => console.error(err));
    },

    // 5. Trigger Modal Konfirmasi Hapus
    confirmDelete(id) {
        this.deleteTargetId = id;
        this.openDeleteModal = true;
    },

    // 6. Eksekusi Hapus Data dari Modal Konfirmasi
    executeDelete() {
        if (!this.deleteTargetId) return;

        fetch(`/api/customers/${this.deleteTargetId}`, {
            method: 'DELETE',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                'Accept': 'application/json' 
            }
        })
        .then(res => res.json())
        .then(res => {
            this.openDeleteModal = false;
            if(res.success) {
                this.init();
                this.triggerToast('Customer deleted successfully', 'success');
            } else {
                this.triggerToast(res.message || 'Failed to delete customer', 'error');
            }
            this.deleteTargetId = null;
        })
        .catch(err => {
            console.error(err);
            this.openDeleteModal = false;
            this.triggerToast('Server error occurred', 'error');
        });
    },

    // 7. Submit Data Form (Simpan Baru / Update Data Lama)
    submitForm() {
        const url = this.isEdit ? `/api/customers/${this.idRecord}` : '/api/customers';
        const method = this.isEdit ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                customer_id: this.customerId,
                name: this.name,
                email: this.email,
                phone: this.phone,
                address: this.address,
                status: this.status === '1'
            })
        })
        .then(async res => {
            const data = await res.json();
            if (res.ok && data.success) {
                this.openModal = false;
                this.init(); 
                this.triggerToast(this.isEdit ? 'Customer updated successfully' : 'Customer added successfully', 'success');
            } else {
                if (data.errors) {
                    let errorMessages = '';
                    Object.keys(data.errors).forEach(key => {
                        errorMessages += `${data.errors[key].join(', ')}\n`;
                    });
                    this.triggerToast(errorMessages, 'error');
                } else {
                    this.triggerToast(data.message || 'Validation failed.', 'error');
                }
            }
        })
        .catch(err => {
            console.error(err);
            this.triggerToast('Failed to connect to server.', 'error');
        });
    }
}">

    <div class="fixed top-6 right-6 z-50 space-y-3 w-full max-w-sm">
        <div x-show="toast.show" 
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;"
             class="bg-white border border-gray-100 rounded-2xl shadow-xl p-4 flex items-center justify-between gap-3">
            
            <div class="flex items-center gap-3">
                <template x-if="toast.type === 'success'">
                    <div class="w-8 h-8 rounded-full bg-[#E8F8EE] flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-[#2ECC71]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </template>
                
                <template x-if="toast.type === 'error'">
                    <div class="w-8 h-8 rounded-full bg-[#FCE8E6] flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-[#E74C3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                </template>

                <p class="text-sm font-medium text-gray-700 whitespace-pre-line" x-text="toast.message"></p>
            </div>

            <button @click="toast.show = false" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    <div class="flex justify-end mb-6">
        <button @click="openAddModal()" class="px-5 py-2.5 bg-[#2B3441] text-white rounded-xl font-medium hover:bg-[#1E252F] transition-all text-sm flex items-center gap-2">
            <span>+</span> Add Data
        </button>
    </div>

    <div class="bg-white overflow-visible w-full">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="py-4 px-4 text-sm font-semibold text-gray-900 w-32">Customer ID</th>
                    <th class="py-4 px-4 text-sm font-semibold text-gray-900">Customer Name</th>
                    <th class="py-4 px-4 text-sm font-semibold text-gray-900">Email</th>
                    <th class="py-4 px-4 text-sm font-semibold text-gray-900">Address</th>
                    <th class="py-4 px-4 text-sm font-semibold text-gray-900">Status</th>
                    <th class="py-4 px-4 text-sm font-semibold text-gray-900 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                <template x-for="item in customers" :key="item.id">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-4 text-gray-900 font-mono" x-text="item.customer_id"></td>
                        <td class="py-4 px-4 font-medium text-gray-900" x-text="item.name"></td>
                        <td class="py-4 px-4 text-gray-500" x-text="item.email"></td>
                        <td class="py-4 px-4 text-gray-500" x-text="item.address || '-'"></td>
                        <td class="py-4 px-4">
                            <span :class="item.status ? 'bg-[#E8F8EE] text-[#2ECC71]' : 'bg-[#FCE8E6] text-[#E74C3C]'" 
                                  class="px-2.5 py-1 text-xs font-semibold rounded-full" 
                                  x-text="item.status ? 'Active' : 'Inactive'">
                            </span>
                        </td>
                        <td class="py-4 px-4 text-right relative" x-data="{ openAction: false }">
                            <button @click="openAction = !openAction" @click.away="openAction = false" class="text-gray-400 hover:text-gray-900 p-1 rounded inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                            </button>
                            
                            <div x-show="openAction" x-transition style="display: none;" class="absolute right-4 top-12 w-40 bg-white rounded-xl shadow-xl border border-gray-100 z-30 py-1.5 text-left">
                                <button @click="toggleStatus(item.id, 'activate')" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                                    Active
                                </button>
                                <button @click="toggleStatus(item.id, 'deactivate')" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                    Deactivate
                                </button>
                                <button @click="openEditModal(item)" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    Edit
                                </button>
                                <div class="border-t border-gray-100 my-1"></div>
                                <button @click="confirmDelete(item.id)" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>
                <tr x-show="customers.length === 0">
                    <td colspan="6" class="py-8 text-center text-gray-400">Tidak ada data pelanggan.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div x-show="openModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-[2px]" x-transition>
        <div @click.away="openModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-xl p-8 mx-4">
            <h2 class="text-xl font-bold text-center text-gray-900 mb-8" x-text="isEdit ? 'Edit Customer' : 'Add Customer'"></h2>
            
            <form @submit.prevent="submitForm()" class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Customer ID</label>
                    <input type="text" x-model="customerId" :disabled="isEdit" required class="w-full px-4 py-3 bg-[#F5F6F8] border border-transparent rounded-xl focus:bg-white focus:border-gray-200 focus:outline-none text-sm disabled:opacity-50" placeholder="Enter your ID">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Customer Name</label>
                    <input type="text" x-model="name" required class="w-full px-4 py-3 bg-[#F5F6F8] border border-transparent rounded-xl focus:bg-white focus:border-gray-200 focus:outline-none text-sm" placeholder="Enter your name">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Email</label>
                    <input type="email" x-model="email" required class="w-full px-4 py-3 bg-[#F5F6F8] border border-transparent rounded-xl focus:bg-white focus:border-gray-200 focus:outline-none text-sm" placeholder="Enter your email">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Phone (Optional)</label>
                    <input type="text" x-model="phone" class="w-full px-4 py-3 bg-[#F5F6F8] border border-transparent rounded-xl focus:bg-white focus:border-gray-200 focus:outline-none text-sm" placeholder="Enter phone number">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Address</label>
                    <input type="text" x-model="address" class="w-full px-4 py-3 bg-[#F5F6F8] border border-transparent rounded-xl focus:bg-white focus:border-gray-200 focus:outline-none text-sm" placeholder="Enter your address">
                </div>
                <div x-show="!isEdit">
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Status</label>
                    <div class="relative">
                        <select x-model="status" class="w-full px-4 py-3 bg-[#F5F6F8] border border-transparent rounded-xl focus:bg-white focus:border-gray-200 focus:outline-none appearance-none text-sm text-gray-500">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6">
                    <button type="button" @click="openModal = false" class="px-5 py-2.5 bg-gray-50 text-gray-600 rounded-xl font-medium hover:bg-gray-100 text-sm">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 bg-[#2B3441] text-white rounded-xl font-medium hover:bg-[#1E252F] text-sm shadow-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="openDeleteModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-[2px]" x-transition>
        <div @click.away="openDeleteModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 mx-4 text-center">
            
            <div class="w-14 h-14 rounded-full bg-[#FCE8E6] flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-[#E74C3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>

            <h3 class="text-lg font-bold text-gray-900 mb-2">Delete Customer</h3>
            <p class="text-sm text-gray-500 mb-8">Are you sure you want to delete this customer? This action cannot be undone.</p>

            <div class="flex justify-center gap-3">
                <button type="button" @click="openDeleteModal = false" class="px-5 py-2.5 bg-gray-50 text-gray-600 rounded-xl font-medium hover:bg-gray-100 text-sm w-1/2">
                    Cancel
                </button>
                <button type="button" @click="executeDelete()" class="px-5 py-2.5 bg-[#E74C3C] text-white rounded-xl font-medium hover:bg-[#C0392B] text-sm w-1/2 shadow-sm">
                    Delete
                </button>
            </div>
        </div>
    </div>

</div>
@endsection