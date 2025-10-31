<?php

namespace App\Livewire;

use App\Models\CreditApplication;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class CreditApplicationForm extends Component
{
    public $full_name = '';
    public $document_number = '';
    public $phone = '';
    public $email = '';
    public $city = '';
    public $recaptcha = '';
    public $showSuccess = false;

    protected $rules = [
        'full_name' => 'required|string|max:255',
        'document_number' => 'required|string|max:20|unique:credit_applications,document_number',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'city' => 'required|string|max:100',
        'recaptcha' => 'required',
    ];

    protected $messages = [
        'full_name.required' => 'El nombre completo es obligatorio',
        'document_number.required' => 'La cédula es obligatoria',
        'document_number.unique' => 'Ya tenemos tu información registrada. Un asesor se contactará contigo pronto.',
        'phone.required' => 'El teléfono es obligatorio',
        'email.required' => 'El correo electrónico es obligatorio',
        'email.email' => 'Ingresa un correo válido',
        'city.required' => 'La ciudad es obligatoria',
        'recaptcha.required' => 'Por favor verifica que no eres un robot',
    ];

    public function updatedDocumentNumber($value)
    {
        if (strlen($value) >= 6) {
            $exists = CreditApplication::where('document_number', $value)->exists();
            if ($exists) {
                $this->addError('document_number', 'Ya tenemos tu información registrada. Un asesor se contactará contigo pronto.');
            }
        }
    }

    public function submit()
    {
        $this->validate();

        // Validar reCAPTCHA v2 con Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $this->recaptcha,
            'remoteip' => request()->ip()
        ]);

        $recaptchaData = $response->json();

        if (!isset($recaptchaData['success']) || !$recaptchaData['success']) {
            $this->recaptcha = '';
            $this->addError('recaptcha', 'Verificación de reCAPTCHA fallida. Por favor intenta de nuevo.');
            $this->dispatch('reset-recaptcha');
            return;
        }

        CreditApplication::create([
            'full_name' => $this->full_name,
            'document_number' => $this->document_number,
            'phone' => $this->phone,
            'email' => $this->email,
            'city' => $this->city,
            'motorcycle_type' => 'AKT NKD 125',
            'approximate_value' => 0,
            'status' => 'pending',
        ]);

        $this->showSuccess = true;
        $this->reset(['full_name', 'document_number', 'phone', 'email', 'city', 'recaptcha']);
    }

    public function render()
    {
        return view('livewire.credit-application-form');
    }
}
