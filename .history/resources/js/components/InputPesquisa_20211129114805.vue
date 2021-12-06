<template>
    <span>
        <label :for="id" class="form-label">{{ titulo }}</label>
        <slot></slot>
        {{ textoAjuda }}
    </span>
</template>

<script>
    export default {
        props: ['id', 'titulo', 'idHelp', 'textoAjuda']
    }
</script>

