<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, reactive } from 'vue';

const url = ref('');

const state = reactive({
    links: []
});

function fetchLinks() {
    axios.get('api/links')
        .then(response => state.links = response.data.links);
}

onMounted(() => {
    fetchLinks();
});

function copyToClipboard(shortUrl) {
    navigator.clipboard.writeText(shortUrl);
    alert('Short URL copied to clipboard!');
}

function deleteLink(id) {
    // Handle delete logic here
    alert(`Delete link with id: ${id}`);
}

function viewStats(id) {
    // Handle view stats logic here
    alert(`View stats for link with id: ${id}`);
}

function addLink() {
    axios.post('api/links', {
        url: url.value
    }).then(response => {
        url.value = '';
        fetchLinks();
    })
}

async function downloadQrCode(id) {
    try {
        const response = await axios({
            url: `api/links/${id}/qrcode`,  // The route defined in Laravel
            method: 'GET',
            responseType: 'blob', // Important to set the response type to blob
        })

        console.log(response.data);
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'downloaded_file.png'); // The same file name as in the controller
        document.body.appendChild(link);
        link.click();
        link.remove();
    } catch (error) {
        console.error('Error downloading the file', error);
    }
}
</script>

<template>

    <Head title="Links" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Links</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="addLink" class="flex items-center space-x-4 p-4">
                        <input v-model="url" type="url" name="url" required placeholder="Enter URL" autocomplete="off"
                            class="flex-grow border border-gray-300 rounded-lg px-4 py-2 text-gray-800 dark:text-gray-200 dark:bg-gray-700 focus:outline-none focus:ring focus:border-blue-300" />
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                            Shorten
                        </button>
                    </form>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white dark:bg-gray-800">
                        <div class="overflow-x-auto">
                            <table class="table-fixed min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            URL
                                        </th>
                                        <th scope="col"
                                            class="px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Short URL
                                        </th>
                                        <th scope="col"
                                            class="px-2 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Stats
                                        </th>
                                        <th scope="col"
                                            class="px-2 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="link in state.links" :key="link.id">
                                        <td
                                            class="break-normal w-96 px-2 py-4 whitespace-normal text-sm text-gray-500 dark:text-gray-300 font-medium">
                                            {{ link.url }}
                                        </td>
                                        <td
                                            class="px-2 py-4 whitespace-normal text-sm text-gray-500 dark:text-gray-300 font-medium">
                                            <span class="block truncate max-w-xs">
                                                {{ link.short_url }}
                                            </span>
                                        </td>
                                        <td class="px-2 py-4 whitespace-nowrap text-sm font-medium text-right">
                                            <button @click="viewStats(link.id)"
                                                class="text-green-500 hover:text-green-700 dark:text-green-300 dark:hover:text-green-500">
                                                View Stats
                                            </button>
                                        </td>
                                        <td class="px-2 py-4 whitespace-nowrap text-sm font-medium text-right">
                                            <button @click="copyToClipboard(link.short_url)"
                                                class="text-blue-500 hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-500 mr-2">
                                                Copy
                                            </button>
                                            <button @click="deleteLink(link.id)"
                                                class="text-red-500 hover:text-red-700 dark:text-red-300 dark:hover:text-red-500 mr-2">
                                                Delete
                                            </button>
                                            <button @click="downloadQrCode(link.id)"
                                                class="text-red-500 hover:text-red-700 dark:text-red-300 dark:hover:text-red-500 mr-2">
                                                Download QR Code
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>