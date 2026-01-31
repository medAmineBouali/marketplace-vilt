<script setup lang="ts">
import SellerLayout from '@/Layouts/SellerLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps<{
    products: Array<any>
}>();

const deleteProduct = (id: number) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
        router.delete(route('seller.products.destroy', id));
    }
};
</script>

<template>
    <Head title="Mes Produits" />

    <SellerLayout>
        <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4 flex justify-between items-center">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Mes Produits</h1>
                    <Link
                        :href="route('seller.products.create')"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow text-sm"
                    >
                        + Nouveau
                    </Link>
                </div>
            </div>
        </div>

        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Produit
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Prix
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Stock
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            <tr v-for="product in products" :key="product.id" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="p-4 flex items-center whitespace-nowrap space-x-6 mr-12 lg:mr-0">
                                    <img :src="product.image" class="h-10 w-10 rounded-full" alt="Product Image">
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">{{ product.name }}</div>
                                        <div class="text-xs font-normal text-gray-500 dark:text-gray-400">ID: {{ product.id }}</div>
                                    </div>
                                </td>
                                <td class="p-4 text-base font-medium text-gray-900 dark:text-white">{{ product.price }} €</td>
                                <td class="p-4 text-base font-medium text-gray-900 dark:text-white">
                                    <span v-if="product.stock_quantity > 0" class="text-green-500">{{ product.stock_quantity }} en stock</span>
                                    <span v-else class="text-red-500">Rupture</span>
                                </td>
                                <td class="p-4 space-x-2 whitespace-nowrap">
                                    <Link :href="route('seller.products.edit', product.id)" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                        Modifier
                                    </Link>
                                    <button @click="deleteProduct(product.id)" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </SellerLayout>
</template>
