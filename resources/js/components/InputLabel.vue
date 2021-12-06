<template>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text" :for="para">{{ titulo }}</label>
        </div>
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: ['para', 'titulo']
    }
</script>
