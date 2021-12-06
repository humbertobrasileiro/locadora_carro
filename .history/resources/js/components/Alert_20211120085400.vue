<template>
    <div class="alert alert-success" role="alert">
        A simple success alert—check it out!
        {{ tipo }}
    </div>
</template>

<script>
    export default {
        props: ['tipo']
    }
</script>
