<template>
    <span>
        <label :for="id" class="form-label">{{ titulo }}</label>
        <slot></slot>
        <div :id="idHelp" class="form-text text-muted">{{ textoAjuda }}</div>
    </span>
</template>

<script>
    export default {
    }
</script>

