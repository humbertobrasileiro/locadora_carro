<template>
    <div class="form-group">
        <label :for="id" class="form-label">{{ titulo }}</label>
    </div>
</template>

<script>
    export default {
        props: ['id', 'titulo']
    }
</script>
