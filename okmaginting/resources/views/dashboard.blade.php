<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

@push('additional-scripts')
<div class="py-12 relative">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg relative min-h-screen">
            {{-- Loading Indicator --}}
            <div id="loading" class="absolute z-10 inset-0 overflow-y-auto hidden">
                <div class="flex flex-col items-center justify-center min-h-screen">
                    <div class="absolute inset-0 -z-10 bg-zinc-700/70"></div>
                    <div class="animate-spin rounded-full h-20 w-20 border-t-4 border-b-4 border-white"></div>
                    <h1 class="text-2xl font-semibold text-white text-center">Loading, please wait...</h1>
                </div>
            </div>

            <div class="max-w-xl">
                <section>
                    <h2 class="text-lg font-medium text-gray-900 underline mb-5">Data User</h2>
                    <div class="mb-5">
                        <form id="search-form">
                            <div class="flex space-x-2 mb-4">
                                <input type="text" id="search-input" name="search-input" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-900 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Cari berdasarkan nama atau email" required>
                                <select id="search-type" name="search-type" class="block py-2.5 px-0 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-900 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer w-1/4">
                                    <option value="name">Nama</option>
                                    <option value="email">Email</option>
                                </select>
                                <x-primary-button type="submit" class="mb-2">
                                    Cari
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                    <div id="api-data" class="space-y-2">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                </tr>
                            </thead>
                            <tbody id="user-data" class="bg-white divide-y divide-gray-200">
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@if(session()->has('success'))
    <div id="toast" role="alert" class="fixed top-5 right-14 rounded-xl border border-gray-100 bg-white p-4 shadow-xl dark:border-gray-800 dark:bg-gray-900 transition duration-700">
        <div class="flex items-start gap-4">
            <span class="text-indigo-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            </span>
            
            <div class="flex-1">
            <strong class="block font-medium text-gray-900 dark:text-white">
                {{session()->get('success')}}
            </strong>
            </div>
            
            <button class="text-gray-500 transition hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-500" onclick="document.getElementById('toast').classList.add('hidden')">
            <span class="sr-only">Dismiss popup</span>
            
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6m0 12L6 6" />
            </svg>
            </button>
        </div>
    </div>
@endif

<div id="toast" role="alert" class="fixed top-5 right-14 rounded-xl border border-gray-100 bg-white p-4 shadow-xl dark:border-gray-800 dark:bg-gray-900 transition duration-700 hidden">
    <div class="flex items-start gap-4">
        <span class="text-indigo-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </span>
        <div class="flex-1">
            <strong class="block font-medium text-gray-900 dark:text-white" id="toast-message">
                Data berhasil dimuat
            </strong>
        </div>
        <button class="text-gray-500 transition hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-500" onclick="document.getElementById('toast').classList.add('hidden')">
            <span class="sr-only">Dismiss popup</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6m0 12L6 6" />
            </svg>
        </button>
    </div>
</div>

<script>
    const loading = document.getElementById('loading');
    const userData = document.getElementById('user-data');
    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('search-input');
    const searchType = document.getElementById('search-type');
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');

    searchForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const query = searchInput.value.toLowerCase();
        const type = searchType.value;
        fetchData(`/api/users`, type, query);
    });

    const fetchData = async (url, type, query) => {
        userData.innerHTML = '';
        loading.classList.toggle('hidden');

        try {
            const response = await fetch(url);
            const data = await response.json();

            const filteredData = data.filter(user => {
                if (type === 'name') {
                    return user.name.toLowerCase().includes(query);
                } else if (type === 'email') {
                    return user.email.toLowerCase().includes(query);
                }
            });

            if (filteredData.length > 0) {
                filteredData.forEach(user => {
                    userData.innerHTML += `
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${user.id}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.name}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.email}</td>
                        </tr>
                    `;
                });
                showToast('Data berhasil dimuat');
            } else {
                showToast('Data tidak ditemukan');
            }
        } catch (error) {
            console.error(error);
            showToast('Terjadi kesalahan saat memuat data');
        } finally {
            loading.classList.toggle('hidden');
        }
    };

    const showToast = (message) => {
        toastMessage.innerText = message;
        toast.classList.remove('hidden');
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    };
</script>

</x-app-layout>
