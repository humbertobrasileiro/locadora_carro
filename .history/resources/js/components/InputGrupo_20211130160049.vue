<template>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <slot></slot>
            </div>
        </div>
        <input readonly type="text" class="form-control" :aria-label="label" :value="titulo">
    </div>
</template>

<script>
    export default {
        props: ['label', 'titulo']
    }
</script>
