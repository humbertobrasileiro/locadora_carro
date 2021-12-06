<template>
    <!-- Modal -->
    <div class="modal fade" :id="id" tabindex="-1" :aria-labelledby="id + 'ModalLabel'" aria-hidden="true">
        <div>{{ tipo }}</div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'tipo', 'campos']
    }
</script>
