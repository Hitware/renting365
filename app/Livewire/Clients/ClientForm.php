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
    public $totalSteps = 5;

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
    public $birth_department = '';
    public $birth_city = '';
    public $phone_mobile = '';
    public $phone_landline = '';
    public $email = '';
    
    public $colombianDepartments = [];
    public $birthCities = [];
    public $residenceCities = [];

    public $total_income = '';
    public $total_expenses = '';
    public $rent_expense = '';
    public $utilities_expense = '';
    public $food_expense = '';

    public $references = [];

    public $consent_data_treatment = false;
    public $consent_credit_query = false;

    public function mount(?Client $client = null, $application = null)
    {
        $this->loadColombianLocations();
        
        if ($client && $client->exists) {
            $this->isEditing = true;
            $this->client = $client;
            $this->loadClientData();
        } else {
            if ($application) {
                $this->loadFromApplication($application);
            }
            $this->references = [
                ['type' => 'personal', 'name' => '', 'phone' => '', 'relationship' => ''],
                ['type' => 'personal', 'name' => '', 'phone' => '', 'relationship' => ''],
                ['type' => 'familiar', 'name' => '', 'phone' => '', 'relationship' => '']
            ];
        }
    }

    private function loadFromApplication($application)
    {
        $nameParts = explode(' ', $application->full_name);
        $this->first_name = $nameParts[0] ?? '';
        $this->last_name = $nameParts[count($nameParts) - 1] ?? '';
        if (count($nameParts) > 2) {
            $this->middle_name = $nameParts[1] ?? '';
        }
        $this->document_number = $application->document_number;
        $this->phone_mobile = $application->phone;
        $this->email = $application->email;
        $this->city = $application->city;
    }
    
    private function loadColombianLocations()
    {
        $this->colombianDepartments = [
            'Amazonas' => ['Leticia', 'Puerto Nariño'],
            'Antioquia' => ['Medellín', 'Bello', 'Itagüí', 'Envigado', 'Apartadó', 'Turbo', 'Rionegro'],
            'Arauca' => ['Arauca', 'Arauquita', 'Saravena'],
            'Atlántico' => ['Barranquilla', 'Soledad', 'Malambo', 'Sabanalarga', 'Puerto Colombia'],
            'Bolívar' => ['Cartagena', 'Magangué', 'Turbaco', 'Arjona', 'El Carmen de Bolívar'],
            'Boyacá' => ['Tunja', 'Duitama', 'Sogamoso', 'Chiquinquirá', 'Paipa'],
            'Caldas' => ['Manizales', 'Villamaría', 'Chinchiná', 'La Dorada'],
            'Caquetá' => ['Florencia', 'San Vicente del Caguán', 'Puerto Rico'],
            'Casanare' => ['Yopal', 'Aguazul', 'Villanueva', 'Monterrey'],
            'Cauca' => ['Popayán', 'Santander de Quilichao', 'Puerto Tejada'],
            'Cesar' => ['Valledupar', 'Aguachica', 'Bosconia', 'Codazzi'],
            'Chocó' => ['Quibdó', 'Istmina', 'Condoto'],
            'Córdoba' => ['Montería', 'Cereté', 'Lorica', 'Sahagún'],
            'Cundinamarca' => ['Bogotá', 'Soacha', 'Facatativá', 'Zipaquirá', 'Chía', 'Fusagasugá', 'Girardot'],
            'Guainía' => ['Inírida'],
            'Guaviare' => ['San José del Guaviare'],
            'Huila' => ['Neiva', 'Pitalito', 'Garzón', 'La Plata'],
            'La Guajira' => ['Riohacha', 'Maicao', 'Uribia', 'Manaure'],
            'Magdalena' => ['Santa Marta', 'Ciénaga', 'Fundación', 'El Banco'],
            'Meta' => ['Villavicencio', 'Acacías', 'Granada', 'Puerto López'],
            'Nariño' => ['Pasto', 'Tumaco', 'Ipiales', 'Túquerres'],
            'Norte de Santander' => ['Cúcuta', 'Ocaña', 'Pamplona', 'Villa del Rosario'],
            'Putumayo' => ['Mocoa', 'Puerto Asís', 'Orito'],
            'Quindío' => ['Armenia', 'Calarcá', 'La Tebaida', 'Montenegro'],
            'Risaralda' => ['Pereira', 'Dosquebradas', 'Santa Rosa de Cabal', 'La Virginia'],
            'San Andrés y Providencia' => ['San Andrés', 'Providencia'],
            'Santander' => ['Bucaramanga', 'Floridablanca', 'Girón', 'Piedecuesta', 'Barrancabermeja'],
            'Sucre' => ['Sincelejo', 'Corozal', 'Sampués'],
            'Tolima' => ['Ibagué', 'Espinal', 'Melgar', 'Honda'],
            'Valle del Cauca' => ['Cali', 'Palmira', 'Buenaventura', 'Tuluá', 'Cartago', 'Buga'],
            'Vaupés' => ['Mitú'],
            'Vichada' => ['Puerto Carreño']
        ];
    }
    
    public function updatedBirthDepartment($value)
    {
        $this->birthCities = $this->colombianDepartments[$value] ?? [];
        $this->birth_city = '';
    }
    
    public function updatedDepartment($value)
    {
        $this->residenceCities = $this->colombianDepartments[$value] ?? [];
        $this->city = '';
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
        
        if ($this->birth_place) {
            if (str_contains($this->birth_place, ',')) {
                [$city, $dept] = explode(',', $this->birth_place, 2);
                $this->birth_city = trim($city);
                $this->birth_department = trim($dept);
            } else {
                $this->birth_city = $this->birth_place;
            }
            if ($this->birth_department) {
                $this->birthCities = $this->colombianDepartments[$this->birth_department] ?? [];
            }
        }
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
            $this->residenceCities = $this->colombianDepartments[$this->department] ?? [];
            $this->phone_mobile = $contact->phone_mobile;
            $this->phone_landline = $contact->phone_landline;
            $this->email = $contact->email;
        }

        $financial = $this->client->latestFinancial;
        if ($financial) {
            $this->total_income = number_format($financial->total_income, 0, ',', '.');
            $this->total_expenses = number_format($financial->total_expenses, 0, ',', '.');
            $this->rent_expense = $financial->rent_expense ? number_format($financial->rent_expense, 0, ',', '.') : '';
            $this->utilities_expense = $financial->utilities_expense ? number_format($financial->utilities_expense, 0, ',', '.') : '';
            $this->food_expense = $financial->food_expense ? number_format($financial->food_expense, 0, ',', '.') : '';
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
        // Limpiar campos monetarios antes de validar paso 3
        if ($this->currentStep == 3) {
            $this->cleanMoneyFields();
        }
        
        $this->validate($this->getStepRules($this->currentStep));
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }
    
    private function cleanMoneyFields()
    {
        // Remover formato de moneda y validar que sean números
        $this->total_income = preg_replace('/[^0-9]/', '', $this->total_income);
        $this->total_expenses = preg_replace('/[^0-9]/', '', $this->total_expenses);
        $this->rent_expense = preg_replace('/[^0-9]/', '', $this->rent_expense);
        $this->utilities_expense = preg_replace('/[^0-9]/', '', $this->utilities_expense);
        $this->food_expense = preg_replace('/[^0-9]/', '', $this->food_expense);
        
        // Validar mínimo de ingresos
        if ((int)$this->total_income < 1300000) {
            $this->addError('total_income', 'Los ingresos totales deben ser mínimo $1.300.000');
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
                'first_name' => 'required|string|min:2|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
                'middle_name' => 'nullable|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/',
                'last_name' => 'required|string|min:2|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
                'second_last_name' => 'nullable|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/',
                'birth_date' => 'required|date',
                'gender' => 'required|string',
                'marital_status' => 'required|string',
                'education_level' => 'required|string'
            ],
            2 => [
                'department' => 'required|string',
                'city' => 'required|string',
                'address' => 'required|string|max:255',
                'neighborhood' => 'required|string|max:100',
                'phone_mobile' => 'required|string|regex:/^[0-9]{10}$/',
                'phone_landline' => 'nullable|string|regex:/^[0-9]{7,10}$/',
                'email' => 'required|email'
            ],
            3 => [
                'total_income' => 'required|string',
                'total_expenses' => 'required|string'
            ],
            4 => [
                'references.*.name' => 'required|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
                'references.*.phone' => 'required|string|regex:/^[0-9]{10}$/'
            ],
            5 => [
                'consent_data_treatment' => 'accepted',
                'consent_credit_query' => 'accepted'
            ]
        ];

        return $allRules[$step] ?? [];
    }

    public function submit()
    {
        // Limpiar campos monetarios antes de validar
        $this->cleanMoneyFields();
        
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
                'birth_place' => $this->birth_city && $this->birth_department ? "{$this->birth_city}, {$this->birth_department}" : $this->birth_place,
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
                'department' => $this->department,
                'city' => $this->city,
                'address' => $this->address,
                'neighborhood' => $this->neighborhood,
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

            $totalIncome = (float) str_replace(['.', ','], ['', '.'], $this->total_income);
            $totalExpenses = (float) str_replace(['.', ','], ['', '.'], $this->total_expenses);
            $rentExpense = $this->rent_expense ? (float) str_replace(['.', ','], ['', '.'], $this->rent_expense) : 0;
            $utilitiesExpense = $this->utilities_expense ? (float) str_replace(['.', ','], ['', '.'], $this->utilities_expense) : 0;
            $foodExpense = $this->food_expense ? (float) str_replace(['.', ','], ['', '.'], $this->food_expense) : 0;

            $financialData = [
                'month_year' => now()->format('Y-m'),
                'total_income' => $totalIncome,
                'salary_income' => $totalIncome,
                'total_expenses' => $totalExpenses,
                'rent_expense' => $rentExpense,
                'utilities_expense' => $utilitiesExpense,
                'food_expense' => $foodExpense,
                'disposable_income' => $totalIncome - $totalExpenses
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
