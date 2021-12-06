<template>
<div>
    <div class="card text-center" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title">Título especial</h5>
        <p class="card-text">Com suporte a texto embaixo, que funciona como uma introdução a um conteúdo adicional.</p>
        <a href="#" class="btn btn-primary">Visitar</a>
    </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">{{ titulo }}</div>

        <div class="card-body">
            <slot name="conteudo"></slot>
        </div>

        <div class="card-footer">
            <slot name="rodape"></slot>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        props: ['titulo']
    }
</script>
