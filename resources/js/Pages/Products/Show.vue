<script setup lang="ts">
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps<{
    product: any;
    relatedProducts: Array<any>;
}>();

const user = usePage().props.auth.user;

const cartForm = useForm({
    product_id: props.product.id,
    quantity: 1
});

const addToCart = () => {
    if (!user) {
        alert("Connectez-vous pour acheter.");
        return;
    }
    cartForm.post(route('cart.add'), {
        preserveScroll: true,
        onSuccess: () => alert('Ajouté au panier !')
    });
};
</script>

<template>
    <Head :title="product.name" />

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100">

        <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 p-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <Link :href="route('home')" class="flex items-center gap-2 text-gray-500 hover:text-indigo-600 transition">
                    &larr; Retour
                </Link>
                <Link :href="route('home')">
                    <ApplicationLogo class="h-8 w-auto fill-current text-indigo-600" />
                </Link>
                <Link v-if="user" :href="route('cart.index')" class="text-indigo-600 font-medium">
                    Panier
                </Link>
                <Link v-else :href="route('login')" class="text-indigo-600 font-medium">
                    Connexion
                </Link>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">

                <div class="flex flex-col-reverse">
                    <div class="w-full aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-100 shadow-lg">
                        <img :src="product.image" :alt="product.name" class="w-full h-full object-center object-cover">
                    </div>
                </div>

                <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                    <div class="mb-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            {{ product.category.name }}
                        </span>
                    </div>

                    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{ product.name }}</h1>

                    <div class="mt-3">
                        <h2 class="sr-only">Product information</h2>
                        <p class="text-3xl text-gray-900 dark:text-white">{{ product.price }} €</p>
                    </div>

                    <div class="mt-3 flex items-center">
                        <div class="flex items-center text-yellow-400">
                            <span v-for="i in 5" :key="i" :class="i <= Math.round(product.average_rating || 0) ? 'text-yellow-400' : 'text-gray-300'">
                                ★
                            </span>
                        </div>
                        <p class="ml-2 text-sm text-gray-500">{{ product.reviews.length }} avis</p>
                    </div>

                    <div class="mt-6">
                        <h3 class="sr-only">Description</h3>
                        <div class="text-base text-gray-700 dark:text-gray-300 space-y-6" v-html="product.description"></div>
                    </div>

                    <div class="mt-8 flex gap-4">
                        <div class="w-24">
                            <label for="quantity" class="sr-only">Quantité</label>
                            <input
                                type="number"
                                id="quantity"
                                v-model="cartForm.quantity"
                                min="1"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-white"
                            >
                        </div>
                        <PrimaryButton @click="addToCart" class="flex-1 justify-center py-3 text-base">
                            Ajouter au panier
                        </PrimaryButton>
                    </div>

                    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-8">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Vendu par</h3>
                        <div class="mt-2 flex items-center">
                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold">
                                {{ product.shop.name.charAt(0) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ product.shop.name }}</p>
                                <p class="text-xs text-gray-500">Membre depuis {{ new Date(product.shop.created_at).getFullYear() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-16 bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Avis Clients</h3>
                </div>
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    <li v-for="review in product.reviews" :key="review.id" class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-medium text-indigo-600 truncate">{{ review.user.name }}</div>
                            <div class="flex text-yellow-400 text-sm">
                                <span v-for="i in review.rating" :key="i">★</span>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">{{ review.comment }}</p>
                    </li>
                    <li v-if="product.reviews.length === 0" class="px-4 py-4 text-gray-500 text-sm text-center">
                        Aucun avis pour ce produit.
                    </li>
                </ul>
            </div>

        </main>
    </div>
</template>
