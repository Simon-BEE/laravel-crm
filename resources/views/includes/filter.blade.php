
<form action="" method="get" class="collapse" id="collapseExample">
    <div class="row my-2 p-3 bg-light align-items-end justify-content-end">
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
        <div class="col-md-1">
            <button type="submit" class="btn btn-secondary">Filtrer</button>
        </div>
    </div>
</form>

<div class="text-right">
    <button class="btn btn-dark" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Filtrer les résultats</button>
</div>

