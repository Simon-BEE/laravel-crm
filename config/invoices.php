<?php

return [
    'date' => [
        /**
         * Carbon date format
         */
        'format'         => 'd/m/Y',
        /**
         * Due date for payment since invoice's date.
         */
        'pay_until_days' => 30,
    ],

    'serial_number' => [
        'series'           => 'F' . date('Ym'),
        'sequence'         => 1,
        /**
         * Sequence will be padded accordingly, for ex. 00001
         */
        'sequence_padding' => 5,
        'delimiter'        => '-',
        /**
         * Supported tags {SERIES}, {DELIMITER}, {SEQUENCE}
         * Example: AA.00001
         */
        'format'           => '{SERIES}{DELIMITER}{SEQUENCE}',
    ],

    'currency' => [
        'code'                => 'eur',
        /**
         * Usually cents
         * Used when spelling out the amount and if your currency has decimals.
         *
         * Example: Amount in words: Eight hundred fifty thousand sixty-eight EUR and fifteen ct.
         */
        'fraction'            => 'ct.',
        'symbol'              => '€',
        /**
         * Example: 19.00
         */
        'decimals'            => 2,
        /**
         * Example: 1.99
         */
        'decimal_point'       => '.',
        /**
         * By default empty.
         * Example: 1,999.00
         */
        'thousands_separator' => '',
        /**
         * Supported tags {VALUE}, {SYMBOL}, {CODE}
         * Example: 1.99 €
         */
        'format'              => '{VALUE} {SYMBOL}',
    ],

    'paper' => [
        // A4 = 210 mm x 297 mm = 595 pt x 842 pt
        'size'        => 'a4',
        'orientation' => 'portrait',
    ],

    'disk' => 'invoices',

    'seller' => [
        /**
         * Class used in templates via $invoice->seller
         *
         * Must implement LaravelDaily\Invoices\Contracts\PartyContract
         *      or extend LaravelDaily\Invoices\Classes\Party
         */
        'class' => \LaravelDaily\Invoices\Classes\Seller::class,

        /**
         * Default attributes for Seller::class
         */
        'attributes' => [
            'name'          => 'Towne, Smith and Ebert',
            'address'       => '89982 Pfeffer Falls Damianstad, CO 66972-8160',
            'code'          => '41-1985581',
            'vat'           => '123456789',
            'phone'         => '760-355-3930',
            'custom_fields' => [
                /**
                 * Custom attributes for Seller::class
                 *
                 * Used to display additional info on Seller section in invoice
                 * attribute => value
                 */
                'SWIFT' => 'BANK101',
            ],
        ],
    ],
];
