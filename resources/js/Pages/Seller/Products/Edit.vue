<script setup lang="ts">
import SellerLayout from '@/Layouts/SellerLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    product: any;
    categories: Array<{ id: number; name: string }>;
}>();

const form = useForm({
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    stock_quantity: props.product.stock_quantity,
    category_id: props.product.category_id,
    image_url: props.product.image,
});

const submit = () => {
    form.put(route('seller.products.update', props.product.id));
};
</script>

<template>
    <Head title="Modifier le produit" />

    <SellerLayout>
        <div class="max-w-4xl mx-auto py-6 px-4">
            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Modifier : {{ product.name }}</h1>

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
                        <InputError :message="form.errors.image_url" class="mt-2" />
                    </div>

                    <div v-if="form.image_url" class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Aperçu actuel :</p>
                        <img :src="form.image_url" class="h-40 w-40 object-cover rounded-lg border border-gray-300" alt="Preview" />
                    </div>

                    <div class="flex justify-end gap-4">
                        <Link :href="route('seller.products.index')" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                            Annuler
                        </Link>
                        <PrimaryButton :disabled="form.processing">
                            Mettre à jour
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </SellerLayout>
</template>
