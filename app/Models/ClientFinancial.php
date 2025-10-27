<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientFinancial extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'month_year', 'total_income', 'salary_income', 'commission_income', 'rental_income', 'other_income', 'total_expenses', 'rent_expense', 'utilities_expense', 'food_expense', 'transport_expense', 'education_expense', 'credit_payments_expense', 'other_expenses', 'disposable_income', 'debt_to_income_ratio', 'payment_capacity'];

    protected $casts = [
        'total_income' => 'encrypted',
        'salary_income' => 'encrypted',
        'total_expenses' => 'encrypted',
        'disposable_income' => 'encrypted',
        'payment_capacity' => 'encrypted',
        'debt_to_income_ratio' => 'decimal:2',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
