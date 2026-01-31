<script setup>
defineProps({
    className: {
        type: String,
        default: 'h-12 w-auto' // Taille par défaut
    }
});
</script>

<template>
    <img
        src="/images/marketplaceLogo.png"
        alt="Logo Marketplace"
        :class="className"
        class="object-contain"
    />
</template>
