<?php

namespace App\Service;

use Carbon\Carbon;
use App\Models\User;
use LaravelDaily\Invoices\Invoice;
use App\Models\Invoice as InvoiceModel;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

/**
 * From this package https://github.com/LaravelDaily/laravel-invoices
 */
class InvoiceService
{
    /**
     * Undocumented function
     *
     * @param array $dataForm
     * @param boolean $saving
     * @return \LaravelDaily\Invoices\Invoice
     */
    public static function generateInvoice(array $dataForm, bool $saving = true)
    {
        $invoice = self::makeInvoice($dataForm, $saving);
        return $invoice;
    }

    /**
     * Get disk path of this invoice
     *
     * @param \LaravelDaily\Invoices\Invoice $invoice
     * @return string
     */
    public static function getInvoicePath(Invoice $invoice)
    {
        return $invoice->url();
    }

    /**
     * Transform items collection of an invoice into a serialized array
     *
     * @param \Illuminate\Support\Collection $items
     * @return array
     */
    public static function serializeItems(\Illuminate\Support\Collection $items)
    {
        return $items->toJson();
    }

    /**
     * Create a new invoice with form data
     * Save on the disk by default
     *
     * @param array $dataForm
     * @param bool $saving
     * @return \LaravelDaily\Invoices\Invoice
     */
    private static function makeInvoice(array $dataForm, bool $saving)
    {
        $seller = self::addSellerPart($dataForm['admin_id']);
        $customer = self::addCustomerPart($dataForm['customer_id']);
        $items = self::createInvoiceItems($dataForm);
        $sequence = self::uniqueInvoiceId();
        $issueDate = Carbon::parse($dataForm['issue_date']);
        $dueDate = Carbon::parse($dataForm['due_date']);
        $notes = $dataForm['additionnal'] ? self::additionnalNotes($dataForm['additionnal']) : null;

        $invoice = Invoice::make('Facture')
            ->sequence($sequence)
            ->serialNumberFormat('{SEQUENCE}')
            ->seller($seller)
            ->buyer($customer)
            ->date($issueDate)
            ->dateFormat('d/m/Y')
            ->payUntilDays($issueDate->diffInDays($dueDate))
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->filename($dataForm['admin_id'] . '_' . $dataForm['customer_id'] . '_' . $sequence)
            ->addItems($items)
            ->taxRate(20)
        ;

        isset($notes) ? $invoice->notes($notes) : null;

        isset($saving) ? $invoice->save() : null;

        return $invoice;
    }

    /**
     * Generate an unique number for invoice
     *
     * @return integer
     */
    private static function uniqueInvoiceId()
    {
        $sequence = mt_rand(112123, 999999);

        if (InvoiceModel::where('invoice_id', $sequence)->first()) {
            return self::uniqueInvoiceId($sequence);
        }

        return $sequence;
    }

    /**
     * Instance an additionnal notes for an invoice
     *
     * @param string $notes
     * @return string
     */
    private static function additionnalNotes(string $notes)
    {
        $notesArray = explode(',', $notes);
        return implode("<br>", $notesArray);
    }

    /**
     * Generate items object for an invoice
     *
     * @param array $dataForm
     * @return void
     */
    private static function createInvoiceItems(array $dataForm)
    {
        // $dataForm['items'], $dataForm['qty_items'], $dataForm['price_items']
        $items = [];
        for ($i=0; $i < count($dataForm['items']); $i++) {
            $items[$i] = (new InvoiceItem())
                ->title($dataForm['items'][$i])
                ->pricePerUnit($dataForm['price_items'][$i])
                ->quantity(
                    $dataForm['qty_items'][$i] ? $dataForm['qty_items'][$i] : 1
                )
            ;
        }
        return $items;
    }

    /**
     * Generate a seller party for an invoice
     *
     * @param integer $id
     * @return Party
     */
    private static function addSellerPart(int $id)
    {
        $seller = User::find($id);
        return new Party([
            'name' => $seller->name,
            'address' => $seller->address->address_1 . ' ' . $seller->address->address_2 . '- <br>' . $seller->address->city . ', ' . $seller->address->zipcode . '<br>'. $seller->address->country,
            'phone' => $seller->address->phone_1 . ' ' . $seller->address->phone_2,
            'custom_fields' => [
                'email' => $seller->email,
            ],
        ]);
    }

    /**
     * Generate a customer party for an invoice
     *
     * @param integer $id
     * @return Party
     */
    private static function addCustomerPart(int $id)
    {
        $customer = User::find($id);

        return new Party([
            'name' => $customer->name,
            'phone' => $customer->address->phone_1 . ' ' . $customer->address->phone_2,
            'email' => $customer->email,
            'address' => $customer->address->address_1 . ' ' . $customer->address->address_2 . '- <br>' . $customer->address->city, $customer->address->zipcode . '<br>'. $customer->address->country,
        ]);
    }
}
