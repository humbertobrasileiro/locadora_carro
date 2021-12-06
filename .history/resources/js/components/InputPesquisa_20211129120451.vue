<template>
    <span>
        <div class="row">
            <div class="col-4">
                <label :for="id" class="form-label">{{ titulo }}</label>
            </div>
            <div class="col-8">
                <slot></slot>
            </div>
        </div>
        <div :id="idHelp" class="form-text text-muted" style="background: gray">{{ textoAjuda }}</div>
    </span>
</template>

<script>
    export default {
        props: ['id', 'titulo', 'idHelp', 'textoAjuda']
    }
</script>

