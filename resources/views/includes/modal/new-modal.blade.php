<div class="modal fade" id="elementModal" tabindex="-1" role="dialog" aria-labelledby="elementModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalElement">Ajout d'un nouvel élément: {{ $name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route($route) }}" method="post" id="formElement">
                @csrf
                {{-- @method('PATCH') --}}
                <div class="modal-body">
                    @include('includes.form.input', [
                        'name' => 'name',
                        'type' => 'text',
                        'label' => 'Nom',
                        'placeholder' => 'Le nom de l\'élément',
                        'property' => null,
                        'helper' => null,
                        'required' => true
                    ])
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" id="sending">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script defer>
    const formElement = document.getElementById('formElement');
    const storeAction = formElement.action;

    window.addEventListener('load', function(){
        $("#elementModal").on("hidden.bs.modal", function () {
            formElement.action = storeAction;
        });
    });

    function showModalElement(e, editName = null, editId = null) {
        e.preventDefault();
        if (editName && editId) {

            formElement.action = `${formElement.action}/${editId}`
            document.getElementById('name').value = editName;
            document.getElementById('titleModalElement').innerText = 'Edition de l\'élément: ' + editName;

            const newInput = document.createElement('input');
            newInput.type ='hidden';
            newInput.name = '_method';
            newInput.value = 'PATCH';
            formElement.appendChild(newInput);
        }
        $('#elementModal').modal('show');
    }
</script>
