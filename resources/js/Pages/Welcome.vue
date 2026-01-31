<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();

// Données fictives pour la maquette (en attendant la DB)
const categories = [
    { name: 'Électronique', icon: '💻' },
    { name: 'Mode', icon: '👕' },
    { name: 'Maison', icon: '🏠' },
    { name: 'Beauté', icon: '💄' },
    { name: 'Sport', icon: '⚽' },
    { name: 'Jouets', icon: '🧸' },
];

const featuredProducts = [
    { id: 1, name: 'Montre Connectée', price: '129.00 €', image: 'https://placehold.co/400x300?text=Watch', category: 'Électronique' },
    { id: 2, name: 'Sac à dos Urbain', price: '45.00 €', image: 'https://placehold.co/400x300?text=Bag', category: 'Mode' },
    { id: 3, name: 'Casque Audio Pro', price: '199.00 €', image: 'https://placehold.co/400x300?text=Headphones', category: 'Électronique' },
    { id: 4, name: 'Chaussures Running', price: '89.00 €', image: 'https://placehold.co/400x300?text=Shoes', category: 'Sport' },
];
</script>

<template>
    <Head title="Bienvenue sur MarketPlace" />

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

        <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center">
                        <Link href="/" class="flex items-center gap-2">
                            <ApplicationLogo class="h-8 w-auto fill-current text-indigo-600" />
                            <span class="font-bold text-xl tracking-tight hidden sm:block">MarketPlace</span>
                        </Link>
                    </div>

                    <div class="hidden md:flex flex-1 mx-10">
                        <div class="relative w-full">
                            <input type="text" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg pl-4 pr-10 py-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Rechercher un produit, une marque...">
                            <button class="absolute right-2 top-2 text-gray-400 hover:text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 font-medium">
                            Mon Compte
                        </Link>
                        <template v-else>
                            <Link :href="route('login')" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 font-medium">
                                Connexion
                            </Link>
                            <Link v-if="canRegister" :href="route('register')" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                                S'inscrire
                            </Link>
                        </template>

                        <button class="relative p-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 5.408c.63 2.708-.192 4.648-2.36 5.378a11.275 11.275 0 0 1-13.013-1.428c-1.873-1.874-2.14-4.814-1.282-7.593.593-1.92 2.228-3.328 4.228-3.64l.87-.135" />
                            </svg>
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">0</span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <div class="relative bg-white dark:bg-gray-800 overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-white dark:bg-gray-800 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                    <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                                <span class="block xl:inline">La meilleure place pour</span>
                                <span class="block text-indigo-600 xl:inline"> acheter et vendre.</span>
                            </h1>
                            <p class="mt-3 text-base text-gray-500 dark:text-gray-400 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                Découvrez des milliers de produits uniques. Vendeurs certifiés, paiements sécurisés et livraison rapide partout dans le monde.
                            </p>
                            <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                <div class="rounded-md shadow">
                                    <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                        Commencer vos achats
                                    </a>
                                </div>
                                <div class="mt-3 sm:mt-0 sm:ml-3">
                                    <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10">
                                        Devenir Vendeur
                                    </a>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full opacity-80" src="https://images.unsplash.com/photo-1483985988355-763728e1935b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Shopping">
            </div>
        </div>

        <div class="py-12 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Parcourir par catégorie</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    <div v-for="cat in categories" :key="cat.name" class="flex flex-col items-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-md transition cursor-pointer border border-gray-100 dark:border-gray-700">
                        <span class="text-3xl mb-2">{{ cat.icon }}</span>
                        <span class="font-medium text-gray-700 dark:text-gray-300">{{ cat.name }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Produits à la une</h2>
                    <a href="#" class="text-indigo-600 hover:text-indigo-500 font-medium">Voir tout &rarr;</a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="product in featuredProducts" :key="product.id" class="group relative bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-lg transition">
                        <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-t-lg bg-gray-200 group-hover:opacity-75 h-48">
                            <img :src="product.image" :alt="product.name" class="h-full w-full object-cover object-center">
                        </div>
                        <div class="p-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ product.category }}</p>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                <a href="#">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ product.name }}
                                </a>
                            </h3>
                            <div class="flex items-center justify-between mt-4">
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ product.price }}</p>
                                <button class="z-10 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white p-2 rounded-full hover:bg-indigo-600 hover:text-white transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 mt-12">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-base text-gray-400">
                    &copy; 2026 Marketplace VILT. Tous droits réservés. Projet Universitaire.
                </p>
            </div>
        </footer>
    </div>
</template>
