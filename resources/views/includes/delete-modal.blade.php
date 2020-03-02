@section('modal')
    <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDelete" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmer la suppression ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Etes-vous sûr de vouloir supprimer cet élément ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelling">Annuler</button>
                    <button type="button" class="btn btn-info" id="confirming">Confirmer</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmAction(e) {
            e.preventDefault();
            $('#confirmDelete').modal('show');
            document.getElementById('cancelling').onclick = () => {
                $('#confirmDelete').modal('hide');
            };
            document.getElementById('confirming').onclick = () => {
                e.target.submit();
            };
        }
    </script>
@endsection
