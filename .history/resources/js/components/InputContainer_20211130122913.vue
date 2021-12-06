<template>
    <div>
        <div class="form-group" v-if="tipo == 'N'">
            <label :for="id" class="form-label">{{ titulo }}</label>
            <slot></slot>
            <div :id="idHelp" class="form-text text-muted">{{ textoAjuda }}</div>
        </div>

        <div class="input-group mb-3" v-if="tipo == 'C'">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="checkbox" aria-label="Chebox para permitir input text">
                </div>
            </div>
            <input  type="text" class="form-control" :aria-label="textoAjuda" :value="titulo">
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'titulo', 'idHelp', 'textoAjuda', 'tipo']
    }
</script>
