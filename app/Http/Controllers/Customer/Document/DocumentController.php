<?php

namespace App\Http\Controllers\Customer\Document;

use App\Models\Status;
use App\Models\Invoice;
use App\Models\Estimate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class DocumentController extends Controller
{
    public function index()
    {
        $estimates = Estimate::where('customer_id', auth()->id());
        $invoices = Invoice::where('customer_id', auth()->id());
        if (request()->has('status')) {
            \Search::searchByKeywords([$estimates, $invoices], request()->keywords, ['items', 'file', 'customer.firstname', 'customer.lastname']);

            \Search::searchBetweenByRange([$estimates, $invoices], request()->range);

            \Search::searchByStatus([$estimates, $invoices], request()->status);
        }
        $estimates = $estimates->get();
        $invoices = $invoices->get();
        $documents =  $estimates->concat($invoices);

        $statuses = Status::all();
        return view('customer.documents.index', compact('statuses', 'documents'));
    }

    public function showEstimate(Estimate $document)
    {
        if (Gate::denies('show-document', $document)) {
            abort(404);
        }

        return redirect()->to(url('/storage/estimates/'.$document->file));
    }

    public function showInvoice(Invoice $document)
    {
        if (Gate::denies('show-document', $document)) {
            abort(404);
        }

        return redirect()->to(url('/storage/invoices/'.$document->file));
    }
}
