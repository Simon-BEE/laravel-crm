<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture n°125654</title>
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
            color: #263238;
        }

        html, body{
            height: 100%;
            min-height: 100vh;
            width: 100vw;
        }

        body{
            display: flex;flex-direction: column;
            /* font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; */
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 12px;
            overflow-x: scroll
        }

        *.text-light{
            color: #78909C;
        }

        /* Header */

        header{
            margin: 4em 5em;
        }

        .top_logo{
        }

        h1{
            letter-spacing: 1px;
            font-size: 3em;
        }

        h2{
            letter-spacing: 1.5px;
            margin-top: -.2em;
        }

        .top_infos{
            margin-top: -2em;
            text-align: right;
        }

        .subtitle{
            font-weight: lighter;
        }

        /* Main */

        main{
            flex: 1 0 auto;
        }

        /* // Address */
        .addresses{
            background-color: #fafafa;
            height: 10em;
            /* padding: 2em 5em 1em 5em; */
        }

        .address div{
            margin-top: 1.5em;
        }

        .address p{
            margin: .5em 0;
        }

        .address_from{
            float: right
            width: 40%;

        }

        .address p{
            color: #78909C;
        }
        .address_to p{
            color: #fff;
        }

        .address_from div{
            margin-left: 5em;
        }

        .address_to{
            float: right;
            background-color: #26A69A;
            height: 10em;
            width: 60%;
        }

        .address_to div{
            margin-right: 5em;
            text-align: right;
        }

        /* // Table */

        .items_table{
            margin: 0 4em;
            display: flex;flex-direction: column;justify-content: center;
        }

        table{
            width: 100%;
            border-collapse: collapse;

        }

        .main_table td{
            text-align: center;
        }

        .main_table .text-left{
            text-align: left;
        }

        .main_table .text-right{
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
            background-color: #26A69A;
            padding-right: 3px;
            color: #fff;
        }

        tfoot tr.total_price .name{
            background-color: #efefef;
            padding-right: 4px;
        }

        /* // Notes */

        .notes{
            margin: 2em 5em;
            text-align: justify;
        }

        /* Footer */

        footer{
            padding: 1.5em 1em;
            text-align: center;
            /* display: flex;flex-direction: column;align-items: center;justify-content: center; */
            position: absolute;
            bottom: 5px;
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
            <h3>Facture #125654</h3>
            <h4 class="subtitle text-light">25 Juillet 2020</h4>
        </div>
    </header>

    <main>
        <section class="addresses">
            <div class="address address_from">
                <div>
                    <h3>Simon Bée</h3>
                    <p>38 Nobel Freeway</p>
                    <p>Marseille 13100, France</p>
                </div>
            </div>
            <div class="address address_to">
                <div>
                    <h3>Jean Raton</h3>
                    <p>3 rue de fraises</p>
                    <p>Marseille 13100, France</p>
                </div>
            </div>
        </section>

        <section class="items_table">
            <table class="main_table">
                <thead>
                    <tr>
                        <th class="text-left">Description</th>
                        <th>Quantité</th>
                        <th>Unité</th>
                        <th>Prix unitaire</th>
                        <th class="text-right">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-left">Adipisicing elit. Corrupti, voluptates.</td>
                        <td>2</td>
                        <td>heure</td>
                        <td class="text-light">45,00 €</td>
                        <td class="text-right">90,00 €</td>
                    </tr>
                    <tr>
                        <td class="text-left">Adipisicing elit. Corrupti, voluptates.</td>
                        <td>2</td>
                        <td>heure</td>
                        <td class="text-light">45,00 €</td>
                        <td class="text-right">90,00 €</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="empty">
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
                    </tr>
                </tfoot>
            </table>
        </section>

        <section class="notes">
            <h4>Informations complémentaires:</h4>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam ipsa temporibus reprehenderit impedit magni officia neque et est repellat possimus sequi facilis laudantium alias mollitia, molestias delectus repudiandae fugit excepturi. Exercitationem culpa explicabo non blanditiis.</p>
        </section>

    </main>


    <footer>
        <section class="due_date">
            <p>A réception de cette facture, vous avez un mois afin de procéder au réglement.</p>
        </section>
        <section class="main_footer">
            <p>
                <span><strong>Facture</strong> n°125654</span>
                <span><strong>Email</strong> mail@hihi.fr</span>
                <span><strong>Téléphone</strong> 0615457895</span>
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

</body>
</html>
