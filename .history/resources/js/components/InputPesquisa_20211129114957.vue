<template>
    <span>
        <div class="row">
            <div class="col-1">
                <label :for="id" class="form-label">{{ titulo }}</label>
            </div>
            <div class="col-11">
                <slot></slot>
            </div>
        {{ textoAjuda }}
    </span>
</template>

<script>
    export default {
        props: ['id', 'titulo', 'idHelp', 'textoAjuda']
    }
</script>

