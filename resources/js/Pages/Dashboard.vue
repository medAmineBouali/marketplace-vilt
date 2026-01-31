<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Mon Compte" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mon Espace Client</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        Bienvenue, vous êtes connecté ! C'est ici que vous verrez vos futures commandes.
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-bold text-lg mb-2">Mes dernières commandes</h3>
                        <p class="text-gray-500 text-sm">Aucune commande pour le moment.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-bold text-lg mb-2">Mon Panier</h3>
                        <p class="text-gray-500 text-sm">Votre panier est vide.</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
