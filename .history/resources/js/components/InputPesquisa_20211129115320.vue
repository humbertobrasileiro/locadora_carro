<template>
    <span>
        <div class="row">
            <div class="col-2">
                <label :for="id" class="form-label">{{ titulo }}</label>
            </div>
            <div class="col-10">
                <slot></slot> {{ textoAjuda }}
            </div>
        </div>
    </span>
</template>

<script>
    export default {
        props: ['id', 'titulo', 'idHelp', 'textoAjuda']
    }
</script>

