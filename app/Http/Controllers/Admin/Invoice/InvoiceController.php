<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Models\User;
use App\Models\Status;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Estimate;
use App\Service\InvoiceService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInvoiceRequest;
use Illuminate\Database\Eloquent\Collection;
use LaravelDaily\Invoices\Invoice as InvoicePackage;

class InvoiceController extends Controller
{
    public function index()
    {
        // dd(request()->routeIs('admin.invoices.index'));
        $invoices = Invoice::where('admin_id', auth()->id())->latest()->paginate(config('app.pagination'));
        $status = Status::all();
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

        $customers = User::customersWithAddressAndProjects();
        if ($customers->isEmpty()) {
            return redirect()->route('admin.customers.index')->with([
                'alertType' => 'danger',
                'alertMessage' => 'Vous devez enregistrer des clients avec projet(s) avant de procéder à une facturation.',
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
            'status_id' => 'required|integer|exists:statuses,id',
        ]);

        $invoice = Invoice::where('invoice_id', $data['invoice'])->firstOrFail();
        $invoice->update(['status_id' => $data['status_id']]);

        return redirect()->route('admin.invoices.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le statut a bien été mis à jour',
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
        $invoiceModel->items = InvoiceService::serializeItems($invoice->items);
        $invoiceModel->file = $invoice->filename;
        $invoiceModel->amount = $invoice->total_amount;
        $invoiceModel->issue_date = $data['issue_date'];
        $invoiceModel->due_date = $data['due_date'];

        $invoiceModel->save();
    }

    /**
     * Save in database Estiimate's data
     *
     * @param array $data
     * @param InvoicePackage $invoice
     * @return void
     */
    private function saveEstimate(array $data, InvoicePackage $invoice)
    {
        $estimate = new Estimate();

        $estimate->estimate_id = $invoice->sequence;
        $estimate->admin_id = $data['admin_id'];
        $estimate->customer_id = $data['customer_id'];
        $estimate->project_id = $data['project_id'];
        $estimate->status_id = 1;
        $estimate->items = InvoiceService::serializeItems($invoice->items);
        $estimate->file = $invoice->filename;
        $estimate->amount = $invoice->total_amount;
        $estimate->issue_date = $data['issue_date'];
        $estimate->due_date = $data['due_date'];

        $estimate->save();
    }

    /**
     * Check if at leat one user has projects
     *
     * @param Collection $customers
     * @return Collection
     */
    private function getDefaultCustomerProjects(Collection $customers)
    {
        $projects = null;
        $customers->first(function($customer, $key) use (&$projects){
            if (($projects = Project::essentialDataByCustomer($customer->id))->isNotEmpty()) {
                return $customer;
            }
        });

        return $projects;
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
