<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Project;
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
        if (!auth()->user()->hasAddress) {
            return redirect()->route('admin.account.edit')->with([
                'alertType' => 'danger',
                'alertMessage' => 'Vous devez mettre à jour votre adresse avant de procéder à une facturation.',
            ]);
        }

        $customers = User::customersWithAddress();

        if ($customers->isEmpty()) {
            return redirect()->route('admin.customers.index')->with([
                'alertType' => 'danger',
                'alertMessage' => 'Vous devez enregistrer des clients avant de procéder à une facturation.',
            ]);
        }

        $projects = Project::essentialDataByCustomer($customers->first()->id);

        return view('admin.invoices.create', compact('customers', 'projects'));
    }

    public function store(CreateInvoiceRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = auth()->id();

        if (!$this->customerHasThisProject($data['customer_id'], $data['project_id'])) {
            return redirect()->back()->with([
                'alertType' => 'danger',
                'alertMessage' => 'Une erreur est survenu.',
            ]);
        }

        $invoice = InvoiceService::generateInvoice($data);
        $this->saveInvoice($data, $invoice);

        return redirect()->route('admin.invoices.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'La facture a bien été générée.',
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

    public function getProjectsByCustomer()
    {
        $customerId = request()->customerId;
        $projects = Project::essentialDataByCustomer($customerId);

        if (request()->ajax()) {
            return response()->json($projects);
        }
    }

    private function saveInvoice(array $data, InvoicePackage $invoice)
    {
        $invoiceModel = new Invoice();

        $invoiceModel->invoice_id = $invoice->sequence;
        $invoiceModel->admin_id = $data['admin_id'];
        $invoiceModel->customer_id = $data['customer_id'];
        $invoiceModel->project_id = $data['project_id'];
        $invoiceModel->items = InvoiceService::serializeItems($invoice->items);
        $invoiceModel->file = $invoice->filename;
        $invoiceModel->amount = $invoice->total_amount;
        $invoiceModel->issue_date = $data['issue_date'];
        $invoiceModel->due_date = $data['due_date'];

        $invoiceModel->save();
    }

    /**
     * Check if the project belongs to customer
     *
     * @param integer $customerId
     * @param integer $projectId
     * @return bool
     */
    private function customerHasThisProject(int $customerId, int $projectId)
    {
        if (Project::find($projectId)->user->id == $customerId) {
            return true;
        }

        return false;
    }
}
