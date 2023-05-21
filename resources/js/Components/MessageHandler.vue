<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div class="w-full text-center bg-red-400 text-white font-medium text-lg text-gray-700">
        <span v-if="message">{{ message }}</span>
    </div>
</template>
