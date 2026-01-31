<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, Link, useForm , router} from '@inertiajs/vue3';

defineProps<{
    cartItems: Array<any>;
    grandTotal: number;
}>();

const form = useForm({
    product_id: null,
});

const removeItem = (id: number) => {
    form.product_id = id;
    form.post(route('cart.remove'));
};


const checkout = () => {
    if (confirm("Voulez-vous confirmer votre commande ?")) {
        router.post(route('cart.checkout'));
    }
};
</script>

<template>
    <Head title="Mon Panier" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Mon Panier</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <div v-if="cartItems.length === 0" class="text-center py-10">
                            <p class="text-gray-500 text-lg mb-4">Votre panier est vide.</p>
                            <Link :href="route('home')" class="text-indigo-600 hover:underline">
                                Retourner à la boutique
                            </Link>
                        </div>

                        <div v-else>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="pb-3">Produit</th>
                                        <th class="pb-3">Prix</th>
                                        <th class="pb-3">Quantité</th>
                                        <th class="pb-3 text-right">Total</th>
                                        <th class="pb-3"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="item in cartItems" :key="item.id" class="group">
                                        <td class="py-4 flex items-center gap-4">
                                            <img :src="item.image" class="w-16 h-16 rounded object-cover bg-gray-100" />
                                            <span class="font-medium">{{ item.name }}</span>
                                        </td>
                                        <td class="py-4">{{ item.price }} €</td>
                                        <td class="py-4">{{ item.quantity }}</td>
                                        <td class="py-4 text-right font-bold">{{ item.total_price.toFixed(2) }} €</td>
                                        <td class="py-4 text-right">
                                            <button
                                                @click="removeItem(item.id)"
                                                class="text-red-500 hover:text-red-700 text-sm font-medium"
                                            >
                                                Retirer
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-8 flex justify-end items-center gap-6 border-t pt-6 border-gray-200 dark:border-gray-700">
                                <div class="text-xl">
                                    Total: <span class="font-bold text-indigo-600">{{ grandTotal.toFixed(2) }} €</span>
                                </div>

                                <PrimaryButton @click="checkout" :disabled="cartItems.length === 0">
                                    Passer la commande
                                </PrimaryButton>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
