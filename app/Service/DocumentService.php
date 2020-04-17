<?php

namespace App\Service;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use LaravelDaily\Invoices\Invoice;
use App\Models\Invoice as InvoiceModel;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

/**
 * From this package https://github.com/LaravelDaily/laravel-invoices
 */
class DocumentService
{
    /**
     * Undocumented function
     *
     * @param array $dataForm
     * @param boolean $saving
     * @param boolean $estimate
     * @return \LaravelDaily\Invoices\Invoice
     */
    public static function generateDocument(array $dataForm, bool $estimate = false, bool $saving = true)
    {
        $invoice = self::makeDocument($dataForm, $estimate, $saving);
        return $invoice;
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
     * Create a new document with form data
     * Save on the disk by default
     *
     * @param array $dataForm
     * @param bool $saving
     * @return \LaravelDaily\Invoices\Invoice
     */
    private static function makeDocument(array $dataForm, bool $estimate, bool $saving)
    {
        $seller = self::addSellerPart($dataForm['admin_id']);
        $customer = self::addCustomerPart($dataForm['customer_id']);
        $items = self::createItems($dataForm);
        $sequence = self::uniqueId($estimate);
        $issueDate = Carbon::parse($dataForm['issue_date']);
        $dueDate = Carbon::parse($estimate ? $dataForm['limit_date'] : $dataForm['due_date']);
        $notes = $dataForm['additionnal'] ? self::additionnalNotes($dataForm['additionnal']) : null;
        $fileName = date('Ym') . '_' .$dataForm['admin_id'] . '-' . $dataForm['customer_id'] . '_' . $sequence;

        $invoice = Invoice::make($estimate ? 'Devis' : 'Facture')
            ->sequence($sequence)
            ->serialNumberFormat('{SEQUENCE}')
            ->seller($seller)
            ->buyer($customer)
            ->date($issueDate)
            ->dateFormat('d/m/Y')
            ->payUntilDays($issueDate->diffInDays($dueDate))
            ->filename(($estimate ? 'D-' : 'F-') . $fileName . '-' . Str::random())
            ->addItems($items)
            ->taxRate(20)
            ->template($estimate ? 'estimate' : 'invoice')
        ;

        isset($notes) ? $invoice->notes($notes) : null;

        isset($saving) ? $invoice->save($estimate ? 'estimates' : 'invoices') : null;

        return $invoice;
    }

    /**
     * Generate an unique number for invoice
     *
     * @return integer
     */
    private static function uniqueId(bool $estimate)
    {
        $lastId = $estimate ? (DB::table('estimates')->latest()->first()->id ?? 0) : (DB::table('invoices')->latest()->first()->id ?? 0);

        return $lastId + 45;
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
    private static function createItems(array $dataForm)
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
            'address' => $seller->address->address_1 . ' ' . $seller->address->address_2 . '<br>' . $seller->address->city . ', ' . $seller->address->zipcode . '<br>'. $seller->address->country,
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
            'address' => $customer->address->address_1 . ' ' . $customer->address->address_2 . '<br>' . $customer->address->city . ', ' . $customer->address->zipcode . '<br>'. $customer->address->country,
        ]);
    }
}
