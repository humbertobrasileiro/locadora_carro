<template>
    <!-- Modal -->
    <div class="modal fade" :id="id" tabindex="-1" :aria-labelledby="id + 'ModalLabel'" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            {{ $storre.state.pagina }}
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ titulo }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Alertas -->
                <slot name="alertas"></slot>
                <slot name="conteudo"></slot>
            </div>
            <div class="modal-footer">
                <slot name="rodape"></slot>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'titulo', 'pagina'],
        data() {
            $store.state.pagina = pagina
        }
    }
</script>
