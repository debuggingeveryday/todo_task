<script setup lang="ts">
const value = defineModel();

const props = defineProps<{
    options: any;
}>();
</script>

<template>
    <select id="user-type" class="" v-model="value">
        <option v-for="(item, index) in props.options" :key="index" :value="item.value">
            {{ item.label }}
        </option>
    </select>
</template>
