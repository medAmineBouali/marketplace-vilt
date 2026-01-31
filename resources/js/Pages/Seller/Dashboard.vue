<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import SellerLayout from '@/Layouts/SellerLayout.vue';

// Define the props coming from the Controller
defineProps<{
    auth: any;
    shop: any;
    sales: Array<any>;
    stats: {
        revenue: number;
        sold_items: number;
        orders_count: number;
    };
}>();

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('fr-FR', {
        day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit'
    });
};
</script>

<template>
    <Head title="Vendeur Dashboard" />

    <SellerLayout>
        <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4 flex justify-between items-center">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Tableau de bord Vendeur</h1>
                    <Link
                        :href="route('seller.products.create')"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow text-sm"
                    >
                        + Ajouter un produit
                    </Link>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 p-4">
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Chiffre d'Affaires</h3>
                <p class="text-2xl text-blue-600 dark:text-blue-400 font-mono">{{ stats.revenue.toFixed(2) }} €</p>
            </div>
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Articles Vendus</h3>
                <p class="text-2xl text-green-600 dark:text-green-400 font-mono">{{ stats.sold_items }}</p>
            </div>
            <div class="p-4 bg-purple-50 border border-purple-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Commandes Uniques</h3>
                <p class="text-2xl text-purple-600 dark:text-purple-400 font-mono">{{ stats.orders_count }}</p>
            </div>
        </div>

        <div class="p-4">
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800 overflow-hidden">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Historique des Ventes</h3>
                </div>

                <div v-if="sales.length === 0" class="p-8 text-center text-gray-500">
                    Aucune vente enregistrée pour le moment.
                </div>

                <div v-else class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Produit</th>
                            <th scope="col" class="px-4 py-3">Acheteur</th>
                            <th scope="col" class="px-4 py-3">Date</th>
                            <th scope="col" class="px-4 py-3 text-right">Montant</th>
                            <th scope="col" class="px-4 py-3 text-center">Statut</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="sale in sales" :key="sale.id" class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white flex items-center gap-3">
                                <img :src="sale.product?.image || 'https://via.placeholder.com/40'" class="w-10 h-10 rounded object-cover">
                                <span>
                                        {{ sale.product?.name }}
                                        <span class="block text-xs text-gray-500">Qté: {{ sale.quantity }}</span>
                                    </span>
                            </td>
                            <td class="px-4 py-3">
                                {{ sale.order?.user?.name || 'Inconnu' }}
                            </td>
                            <td class="px-4 py-3">
                                {{ formatDate(sale.created_at) }}
                            </td>
                            <td class="px-4 py-3 text-right font-bold text-indigo-600">
                                {{ (sale.price * sale.quantity).toFixed(2) }} €
                            </td>
                            <td class="px-4 py-3 text-center">
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                        Payé
                                    </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </SellerLayout>
</template>
