<template>
    <div class="form-group">
        <label :for="id" class="form-label">{{ titulo }}</label>
</template>

<script>
    export default {
        props: ['id', 'titulo']
    }
</script>
