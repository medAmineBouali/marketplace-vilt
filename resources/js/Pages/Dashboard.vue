<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Order } from '@/types'; // Importing your types

// Define the props coming from the Controller
defineProps<{
    orders: Order[];
}>();

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('fr-FR', {
        year: 'numeric', month: 'long', day: 'numeric'
    });
};
</script>

<template>
    <Head title="Mes Commandes" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Mon Historique d'Achats</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div v-if="orders.length === 0" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500">
                    Vous n'avez pas encore passé de commande.
                </div>

                <div v-else class="space-y-6">
                    <div v-for="order in orders" :key="order.id" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">

                            <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">Commande #{{ order.transaction_id }}</p>
                                    <p class="font-bold">{{ formatDate(order.created_at) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-bold text-indigo-600">{{ order.total_price }} €</p>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 capitalize">
                                        {{ order.status }}
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div v-for="item in order.items" :key="item.id" class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <img :src="item.product?.image || 'https://via.placeholder.com/50'" class="w-12 h-12 rounded object-cover" alt="Product">
                                        <div>
                                            <p class="font-medium">{{ item.product?.name || 'Produit supprimé' }}</p>
                                            <p class="text-sm text-gray-500">Qté: {{ item.quantity }}</p>
                                        </div>
                                    </div>
                                    <p class="font-medium">{{ item.price }} €</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
