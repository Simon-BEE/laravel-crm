<?php

namespace App\Http\Controllers\Admin\Document;

use App\Models\Status;
use App\Models\Invoice;
use App\Models\Project;
use App\Service\DocumentService;
use App\Http\Requests\CreateInvoiceRequest;
use Illuminate\Support\Facades\Validator;
use LaravelDaily\Invoices\Invoice as InvoicePackage;

class InvoiceController extends DocumentController
{
    /**
     * Display all invoices registered with their status
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::where('admin_id', auth()->id());
        if (request()->has('rows')) {
            \Search::searchByKeywords($invoices, request()->keywords, ['items', 'file', 'customer.firstname', 'customer.lastname']);

            \Search::searchBetweenByRange($invoices, request()->range);

            \Search::searchByStatus($invoices, request()->status);

            if (is_numeric(request()->rows) && request()->rows >= 10 && request()->rows <= 50) {
                $perPage = request()->rows;
            }
        }
        $invoices = $invoices->latest()->paginate(config('app.pagination'));
        $statuses = Status::all();
        return view('admin.documents.invoices.index', compact('invoices', 'statuses'));
    }

    /**
     * Show invoice generator form and check ability of auth to access to this page
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = $this->getCustomersWithTheirProjects();

        if ($customers->isEmpty()) {
            return redirect()->route('admin.customers.index')->with([
                'alertType' => 'danger',
                'alertMessage' => 'Vous devez enregistrer des clients avec projet(s) avant de procéder à une facturation.',
            ]);
        }

        $projects = Project::essentialDataByCustomer($customers->first()->id);

        return view('admin.documents.invoices.create', compact('customers', 'projects'));
    }

    /**
     * Save and generate a new invoice
     *
     * @param CreateInvoiceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateInvoiceRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = auth()->id();

        $this->verifyCustomerProject($data['customer_id'], $data['project_id']);

        $invoice = DocumentService::generateDocument($data);

        $this->saveInvoice($data, $invoice);

        return redirect()->route('admin.invoices.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'La facture a bien été générée.',
        ]);
    }

    /**
     * Update invoice status from index page
     *
     * @return \Illuminate\Http\Response
     */
    public function updateStatus()
    {
        $data = request()->validate([
            'invoice' => 'required|exists:invoices,invoice_id',
            'status_id' => 'required|integer|exists:statuses,id',
        ]);

        $invoice = Invoice::where('invoice_id', $data['invoice'])->firstOrFail();
        $invoice->update(['status_id' => $data['status_id']]);

        return redirect()->route('admin.invoices.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le statut a bien été mis à jour',
        ]);
    }

    /**
     * Save in database Invoice's data
     *
     * @param array $data
     * @param InvoicePackage $invoice
     * @return void
     */
    private function saveInvoice(array $data, InvoicePackage $invoice)
    {
        $invoiceModel = new Invoice();

        $invoiceModel->invoice_id = $invoice->sequence;
        $invoiceModel->admin_id = $data['admin_id'];
        $invoiceModel->customer_id = $data['customer_id'];
        $invoiceModel->project_id = $data['project_id'];
        $invoiceModel->status_id = 1;
        $invoiceModel->items = DocumentService::serializeItems($invoice->items);
        $invoiceModel->file = $invoice->filename;
        $invoiceModel->amount = $invoice->total_amount;
        $invoiceModel->issue_date = $data['issue_date'];
        $invoiceModel->due_date = $data['due_date'];

        $invoiceModel->save();
    }
}
