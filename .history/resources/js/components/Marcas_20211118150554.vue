<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Busca de Marcas</div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="inputID" class="form-label">ID</label>
                            <input type="number" class="form-control" id="inputID" aria-describedby="idHelp" placeholder="ID">
                            <div id="idHelp" class="form-text">Opcional. Informe o ID do registro</div>
                        </div>
                        <div class="mb-3">
                            <label for="inputNome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca">
                            <div id="nomeHelp" class="form-text">Opcional. Informe o nome da marca</div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
</script>
