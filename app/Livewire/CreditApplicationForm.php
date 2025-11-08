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
        'full_name' => 'required|string|min:3|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
        'document_number' => 'required|numeric|digits_between:6,15|unique:credit_applications,document_number',
        'phone' => 'required|numeric|digits_between:7,10|regex:/^[3][0-9]{9}$/',
        'email' => 'required|email:rfc,dns|max:255',
        'city' => 'required|string|in:Cartagena,Barranquilla,Santa Marta,Otra',
        'recaptcha' => 'required|string|min:20',
    ];

    protected $messages = [
        'full_name.required' => 'El nombre completo es obligatorio',
        'full_name.min' => 'El nombre debe tener al menos 3 caracteres',
        'full_name.regex' => 'El nombre solo puede contener letras y espacios',
        'document_number.required' => 'La cédula es obligatoria',
        'document_number.numeric' => 'La cédula debe contener solo números',
        'document_number.digits_between' => 'La cédula debe tener entre 6 y 15 dígitos',
        'document_number.unique' => 'Ya tenemos tu información registrada. Un asesor se contactará contigo pronto.',
        'phone.required' => 'El teléfono es obligatorio',
        'phone.numeric' => 'El teléfono debe contener solo números',
        'phone.digits_between' => 'El teléfono debe tener entre 7 y 10 dígitos',
        'phone.regex' => 'Ingresa un número de celular colombiano válido (debe iniciar con 3)',
        'email.required' => 'El correo electrónico es obligatorio',
        'email.email' => 'Ingresa un correo válido',
        'city.required' => 'La ciudad es obligatoria',
        'city.in' => 'Selecciona una ciudad válida',
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
        // Sanitizar datos antes de validar
        $this->full_name = trim($this->full_name);
        $this->document_number = preg_replace('/\D/', '', $this->document_number); // Solo dígitos
        $this->phone = preg_replace('/\D/', '', $this->phone); // Solo dígitos
        $this->email = trim(strtolower($this->email));
        $this->city = trim($this->city);

        // Validar datos sanitizados
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

        // Crear registro con datos sanitizados
        CreditApplication::create([
            'full_name' => ucwords(strtolower($this->full_name)),
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
