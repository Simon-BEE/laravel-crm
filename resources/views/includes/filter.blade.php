
<form action="" method="get" class="collapse" id="collapseFilterPanel">
    <div class="row my-2 p-3 bg-light align-items-end justify-content-end">
        {{-- Rows --}}
        @isset($rows)
        <div class="col-md-2">
            <div class="form-row">
                <div class="col-auto my-1">
                    <label class="mr-sm-2" for="filter_rows">Éléments à afficher</label>
                    <select class="custom-select mr-sm-2" id="filter_rows" name="rows">
                        @for ($i = 10; $i <= 50; $i+=10)
                            <option value="{{ $i }}" @if(request()->rows == $i) selected @endif>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        @endisset
        {{-- Status --}}
        @isset ($statuses)
            <div class="col-md-2">
                <div class="form-row">
                    <div class="col-auto my-1">
                        <label class="mr-sm-2" for="filter_status">Par status</label>
                        <select class="custom-select mr-sm-2" id="filter_status" name="status">
                            <option value="0">Tous</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}" @if(request()->status == $status->id) selected @endif>{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endisset
        {{-- Customers --}}
        @isset ($customers)
            <div class="col-md-2">
                <div class="form-row">
                    <div class="col-auto my-1">
                        <label class="mr-sm-2" for="filter_customers">Par client</label>
                        <select class="custom-select mr-sm-2" id="filter_customers" name="customers">
                            <option value="0">Tous</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" @if(request()->customers == $customer->id) selected @endif>{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endisset
        {{-- Range price --}}
        @isset($price)
        <div class="col-md-2">
            <div class="form-row">
                <div class="col-auto my-1">
                    @php
                        $default = request()->range ?? 0;
                    @endphp
                    <label for="rangePrice" class="mb-sm-4">Montant minimum <small class="text-muted"><span id="rangePriceLabel">{{ $default }}</span>€</small></label>
                    <input type="range" class="form-control-range" name="range" id="rangePrice" min="0" max="10000" step="100" value="{{ $default }}" title="{{ $default }}">
                </div>
            </div>
        </div>
        @endisset
        {{-- Keywords --}}
        <div class="col-md-2">
            <div class="form-row">
                <div class="col-auto my-1">
                    <label class="mr-sm-2" for="filter_keywords">Mots clés</label>
                    <input type="text" class="form-control" name="keywords" id="filter_keywords" placeholder="Filtrer par mots clés..." value="{{ request()->keywords ?? '' }}">
                </div>
            </div>
        </div>
        <div class="col-md-1 row">
            <button type="submit" class="btn btn-dark">Filtrer</button>
            <a href="{{ route(Route::currentRouteName()) }}" class="btn btn-light" title="Réinitialiser"><i class="fas fa-undo-alt"></i></a>
        </div>
    </div>
</form>

<div class="text-right">
    <button class="btn btn-dark" type="button" data-toggle="collapse" data-target="#collapseFilterPanel" aria-expanded="false" aria-controls="collapseFilterPanel" id="btnFilterPanel">Filtrer les résultats</button>
</div>

@section('javascript-filter')
    <script>
        $("#collapseFilterPanel").on("show.bs.collapse", function () {
            document.getElementById('btnFilterPanel').setAttribute('disabled', 'true');
        });

        const rangeInput = document.getElementById('rangePrice')
        if (rangeInput) {
            rangeInput.addEventListener('change', function(){
                this.title = this.value;
                document.getElementById('rangePriceLabel').innerText = this.value;
            });
        }
    </script>
@endsection



