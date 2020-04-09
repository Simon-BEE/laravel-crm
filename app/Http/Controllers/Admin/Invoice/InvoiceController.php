<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\InvoiceStatus;
use App\Service\InvoiceService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInvoiceRequest;
use LaravelDaily\Invoices\Invoice as InvoicePackage;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('admin_id', auth()->id())->latest()->paginate(config('app.pagination'));
        $status = InvoiceStatus::all();
        return view('admin.invoices.index', compact('invoices', 'status'));
    }

    public function create()
    {
        $customers = User::customers()->get();

        if ($customers->isEmpty()) {
            return redirect()->route('admin.invoices.index')->with([
                'alertType' => 'danger',
                'alertMessage' => 'You need customers before create an invoice.',
            ]);
        }
        if (!auth()->user()->company_name) {
            return redirect()->back()->with([
                'alertType' => 'danger',
                'alertMessage' => 'You need to update informations about your company before create an invoice.',
            ]);
        }

        return view('admin.invoices.create', compact('customers'));
    }

    public function store(CreateInvoiceRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $invoice = InvoiceService::generateInvoice($data);
        $this->saveInvoice($data, $invoice);

        return redirect()->route('admin.invoices.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Your invoice has been created.',
        ]);
    }

    public function updateStatus()
    {
        $data = request()->validate([
            'invoice' => 'required|integer|exists:invoices,invoice_id',
            'status_id' => 'required|integer|exists:invoice_statuses,id',
        ]);

        $invoice = Invoice::where('invoice_id', $data['invoice'])->firstOrFail();
        $invoice->update(['status_id' => $data['status_id']]);

        return redirect()->route('admin.invoices.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Status has been updated.',
        ]);
    }

    private function saveInvoice(array $data, InvoicePackage $invoice)
    {
        $invoiceModel = new Invoice();

        $invoiceModel->invoice_id = $invoice->sequence;
        $invoiceModel->user_id = $data['user_id'];
        $invoiceModel->customer_id = $data['customer_id'];
        $invoiceModel->items = InvoiceService::serializeItems($invoice->items);
        $invoiceModel->file = $invoice->filename;
        $invoiceModel->amount = $invoice->total_amount;
        $invoiceModel->issue_date = $data['issue_date'];
        $invoiceModel->due_date = $data['due_date'];

        $invoiceModel->save();
    }
}
