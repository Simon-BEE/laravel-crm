<?php

namespace App\Http\Controllers\Admin\Document;

use App\Models\Status;
use App\Models\Project;
use App\Models\Estimate;
use App\Service\DocumentService;
use App\Http\Requests\CreateEstimateRequest;
use LaravelDaily\Invoices\Invoice as InvoicePackage;

class EstimateController extends DocumentController
{
    /**
     * Display all estimates registered with their status
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estimates = Estimate::where('admin_id', auth()->id())->latest()->paginate(config('app.pagination'));
        $status = Status::all();
        return view('admin.documents.estimates.index', compact('estimates', 'status'));
    }

    /**
     * Show estimate generator form and check ability of auth to access to this page
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

        return view('admin.documents.estimates.create', compact('customers', 'projects'));
    }

    /**
     * Save and generate a new estimate
     *
     * @param CreateEstimateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEstimateRequest $request)
    {
        // dd(request()->all());
        $data = $request->validated();
        $data['admin_id'] = auth()->id();

        $this->verifyCustomerProject($data['customer_id'], $data['project_id']);

        $estimate = DocumentService::generateDocument($data, true);

        $this->saveEstimate($data, $estimate);

        return redirect()->route('admin.estimates.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'La facture a bien été générée.',
        ]);
    }

    /**
     * Update estimate status from index page
     *
     * @return \Illuminate\Http\Response
     */
    public function updateStatus()
    {
        $data = request()->validate([
            'estimate' => 'required|integer|exists:estimates,estimate_id',
            'status_id' => 'required|integer|exists:statuses,id',
        ]);

        $estimate = Estimate::where('estimate_id', $data['estimate'])->firstOrFail();
        $estimate->update(['status_id' => $data['status_id']]);

        return redirect()->route('admin.estimates.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le statut a bien été mis à jour',
        ]);
    }

    /**
     * Save in database Estiimate's data
     *
     * @param array $data
     * @param InvoicePackage $estimate
     * @return void
     */
    private function saveEstimate(array $data, InvoicePackage $estimate)
    {
        $estimateModel = new Estimate();

        $estimateModel->estimate_id = $estimate->sequence;
        $estimateModel->admin_id = $data['admin_id'];
        $estimateModel->customer_id = $data['customer_id'];
        $estimateModel->project_id = $data['project_id'];
        $estimateModel->status_id = 1;
        $estimateModel->items = DocumentService::serializeItems($estimate->items);
        $estimateModel->file = $estimate->filename;
        $estimateModel->amount = $estimate->total_amount;
        $estimateModel->issue_date = $data['issue_date'];
        $estimateModel->limit_date = $data['limit_date'];

        $estimateModel->save();
    }
}
