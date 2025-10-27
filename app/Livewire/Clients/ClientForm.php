<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientForm extends Component
{
    public ?Client $client = null;
    public $isEditing = false;
    public $currentStep = 1;
    public $totalSteps = 6;

    public $document_type = 'CC';
    public $document_number = '';
    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
    public $second_last_name = '';
    public $birth_date = '';
    public $birth_place = '';
    public $gender = 'M';
    public $marital_status = '';
    public $education_level = '';
    public $dependents_count = 0;

    public $address = '';
    public $neighborhood = '';
    public $city = '';
    public $department = '';
    public $phone_mobile = '';
    public $phone_landline = '';
    public $email = '';

    public $employment_type = '';
    public $employer_name = '';
    public $employer_nit = '';
    public $position = '';
    public $monthly_salary = '';
    public $start_date = '';

    public $total_income = '';
    public $total_expenses = '';
    public $rent_expense = 0;
    public $utilities_expense = 0;
    public $food_expense = 0;

    public $references = [];

    public $consent_data_treatment = false;
    public $consent_credit_query = false;

    public function mount(?Client $client = null)
    {
        if ($client && $client->exists) {
            $this->isEditing = true;
            $this->client = $client;
            $this->loadClientData();
        } else {
            $this->references = [
                ['type' => 'personal', 'name' => '', 'phone' => '', 'relationship' => ''],
                ['type' => 'personal', 'name' => '', 'phone' => '', 'relationship' => ''],
                ['type' => 'familiar', 'name' => '', 'phone' => '', 'relationship' => '']
            ];
        }
    }

    private function loadClientData()
    {
        $this->document_type = $this->client->document_type;
        $this->document_number = $this->client->document_number;
        $this->first_name = $this->client->first_name;
        $this->middle_name = $this->client->middle_name;
        $this->last_name = $this->client->last_name;
        $this->second_last_name = $this->client->second_last_name;
        $this->birth_date = $this->client->birth_date->format('Y-m-d');
        $this->birth_place = $this->client->birth_place;
        $this->gender = $this->client->gender;
        $this->marital_status = $this->client->marital_status;
        $this->education_level = $this->client->education_level;
        $this->dependents_count = $this->client->dependents_count;

        $contact = $this->client->contacts()->where('is_primary', true)->first();
        if ($contact) {
            $this->address = $contact->address;
            $this->neighborhood = $contact->neighborhood;
            $this->city = $contact->city;
            $this->department = $contact->department;
            $this->phone_mobile = $contact->phone_mobile;
            $this->phone_landline = $contact->phone_landline;
            $this->email = $contact->email;
        }

        $employment = $this->client->currentEmployment;
        if ($employment) {
            $this->employment_type = $employment->employment_type;
            $this->employer_name = $employment->employer_name;
            $this->employer_nit = $employment->employer_nit;
            $this->position = $employment->position;
            $this->monthly_salary = $employment->monthly_salary;
            $this->start_date = $employment->start_date->format('Y-m-d');
        }

        $financial = $this->client->latestFinancial;
        if ($financial) {
            $this->total_income = $financial->total_income;
            $this->total_expenses = $financial->total_expenses;
            $this->rent_expense = $financial->rent_expense;
            $this->utilities_expense = $financial->utilities_expense;
            $this->food_expense = $financial->food_expense;
        }

        $references = $this->client->references;
        if ($references->count() > 0) {
            $this->references = $references->map(function($ref) {
                return [
                    'type' => $ref->reference_type,
                    'name' => $ref->full_name,
                    'phone' => $ref->phone,
                    'relationship' => $ref->relationship
                ];
            })->toArray();
        } else {
            $this->references = [
                ['type' => 'personal', 'name' => '', 'phone' => '', 'relationship' => ''],
                ['type' => 'personal', 'name' => '', 'phone' => '', 'relationship' => ''],
                ['type' => 'familiar', 'name' => '', 'phone' => '', 'relationship' => '']
            ];
        }

        $this->consent_data_treatment = true;
        $this->consent_credit_query = true;
    }

    public function nextStep()
    {
        $this->validate($this->getStepRules($this->currentStep));
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    private function getStepRules($step)
    {
        $documentRule = $this->isEditing && $this->client
            ? 'required|string|min:6|max:12|unique:clients,document_number,' . $this->client->id
            : 'required|string|min:6|max:12|unique:clients,document_number';

        $allRules = [
            1 => [
                'document_type' => 'required|in:CC,CE,TI,PP',
                'document_number' => $documentRule,
                'first_name' => 'required|string|min:2|max:100',
                'last_name' => 'required|string|min:2|max:100',
                'birth_date' => 'required|date',
                'gender' => 'required|string',
                'marital_status' => 'required|string',
                'education_level' => 'required|string'
            ],
            2 => [
                'address' => 'required|string|max:255',
                'city' => 'required|string',
                'department' => 'required|string',
                'phone_mobile' => 'required|string',
                'email' => 'required|email'
            ],
            3 => [
                'employment_type' => 'required',
                'employer_name' => 'required|string|max:255',
                'position' => 'required|string|max:100',
                'monthly_salary' => 'required|numeric|min:1300000',
                'start_date' => 'required|date'
            ],
            4 => [
                'total_income' => 'required|numeric|min:1300000',
                'total_expenses' => 'required|numeric'
            ],
            5 => [
                'references.*.name' => 'required|string|max:255',
                'references.*.phone' => 'required|string'
            ],
            6 => [
                'consent_data_treatment' => 'accepted',
                'consent_credit_query' => 'accepted'
            ]
        ];

        return $allRules[$step] ?? [];
    }

    public function submit()
    {
        foreach (range(1, $this->totalSteps) as $step) {
            $this->validate($this->getStepRules($step));
        }

        DB::transaction(function () {
            $clientData = [
                'document_type' => $this->document_type,
                'document_number' => $this->document_number,
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'second_last_name' => $this->second_last_name,
                'full_name' => trim("{$this->first_name} {$this->middle_name} {$this->last_name} {$this->second_last_name}"),
                'birth_date' => $this->birth_date,
                'birth_place' => $this->birth_place,
                'gender' => $this->gender,
                'marital_status' => $this->marital_status,
                'education_level' => $this->education_level,
                'dependents_count' => $this->dependents_count,
            ];

            if ($this->isEditing) {
                $clientData['updated_by'] = auth()->id();
                $this->client->update($clientData);
                $client = $this->client;
            } else {
                $clientData['status'] = 'registro_inicial';
                $clientData['created_by'] = auth()->id();
                $client = Client::create($clientData);
                
                // Create user account for client
                $user = \App\Models\User::create([
                    'name' => $client->full_name,
                    'email' => $this->email,
                    'password' => \Illuminate\Support\Facades\Hash::make('Cliente2024*'),
                    'phone' => $this->phone_mobile,
                    'is_active' => true,
                ]);
                
                $role = \App\Models\Role::where('slug', 'cliente')->first();
                if ($role) {
                    $user->roles()->attach($role->id);
                }
                
                $client->update(['user_id' => $user->id]);
            }

            $contactData = [
                'contact_type' => 'residencia',
                'address' => $this->address,
                'neighborhood' => $this->neighborhood,
                'city' => $this->city,
                'department' => $this->department,
                'phone_mobile' => $this->phone_mobile,
                'phone_landline' => $this->phone_landline,
                'email' => $this->email,
                'is_primary' => true
            ];

            if ($this->isEditing) {
                $client->contacts()->updateOrCreate(
                    ['client_id' => $client->id, 'is_primary' => true],
                    $contactData
                );
            } else {
                $client->contacts()->create($contactData);
            }

            $employmentData = [
                'is_current' => true,
                'employment_type' => $this->employment_type,
                'employer_name' => $this->employer_name,
                'employer_nit' => $this->employer_nit,
                'position' => $this->position,
                'monthly_salary' => $this->monthly_salary,
                'other_income' => 0,
                'total_monthly_income' => $this->monthly_salary,
                'start_date' => $this->start_date
            ];

            if ($this->isEditing) {
                $client->employments()->where('is_current', true)->update(['is_current' => false]);
            }
            $client->employments()->create($employmentData);

            $financialData = [
                'month_year' => now()->format('Y-m'),
                'total_income' => $this->total_income,
                'salary_income' => $this->monthly_salary,
                'total_expenses' => $this->total_expenses,
                'rent_expense' => $this->rent_expense,
                'utilities_expense' => $this->utilities_expense,
                'food_expense' => $this->food_expense,
                'disposable_income' => $this->total_income - $this->total_expenses
            ];

            if ($this->isEditing) {
                $client->financials()->updateOrCreate(
                    ['client_id' => $client->id, 'month_year' => now()->format('Y-m')],
                    $financialData
                );
            } else {
                $client->financials()->create($financialData);
            }

            if ($this->isEditing) {
                $client->references()->delete();
            }

            foreach ($this->references as $ref) {
                if (!empty($ref['name'])) {
                    $client->references()->create([
                        'reference_type' => $ref['type'],
                        'full_name' => $ref['name'],
                        'phone' => $ref['phone'],
                        'relationship' => $ref['relationship'] ?? '',
                        'verification_status' => 'pendiente'
                    ]);
                }
            }

            if (!$this->isEditing) {
                $client->consents()->create([
                    'consent_type' => 'tratamiento_datos',
                    'consent_text' => 'Autorizo el tratamiento de mis datos personales',
                    'accepted' => true,
                    'acceptance_date' => now(),
                    'acceptance_ip' => request()->ip()
                ]);
            }

            $message = $this->isEditing ? 'Cliente actualizado exitosamente' : 'Cliente registrado exitosamente';
            return redirect()->route('clients.show', $client)->with('success', $message);
        });
    }

    public function render()
    {
        return view('livewire.clients.client-form');
    }
}
