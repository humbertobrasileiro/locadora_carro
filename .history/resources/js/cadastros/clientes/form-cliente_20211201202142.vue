<template>
    <!-- Modal -->
    <div class="modal fade" :id="id" tabindex="-1" :aria-labelledby="id + 'ModalLabel'" aria-hidden="true">
        <div :class="janela">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ titulo }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Alertas -->
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'titulo', 'tamanho'],
        computed: {
            janela() {
                return 'modal-dialog modal-dialog-centered ' + this.tamanho
            }
        }
    }
</script>
