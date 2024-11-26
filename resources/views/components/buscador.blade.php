<div id="buscador">
    <form action="{{ $action }}" method="{{ $method }}" class="row mb-3">
        <div class="input-group" role="group">
            <input name="palabra" placeholder="Introduce aquí el elemento a buscar..." type="text" class="col form-control" value="{{ $palabra }}">
            <a class="col-1 btn btn-outline-primary" href="javascript:void(0);" role="button" onclick="this.closest('form').submit();"><i class="bi bi-search"></i></a>
        </div>
    </form>
</div>