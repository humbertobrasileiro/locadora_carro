<template>
    <span>
        <div class="row">
            <div class="col-2">
                <label :for="id" class="form-label">{{ titulo }}</label>
            </div>
            <div class="col-10">
                <slot></slot>
            </div>
        </div>
        <div :id="idHelp" class="form-text text-muted">{{ textoAjuda }}</div>
    </span>
</template>

<script>
    export default {
        props: ['id', 'titulo', 'idHelp', 'textoAjuda']
    }
</script>

