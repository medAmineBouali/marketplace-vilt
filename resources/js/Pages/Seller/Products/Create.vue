<script setup lang="ts">
import SellerLayout from '@/Layouts/SellerLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps<{
    categories: Array<{ id: number; name: string }>;
}>();

const form = useForm({
    name: '',
    description: '',
    price: '',
    stock_quantity: '',
    category_id: '',
    image_url: 'https://loremflickr.com/640/480/tech', // Default placeholder
});

const submit = () => {
    form.post(route('seller.products.store'));
};
</script>

<template>
    <Head title="Ajouter un produit" />

    <SellerLayout>
        <div class="max-w-4xl mx-auto py-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Ajouter un nouveau produit</h1>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <form @submit.prevent="submit" class="space-y-6">

                    <div>
                        <InputLabel for="name" value="Nom du produit" />
                        <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="category" value="Catégorie" />
                        <select
                            id="category"
                            v-model="form.category_id"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required
                        >
                            <option value="" disabled>Choisir une catégorie</option>
                            <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                                {{ cat.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.category_id" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="description" value="Description" />
                        <textarea
                            id="description"
                            v-model="form.description"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm h-32"
                            required
                        ></textarea>
                        <InputError :message="form.errors.description" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <InputLabel for="price" value="Prix (€)" />
                            <TextInput id="price" v-model="form.price" type="number" step="0.01" class="mt-1 block w-full" required />
                            <InputError :message="form.errors.price" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="stock" value="Quantité en stock" />
                            <TextInput id="stock" v-model="form.stock_quantity" type="number" class="mt-1 block w-full" required />
                            <InputError :message="form.errors.stock_quantity" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <InputLabel for="image" value="URL de l'image" />
                        <TextInput id="image" v-model="form.image_url" type="url" class="mt-1 block w-full" required />
                        <p class="text-sm text-gray-500 mt-1">Utilisez une URL d'image valide (ex: Unsplash, LoremFlickr).</p>
                        <InputError :message="form.errors.image_url" class="mt-2" />
                    </div>

                    <div v-if="form.image_url" class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Aperçu :</p>
                        <img :src="form.image_url" class="h-40 w-40 object-cover rounded-lg border border-gray-300" alt="Preview" />
                    </div>

                    <div class="flex justify-end">
                        <PrimaryButton :disabled="form.processing">
                            Publier le produit
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </SellerLayout>
</template>
