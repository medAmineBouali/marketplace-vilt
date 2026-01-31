<script setup lang="ts">
import {Head, Link} from '@inertiajs/vue3';
import SellerLayout from '@/Layouts/SellerLayout.vue';

defineProps<{
    auth: any
}>();
</script>

<template>
    <Head title="Vendeur Dashboard" />

    <SellerLayout>
        <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Tableau de bord Vendeur</h1>
                </div>
                <div class="flex justify-between items-center mb-6 px-4 pt-6">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Mon Tableau de Bord</h1>
                    <Link
                        :href="route('seller.products.create')"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow"
                    >
                        + Ajouter un produit
                    </Link>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Ventes</h3>
                        <p class="text-2xl text-blue-600 dark:text-blue-400">0 €</p>
                    </div>
                    <div class="p-4 bg-green-50 border border-green-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Commandes</h3>
                        <p class="text-2xl text-green-600 dark:text-green-400">0</p>
                    </div>
                    <div class="p-4 bg-purple-50 border border-purple-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Produits</h3>
                        <p class="text-2xl text-purple-600 dark:text-purple-400">0</p>
                    </div>
                </div>
            </div>
        </div>
    </SellerLayout>
</template>
