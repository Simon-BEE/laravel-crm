<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice->name }} {{ $invoice->getSerialNumber() }}</title>
</head>
<body>

    <style>
        :root{
            --main: #26A69A;
            --text: #263238;
            --light: #78909C;
        }

        *{
            margin: 0;padding: 0;
            box-sizing: border-box;
            color: var(--text);
        }

        html, body{
            height: 100%;
            min-height: 100vh;
        }

        body{
            display: flex;flex-direction: column;
            /* font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; */
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 18px;
        }

        *.text-light{
            color: var(--light);
        }

        /* Header */

        header{
            display: flex;justify-content: space-between;align-items: center;
            padding: 3.5em 0;
        }

        .top_logo{
            margin-left: 15vw;
        }

        h1{
            letter-spacing: 1px;
            font-size: 3em;
        }

        h2{
            letter-spacing: 1.5px;
            margin-top: -.6em;
        }

        .top_infos{
            text-align: right;
            margin-right: 15vw;
        }

        .subtitle{
            font-weight: lighter;
        }

        /* Main */

        main{
            flex: 1 0 auto;
        }

        /* // Address */
        section.addresses{
            background-color: #fafafa;
            display: flex;justify-content: space-between;
        }

        .address{
            padding: 4em 0;
            display: flex;flex-direction: column;
        }

        .address p{
            margin: .5em 0;
        }

        .address_from{
            width: 40%;
        }

        .address_from p{
            color: var(--light);
        }

        .address_from div{
            margin-left: 15vw;
        }

        .address_to{
            width: 60%;
            background-color: var(--main);
        }

        .address_to p, .address_to h3{
            color: #fff;
        }

        .address_to div{
            margin-right: 15vw;
            align-self: end;
            text-align: right;
        }

        /* // Table */

        section.items_table{
            margin: 0 15vw;
            display: flex;flex-direction: column;justify-content: center;
        }

        table{
            width: 100%;
            border-collapse: collapse;

        }

        table td{
            text-align: center;
        }

        table .text-left{
            text-align: left;
        }

        table .text-right{
            text-align: right;
        }

        thead tr th{
            padding: 2em 2em 1em 2em;
        }

        thead tr th:first-child{
            padding-left: 0;
        }

        thead tr th:last-child{
            padding-right: 0;
        }

        tbody td{
            padding: 1em 0;
            border-bottom: 1px solid #efefef;
        }

        tbody tr:nth-child(even){
            background-color: #fdfdfd;
        }

        tfoot .empty td{
            padding: 1.6em;
        }

        tfoot td{
            padding: 1em 0 1em;
            border-top: 1px solid #efefef;
        }

        tfoot td.no-border{
            border: none;
        }

        tfoot tr.total_price td:last-child{
            background-color: var(--main);
            padding-right: 3px;
            color: #fff;
        }

        tfoot tr.total_price .name{
            background-color: #efefef;
            padding-right: 4px;
        }

        /* // Notes */

        section.notes{
            margin: 2em 15vw;
            text-align: justify;
        }

        /* Footer */

        footer{
            padding: 1.5em 1em;
            text-align: center;
            display: flex;flex-direction: column;align-items: center;justify-content: center;
        }

        section.main_footer{
            border-top: 1px solid #efefef;
            margin-top: 1em;
            padding-top: 1em;
        }

        .main_footer p:not(:last-child){
            margin-bottom: .4em;
        }

        .main_footer p span{
            margin: 0 .4em;
        }
    </style>

    <header>
        <div class="top_logo">
            <h1>SKYMON.fr</h1>
            <h2 class="subtitle text-light">Développement WEB</h2>
        </div>

        <div class="top_infos">
            <h3>{{ $invoice->name }} #{{ $invoice->getSerialNumber() }}</h3>
            <h4 class="subtitle text-light">{{ $invoice->getDate() }}</h4>
        </div>
    </header>

    <main>
        <section class="addresses">
            <div class="address address_from">
                <div>
                    <h3>{{ $invoice->seller->name }}</h3>
                    <p>{!! $invoice->seller->address !!}</p>
                    @foreach($invoice->seller->custom_fields as $key => $value)
                        <p class="seller-custom-field">
                            {{ ucfirst($key) }}: {{ $value }}
                        </p>
                    @endforeach
                </div>
            </div>
            <div class="address address_to">
                <div>
                    <h3>{{ $invoice->buyer->name }}</h3>
                    <p>{!! $invoice->buyer->address !!}</p>
                    @foreach($invoice->buyer->custom_fields as $key => $value)
                        <p class="buyer-custom-field">
                            {{ ucfirst($key) }}: {{ $value }}
                        </p>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="items_table">
            <table>
                <thead>
                    <tr>
                        <th scope="col" class="text-left">{{ __('invoices::invoice.description') }}</th>
                        <th scope="col">{{ __('invoices::invoice.quantity') }}</th>
                        @if($invoice->hasItemUnits)
                            <th>{{ __('invoices::invoice.units') }}</th>
                        @endif
                        <th scope="col">{{ __('invoices::invoice.price') }}</th>
                        @if($invoice->hasItemDiscount)
                            <th scope="col">{{ __('invoices::invoice.discount') }}</th>
                        @endif
                        @if($invoice->hasItemTax)
                            <th scope="col">{{ __('invoices::invoice.tax') }}</th>
                        @endif
                        <th scope="col">{{ __('invoices::invoice.sub_total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- <tr>
                        <td class="text-left">Adipisicing elit. Corrupti, voluptates.</td>
                        <td>2</td>
                        <td>heure</td>
                        <td class="text-light">45,00 €</td>
                        <td class="text-right">90,00 €</td>
                    </tr> --}}
                    {{-- Items --}}
                    @foreach($invoice->items as $item)
                        <tr>
                            <td class="text-left">{{ $item->title }}</td>
                            <td>{{ $item->quantity }}</td>
                            @if($invoice->hasItemUnits)
                                <td>{{ $item->units }}</td>
                            @endif
                            <td class="text-light">
                                {{ $invoice->formatCurrency($item->price_per_unit) }}
                            </td>
                            @if($invoice->hasItemDiscount)
                                <td class="text-light">
                                    {{ $invoice->formatCurrency($item->discount) }}
                                </td>
                            @endif
                            @if($invoice->hasItemTax)
                                <td class="text-light">
                                    {{ $invoice->formatCurrency($item->tax) }}
                                </td>
                            @endif
                            <td class="text-right">
                                {{ $invoice->formatCurrency($item->sub_total_price) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    {{-- <tr class="empty">
                        <td colspan="5"></td>
                    </tr>
                    <tr class="taxable_amount">
                        <td class="no-border" colspan="3"></td>
                        <td class="name text-right">Montant taxable</td>
                        <td class="text-right">120,00 €</td>
                    </tr>
                    <tr class="tax_rates">
                        <td class="no-border" colspan="3"></td>
                        <td class="name text-right">Taux de taxe</td>
                        <td class="text-right">20%</td>
                    </tr>
                    <tr class="total_tax">
                        <td class="no-border" colspan="3"></td>
                        <td class="name text-right">Montant des taxes</td>
                        <td class="text-right">20,00 €</td>
                    </tr>
                    <tr class="total_price">
                        <td class="no-border" colspan="3"></td>
                        <td class="name text-right">Montant total à payer</td>
                        <td class="text-right">650,25 €</td>
                    </tr> --}}
                    {{-- Summary --}}
                    <tr class="empty">
                        <td colspan="{{ $invoice->table_columns }}"></td>
                    </tr>
                    @if($invoice->hasItemOrInvoiceDiscount())
                        <tr>
                            <td colspan="{{ $invoice->table_columns - 2 }}" class="no-border"></td>
                            <td class="text-right name">{{ __('invoices::invoice.total_discount') }}</td>
                            <td class="text-right">
                                {{ $invoice->formatCurrency($invoice->total_discount) }}
                            </td>
                        </tr>
                    @endif
                    @if($invoice->taxable_amount)
                        <tr class="taxable_amount">
                            <td colspan="{{ $invoice->table_columns - 2 }}" class="no-border"></td>
                            <td class="text-right name">{{ __('invoices::invoice.taxable_amount') }}</td>
                            <td class="text-right">
                                {{ $invoice->formatCurrency($invoice->taxable_amount) }}
                            </td>
                        </tr>
                    @endif
                    @if($invoice->tax_rate)
                        <tr class="tax_rates">
                            <td colspan="{{ $invoice->table_columns - 2 }}" class="no-border"></td>
                            <td class="text-right name">{{ __('invoices::invoice.tax_rate') }}</td>
                            <td class="text-right">
                                {{ $invoice->tax_rate }}%
                            </td>
                        </tr>
                    @endif
                    @if($invoice->hasItemOrInvoiceTax())
                        <tr class="total_tax">
                            <td colspan="{{ $invoice->table_columns - 2 }}" class="no-border"></td>
                            <td class="text-right name">{{ __('invoices::invoice.total_taxes') }}</td>
                            <td class="text-right">
                                {{ $invoice->formatCurrency($invoice->total_taxes) }}
                            </td>
                        </tr>
                    @endif
                    @if($invoice->shipping_amount)
                        <tr>
                            <td colspan="{{ $invoice->table_columns - 2 }}" class="no-border"></td>
                            <td class="text-right name">{{ __('invoices::invoice.shipping') }}</td>
                            <td class="text-right">
                                {{ $invoice->formatCurrency($invoice->shipping_amount) }}
                            </td>
                        </tr>
                    @endif
                    <tr class="total_price">
                        <td colspan="{{ $invoice->table_columns - 2 }}" class="no-border"></td>
                        <td class="text-right pl-0">{{ __('invoices::invoice.total_amount') }}</td>
                        <td class="text-right pr-0 total-amount">
                            {{ $invoice->formatCurrency($invoice->total_amount) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </section>

        <section class="notes">
            @if ($invoice->notes)
                <h4>Informations complémentaires:</h4>
                {{-- <p>{{ trans('invoices::invoice.notes') }}: {!! $invoice->notes !!}</p> --}}
                <p>{!! $invoice->notes !!}</p>
            @endif
        </section>

    </main>


    <footer>
        <section class="due_date">
            <p>Nous vous invitons à effectuer le réglement avant le {{ $invoice->getPayUntilDate() }}</p>
        </section>
        <section class="main_footer">
            <p>
                <span><strong>{{ $invoice->name }}</strong> n°{{ $invoice->getSerialNumber() }}</span>
                <span><strong>Email</strong> contact@skymon.fr</span>
                <span><strong>Téléphone</strong> 0617841434</span>
            </p>
            <p>
                <span><strong>Société</strong> SKYMON.fr</span>
                <span><strong>N°Siret</strong> 45665798954</span>
                <span><strong>N°TVA</strong> 78784564</span>
            </p>
            <p>
                <span><strong>Banque</strong> SHINE</span>
                <span><strong>Titulaire du compte</strong> Simon Bée</span>
                <span><strong>IBAN</strong> FR76 4589 6446 1236 21</span>
            </p>
        </section>
    </footer>

    <script type="text/php">
        if (isset($pdf) && $PAGE_COUNT > 1) {
            $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Verdana");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width);
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>
</html>
