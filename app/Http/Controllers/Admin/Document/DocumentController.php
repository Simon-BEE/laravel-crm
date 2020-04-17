<?php

namespace App\Http\Controllers\Admin\Document;

use App\Models\User;
use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.address')->except(['index', 'updateStatus']);
    }

    /**
     * Get all in progress projects of a customer
     * Display in a select input
     *
     * @return response
     */
    public function getProjectsByCustomer()
    {
        $customerId = request()->customerId;
        $projects = Project::essentialDataByCustomer($customerId);

        if (request()->ajax()) {
            return response()->json($projects);
        }
    }

    /**
     * Get Customers with addresses and projects available
     *
     * @return Collection
     */
    protected function getCustomersWithTheirProjects()
    {
        return User::customersWithAddressAndProjects();
    }

    /**
     * Check if the project belongs to customer
     *
     * @param integer $customerId
     * @param integer $projectId
     * @return void|\Illuminate\Http\Response
     */
    protected function verifyCustomerProject(int $customerId, int $projectId)
    {
        if (!$this->customerHasThisProject($customerId, $projectId)) {
            return redirect()->back()->with([
                'alertType' => 'danger',
                'alertMessage' => 'Une erreur est survenu.',
            ]);
        }
    }

    /**
     * Check if at leat one user has projects
     *
     * @param Collection $customers
     * @return Collection
     */
    protected function getDefaultCustomerProjects(Collection $customers)
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
    protected function customerHasThisProject(int $customerId, int $projectId)
    {
        if (Project::find($projectId)->customer->id == $customerId) {
            return true;
        }

        return false;
    }
}
