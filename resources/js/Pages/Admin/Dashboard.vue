<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

// Props passed from DashboardController
defineProps<{
    stats: {
        total_users: number;
        total_shops: number;
        total_orders: number;
        total_revenue: number;
    };
    recentOrders: Array<any>;
    recentShops: Array<any>;
}>();

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('fr-FR', {
        day: 'numeric', month: 'short', year: 'numeric'
    });
};
</script>

<template>
    <Head title="Admin Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Administration Globale
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                        <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-bold tracking-wider">Revenu Total</div>
                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ stats.total_revenue.toFixed(2) }} €</div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                        <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-bold tracking-wider">Commandes</div>
                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ stats.total_orders }}</div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                        <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-bold tracking-wider">Boutiques Actives</div>
                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ stats.total_shops }}</div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                        <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-bold tracking-wider">Utilisateurs</div>
                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ stats.total_users }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Dernières Commandes</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Client</th>
                                    <th class="px-4 py-3">Total</th>
                                    <th class="px-4 py-3">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="order in recentOrders" :key="order.id" class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 font-mono text-xs">#{{ order.transaction_id.substring(0, 8) }}</td>
                                    <td class="px-4 py-3">{{ order.user?.name }}</td>
                                    <td class="px-4 py-3 font-bold text-indigo-600">{{ order.total_price }} €</td>
                                    <td class="px-4 py-3">{{ formatDate(order.created_at) }}</td>
                                </tr>
                                <tr v-if="recentOrders.length === 0">
                                    <td colspan="4" class="px-4 py-8 text-center">Aucune commande.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Dernières Boutiques</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">Boutique</th>
                                    <th class="px-4 py-3">Vendeur</th>
                                    <th class="px-4 py-3">Statut</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="shop in recentShops" :key="shop.id" class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ shop.name }}</td>
                                    <td class="px-4 py-3">{{ shop.seller?.name }}</td>
                                    <td class="px-4 py-3">
                                        <span v-if="shop.is_active" class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Actif</span>
                                        <span v-else class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Inactif</span>
                                    </td>
                                </tr>
                                <tr v-if="recentShops.length === 0">
                                    <td colspan="3" class="px-4 py-8 text-center">Aucune boutique.</td>
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
